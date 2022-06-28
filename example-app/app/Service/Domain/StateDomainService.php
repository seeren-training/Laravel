<?php

namespace App\Service\Domain;

use App\Models\State;
use App\Repository\StateRepository;
use Illuminate\Database\Eloquent\Collection;

class StateDomainService
{

    const DEFAULT_VALUE = 'TODO';

    public function __construct(
        private StateRepository $stateRepository
    ) {
    }

    public function getAll(): Collection
    {
        return $this->stateRepository->findAll();
    }

    public function get(int $id): ?State
    {
        return $this->stateRepository->find($id);
    }

    public function getDefault(): ?State
    {

        return $this->stateRepository->findOneByValue(self::DEFAULT_VALUE);
    }

    public function countTask(Collection $collection): int
    {
        $taskCount = 0;
        foreach ($collection as $state) {
            $taskCount += count($state->tasks);
        }
        return $taskCount;
    }
}
