<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class TaskController extends Controller
{

    public function index(): View
    {
        return view('task.index');
    }


    public function create(): View
    {
        return view('task.create', [
        ]);
    }

    public function show(int $id): View
    {
        return view('task.show', [
            'id' => $id
        ]);
    }


    public function edit(int $id): View
    {
        return view('task.edit', [
        ]);
    }
    public function delete(int $id): View
    {
        die('destroy');
    }

}
