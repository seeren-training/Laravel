@extends('layouts.app')

@section('title', 'Register')

@section('content')

    <section class="hero is-fullheight-with-navbar is-dark">
        <div class="hero-body">
            <div class="column is-full">
                <p class="title mb-6">
                    Authenticate
                </p>
                <p class="subtitle columns">
                    {{ Form::model($user, [
                        'route' => 'security.authenticate',
                        'class' => 'column is-two-thirds',
                    ]) }}
                <div class="field">
                    {{ Form::label('email', 'Email', [
                        'class' => 'label has-text-white',
                    ]) }}
                    @error('email')
                        <div class="notification is-danger">{{ $message }}</div>
                    @enderror
                    <div class="control">
                        {{ Form::email('email', null, [
                            'class' => 'input',
                            'placeholder' => 'Email'
                        ]) }}
                    </div>
                </div>
                <div class="field">
                    {{ Form::label('password', 'Password', [
                        'class' => 'label has-text-white',
                    ]) }}
                    @error('password')
                        <div class="notification is-danger">{{ $message }}</div>
                    @enderror
                    <div class="control">
                        {{ Form::password('password', [
                            'class' => 'input',
                            'placeholder' => 'Password'
                        ]) }}
                    </div>
                </div>
                <div class="field mt-4">
                    <div class="control">
                        {{ Form::submit('Login', [
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
