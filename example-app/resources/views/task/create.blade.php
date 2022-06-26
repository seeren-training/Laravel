@extends('layouts.app')

@section('title', 'New Task')

@section('content')

<h1>New task</h1>

<form action="" method="post">

    @csrf
    <button class="button is-primary">Envoyer</button>
</form>
@endsection