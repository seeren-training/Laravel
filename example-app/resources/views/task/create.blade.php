@extends('layouts.app')

@section('title', 'New Task')

@section('content')

    <section class="hero is-fullheight-with-navbar is-dark">
        <div class="hero-body">
            <div class="column is-full">
                <p class="title mb-6">
                    New Task
                </p>
                <p class="subtitle columns">
                    {{ Form::model($task, [
                        'route' => 'task.store',
                        'class' => 'column is-two-thirds',
                    ]) }}
                <div class="field">
                    {{ Form::label('name', 'Name', [
                        'class' => 'label has-text-white',
                    ]) }}
                    @error('name')
                        <div class="notification is-danger">{{ $message }}</div>
                    @enderror
                    <div class="control">
                        {{ Form::text('name', null, [
                            'class' => 'input',
                            'placeholder' => 'Task Name',
                            'name' => 'name',
                        ]) }}
                    </div>
                </div>
                <div class="field">
                    {{ Form::label('description', 'Description', [
                        'class' => 'label has-text-white',
                    ]) }}
                    @error('description')
                        <div class="notification is-danger">{{ $message }}</div>
                    @enderror
                    <div class="control">
                        {{ Form::text('description', null, [
                            'class' => 'input',
                            'placeholder' => 'Task Name',
                            'name' => 'description',
                        ]) }}
                    </div>
                </div>
                <div class="field mt-4">
                    <div class="control">
                        {{ Form::submit('Create', [
                            'class' => 'button is-link',
                        ]) }}
                    </div>
                </div>
            </div>
            {{ Form::close() }}
            </p>
        </div>
        </div>
    </section>
@endsection
