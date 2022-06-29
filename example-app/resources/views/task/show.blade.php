@extends('layouts.app')

@section('title', 'Task ' . $task->id)

@section('content')

    <section
        class="hero is-fullheight-with-navbar is-{{ 'TODO' === $task->state->value ? 'danger' : ('DOING' === $task->state->value ? 'info' : 'success') }}">
        <div class="hero-body">
            <div>
                <p class="title mb-6">
                    {{ $task->state->value }}: {{ $task->name }}
                </p>
                <p class="subtitle is-size-6">
                    Created: {{ $task->created_at }}
                </p>
                <p class="subtitle is-size-6">
                    Updated: {{ $task->updated_at }}
                </p>
                <p class="subtitle">
                    {{ $task->description }}
                </p>
                <p class="subtitle">
                    <a href="{{ route('task.previous', ['id' => $task->id]) . '?token=' . csrf_token() }}"
                        class="button is-{{ 'TODO' === $task->state->value ? 'dark' : ('DOING' === $task->state->value ? 'danger' : 'info') }}">
                        {{ 'TODO' === $task->state->value ? 'DELETE' : ('DOING' === $task->state->value ? 'TODO' : 'DOING') }}
                    </a>
                    <a href="{{ route('task.edit', ['id' => $task->id]) }}" class="button is-light">
                        Edit
                    </a>
                    <a href="{{ route('task.next', ['id' => $task->id]) . '?token=' . csrf_token() }}"
                        class="button is-{{ 'TODO' === $task->state->value ? 'info' : ('DOING' === $task->state->value ? 'success' : 'dark') }}">
                        {{ 'TODO' === $task->state->value ? 'DOING' : ('DOING' === $task->state->value ? 'DONE' : 'DELETE') }}
                    </a>
                </p>
            </div>
        </div>
    </section>
@endsection
