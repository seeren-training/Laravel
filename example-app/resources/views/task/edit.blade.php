@extends('layouts.app')

@section('title', 'Task ' . $task->id)

@section('content')

    <section
        class="hero is-fullheight-with-navbar is-{{ 'TODO' === $task->state->value ? 'danger' : ('DOING' === $task->state->value ? 'info' : 'success') }}">
        <div class="hero-body">
            {{ Form::model($task, [
                'route' => ['task.update', $task->id],
                'class' => 'column is-two-thirds',
            ]) }}
            @method('PUT')
            <p class="title mb-6">
                {{ $task->state->value }}:
                @error('name')
                <div class="notification is-danger">{{ $message }}</div>
            @enderror
            {{ Form::text('name', null, [
                'class' => 'input mt-4',
                'placeholder' => 'Task Name',
                'name' => 'name',
            ]) }}
            </p>
            <p class="subtitle is-size-6">
                Created: {{ $task->created_at }}
            </p>
            <p class="subtitle is-size-6">
                Updated: {{ $task->updated_at }}
            </p>
            <p class="subtitle control">
                @error('description')
                <div class="notification is-danger">{{ $message }}</div>
            @enderror
            {{ Form::text('description', null, [
                'class' => 'input',
                'placeholder' => 'Task Name',
                'name' => 'description',
            ]) }}
            <p class="subtitle">
                <a href="{{ route('task.show', ['id' => $task->id]) }}" class="button is-dark">
                    Cancel
                </a>
                {{ Form::submit('Save', [
                    'class' => 'button is-light',
                ]) }}
            </p>
            {{ Form::close() }}
        </div>
    </section>
@endsection
