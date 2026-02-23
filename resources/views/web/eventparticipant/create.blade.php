@extends('layouts.app')

@section('title', 'Create EventParticipant')

@section('content')
    <div class="max-w-xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Create EventParticipant
        </h1>
        <x-alert/>

        <form method="POST" 
            action="{{ route('eventparticipant.store') }}"
            class="bg-white shadow-md rounded-xl p-6 space-y-5">
            @csrf

            <div class="mb-4">
    <label class="block mb-1 font-semibold text-gray-700">Event id</label>

    <select name="event_id" class="w-full px-4 py-2 border rounded-md">
        {{-- options --}}
    </select>

    @error('event_id')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
<div class="mb-4">
    <label class="block mb-1 font-semibold text-gray-700">User id</label>

    <select name="user_id" class="w-full px-4 py-2 border rounded-md">
        {{-- options --}}
    </select>

    @error('user_id')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
<div class="mb-4">
    <label for="status" class="block mb-1 font-semibold text-gray-700">
        Status
    </label>

    <input
        type="text"
        id="status"
        name="status"
        value="{{ old('status', $eventParticipant->status ?? '') }}"
        class="w-full px-4 py-2 border rounded-md @error('status') border-red-500 @enderror"
    >

    @error('status')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>

            <button type="submit" 
                class="mr-4 px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Save
            </button>
            <a href="{{ route('eventparticipant.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">Retour à la liste</a>
        </form>
    </div>
@endsection
