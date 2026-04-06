@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
    <div class="max-w-xl mx-auto px-4 py-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Edit Event
        </h1>
        <x-alert/>

        <form method="POST"
            action="{{ route('events.update', $event) }}"
            class="bg-white shadow-md rounded-xl p-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block mb-1 font-semibold text-gray-700">
                    Title
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $event->title ?? '') }}"
                    class="w-full px-4 py-2 border rounded-md @error('title') border-red-500 @enderror"
                >

                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Description</label>

                <textarea
                    name="description"
                    class="w-full px-4 py-2 border rounded-md"
                >{{ old('description', $event->description ?? '') }}</textarea>

                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="date" class="block mb-1 font-semibold text-gray-700">
                    Date
                </label>

                <input
                    type="date"
                    id="date"
                    name="date"
                    value="{{ old('date', $event->date ?? '') }}"
                    class="w-full px-4 py-2 border rounded-md @error('date') border-red-500 @enderror"
                >

                @error('date')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="start_time" class="block mb-1 font-semibold text-gray-700">
                    Start time
                </label>

                <input
                    type="text"
                    id="start_time"
                    name="start_time"
                    value="{{ old('start_time', $event->start_time ?? '') }}"
                    class="w-full px-4 py-2 border rounded-md @error('start_time') border-red-500 @enderror"
                >

                @error('start_time')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="end_time" class="block mb-1 font-semibold text-gray-700">
                    End time
                </label>

                <input
                    type="text"
                    id="end_time"
                    name="end_time"
                    value="{{ old('end_time', $event->end_time ?? '') }}"
                    class="w-full px-4 py-2 border rounded-md @error('end_time') border-red-500 @enderror"
                >

                @error('end_time')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="capacity" class="block mb-1 font-semibold text-gray-700">
                    Capacity
                </label>

                <input
                    type="number"
                    id="capacity"
                    name="capacity"
                    value="{{ old('capacity', $event->capacity ?? '') }}"
                    class="w-full px-4 py-2 border rounded-md @error('capacity') border-red-500 @enderror"
                >

                @error('capacity')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
                    

            {{-- Actions --}}
            <div class="flex justify-between items-center pt-4">
                <x-button type="submit" variant="primary">
                    Mettre à jour
                </x-button>
                <x-button 
                    type="reset"
                    variant="reset">
                    Réinitialiser
                </x-button>
                <x-button href="{{ route('events.show', $event) }}"
                    variant="secondary">
                    Retour
                </x-button>
            </div>
        </form>
    </div>
@endsection