@extends('layouts.app')

@section('title', 'Create event')

@section('content')
    <h1>Create event</h1>

    <form method="POST" action="{{ route('event.store') }}">
        @csrf

        <div>
            <label for="title">Title</label>
            <input type="text" name="title">
        </div>

        <div>
            <label for="date">Date</label>
            <input type="Date" name="date">
        </div>

        <div>
            <label for="capacity">Capacity</label>
            <input type="integer" name="capacity">
        </div>

        <button type="submit">Save</button>
    </form>
@endsection
