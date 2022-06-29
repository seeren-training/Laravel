<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskPostRequest;
use App\Http\Requests\TaskPutRequest;
use App\Models\Task;
use App\Service\Core\CSRFValidator;
use App\Service\Domain\StateDomainService;
use App\Service\Domain\TaskDomainService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{

    public function createRandom(
        TaskDomainService $taskDomainService
    ): RedirectResponse {
        $taskDomainService->insertRandom();
        return redirect()->route('task.index');
    }

    public function index(
        StateDomainService $stateDomainService
    ): View {
        $stateList = $stateDomainService->getAll();
        return view('task.index', [
            'stateList' => $stateList,
            'taskCount' => $stateDomainService->countTask($stateList)
        ]);
    }

    public function show(
        int $id,
        TaskDomainService $taskDomainService
    ): RedirectResponse | View {
        return ($task = $taskDomainService->get($id))
            ? view('task.show', [
                'task' => $task
            ])
            : redirect()->route('task.index');
    }

    public function delete(
        int $id,
        Request $request,
        CSRFValidator $csrfValidator,
        TaskDomainService $taskDomainService
    ): RedirectResponse {
        if ($csrfValidator->isValid($request)) {
            $taskDomainService->remove($id);
        }
        return redirect()->route('task.index');
    }

    public function next(
        int $id,
        Request $request,
        CSRFValidator $csrfValidator,
        TaskDomainService $taskDomainService
    ): RedirectResponse {
        return $csrfValidator->isValid($request)
            && $taskDomainService->upgradeState($id)
            ? redirect()->route('task.show', [
                'id' => $id
            ])
            : redirect()->route('task.delete', [
                'id' => $id,
                'token' => $request->input('token')
            ]);
    }

    public function previous(
        int $id,
        Request $request,
        CSRFValidator $csrfValidator,
        TaskDomainService $taskDomainService
    ): RedirectResponse {

        return $csrfValidator->isValid($request)
            && $taskDomainService->downgradeState($id)
            ? redirect()->route('task.show', [
                'id' => $id
            ])
            : redirect()->route('task.delete', [
                'id' => $id,
                'token' => $request->input('token')
            ]);
    }

    public function create(): View
    {
        return view('task.create', [
            'task' => new Task()
        ]);
    }

    public function store(
        TaskPostRequest $request,
        TaskDomainService $taskDomainService
    ): RedirectResponse {
        $validated = $request->validated();
        $task = new Task($validated);
        $taskDomainService->insert($task);
        return redirect()->route('task.show', [
            'id' => $task->id
        ]);
    }

    public function edit(
        int $id,
        TaskDomainService $taskDomainService
    ): View {
        return view('task.edit', [
            'task' => $taskDomainService->get($id)
        ]);
    }

    public function update(
        int $id,
        TaskPutRequest $request,
        TaskDomainService $taskDomainService
    ) {
        $task = $taskDomainService->get($id);
        if ($task) {
            $task->fill($request->validated());
            $taskDomainService->update($task);
        }
        return redirect()->route('task.show', [
            'id' => $id
        ]);
    }

}
