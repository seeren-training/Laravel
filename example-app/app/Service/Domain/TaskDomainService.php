<?php

namespace App\Service\Domain;

use App\Models\Task;
use App\Repository\TaskRepository;

class TaskDomainService
{

    public function __construct(
        private TaskRepository $taskRepository,
        private StateDomainService $stateDomainService
    ) {
    }

    public function get(int $id): ?Task
    {
        return $this->taskRepository->find($id);
    }

    public function remove(int $id): bool
    {
        return ($task = $this->get($id))
            ? $this->taskRepository->remove($task)
            : false;
    }

    public function insertRandom(): bool
    {
        return $this->taskRepository->persist(
            new Task([
                'name' => 'Bring Coffee',
                'description' => 'You have to bring coffee on the morning'
            ]),
            $this->stateDomainService->getDefault()
        );
    }

    public function insert(Task $task): bool
    {
        return $this->taskRepository->persist(
            $task,
            $this->stateDomainService->getDefault()
        );
    }

    public function upgradeState(int $id): bool
    {
        return ($task = $this->get($id))
            && ($state = $this->stateDomainService->get($task->state->id + 1))
            ? $this->taskRepository->persist($task, $state)
            : false;
    }

    public function downgradeState(int $id): bool
    {
        return ($task = $this->get($id))
            && ($state = $this->stateDomainService->get($task->state->id - 1))
            ? $this->taskRepository->persist($task, $state)
            : false;
    }
}
