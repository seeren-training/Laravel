<?php

namespace App\Repository;

use App\Models\State;
use App\Models\Task;

class TaskRepository
{

    public function find(int $id): ?Task
    {
        return Task::find($id);
    }

    public function remove(Task $task): bool
    {
        return $task->delete();
    }

    public function persist(Task $task, State $state = null): bool
    {
        if ($state) {
            $task->state()->associate($state);
        }
        return $task->save();
    }
}
