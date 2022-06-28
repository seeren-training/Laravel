<?php

namespace App\Repository;

use App\Models\State;
use Illuminate\Database\Eloquent\Collection;

class StateRepository
{

    public function findAll(): Collection
    {
        return State::get();
    }

    public function find(int $id): ?State
    {
        return State::find($id);
    }

    public function findOneByValue(string $value): ?State
    {
        return State::get()->where('value', $value)->first();
    }
}
