@extends('layouts.app')

@section('title', 'Task List')

@section('content')
    <section class="hero is-primary mb-4">
        <div class="hero-body">
            <p class="title">
                Task List
            </p>
            <p class="subtitle">
                @if (!$taskCount)
                    There is no Task
                @else
                    {{ $taskCount }} Tasks
                @endif
            </p>
        </div>
    </section>
    <div class="container">
        @if ($taskCount)
            <div class="columns">
                @foreach ($stateList as $state)
                    <ul class="column has-background-light mr-2 is-size-4">
                        <h2 class="has-text-centered mb-4">{{ $state->value }}</h2>
                        @foreach ($state->tasks as $task)
                            <li
                                class="notification is-{{ 'TODO' === $state->value ? 'danger' : ('DOING' === $state->value ? 'info' : 'success') }}">
                                <a
                                    href="{{ route('task.show', [
                                        'id' => $task->id,
                                    ]) }}">
                                    <h6>{{ $task->name }}</h6>
                                    <p class="is-size-6">{{ $task->description }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        @else
            <h2 class="is-size-2">Start by create a Task!</h2>
            <p class="mt-4">
                <a class="button is-link" href="{{ route('task.create') }}">Create a Task</a>
                <a class="button is-info" href="{{ route('task.create_random') }}">Create a Random Task</a>
            </p>
        @endif
    </div>
@endsection
