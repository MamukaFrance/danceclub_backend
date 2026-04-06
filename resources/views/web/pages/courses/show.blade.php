@extends('layouts.app')

@section('title', 'Détails de Course')

@section('content')
    <div class="mt-4 flex flex-col items-center">
        <h1 class="mb-4 text-center text-2xl font-bold text-gray-800">
            Détails de Course
        </h1>
                
        <div class="max-w-md w-full bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition">

            <p class="text-sm text-gray-600">
                <span class="font-medium">Teacher id :</span>
                {{ $course->teacher->name ?? '-' }}
            </p>
            <p class="text-sm text-gray-600">
                <span class="font-medium">Title :</span>
                {{ $course->title }}
            </p>
            <p class="text-sm text-gray-600">
                <span class="font-medium">Style :</span>
                {{ $course->style }}
            </p>
            <p class="text-sm text-gray-600">
                <span class="font-medium">Level :</span>
                {{ $course->level }}
            </p>
            <p class="text-sm text-gray-600">
                <span class="font-medium">Capacity :</span>
                {{ $course->capacity }}
            </p>
            <p class="text-sm text-gray-600">
                <span class="font-medium">Date :</span>
                {{ $course->date?->format('d/m/Y') }}
            </p>
            <p class="text-sm text-gray-600">
                <span class="font-medium">Start time :</span>
                {{ $course->start_time }}
            </p>
            <p class="text-sm text-gray-600">
                <span class="font-medium">End time :</span>
                {{ $course->end_time }}
            </p>
            <p class="text-sm text-gray-600">
                <span class="font-medium">Description :</span>
                {{ $course->description }}
            </p>
            <p class="text-sm text-gray-600">
                <span class="font-medium">Remaining seats :</span>
                {{ $course->remaining_seats }}
            </p>

            <div class="flex justify-between items-center gap-2 mt-4">
               
                @can('update', $course)
                <x-button href="{{ route('courses.edit', $course) }}"
                    variant="primary">
                    Modifier
                </x-button>
                @endcan

                <form action="{{ route('courses.destroy', $course) }}"
                    method="POST"
                    onsubmit="return confirm('Supprimer cet course ?')">
                    @csrf
                    @method('DELETE')
                    @can('delete', $course)
                        <x-button
                            type="submit"
                            variant="danger">
                            Supprimer
                        </x-button>
                    @endcan
                </form>
                <x-button href="{{ route('courses.index') }}"
                    variant="secondary">
                    Retour à la liste
                </x-button>
            </div>
        </div>
    </div>
@endsection


