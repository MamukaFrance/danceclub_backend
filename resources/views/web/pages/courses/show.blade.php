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
                    <a href="{{ route('courses.edit', $course) }}"
                        class="px-3 py-1.5 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                        Éditer
                    </a>
                @endcan

                <form action="{{ route('courses.destroy', $course) }}"
                    method="POST"
                    onsubmit="return confirm('Supprimer cet course ?')">
                    @csrf
                    @method('DELETE')
                    @can('delete', $course)
                        <button type="submit"
                            class="px-3 py-1.5 text-sm bg-red-500 text-white rounded hover:bg-red-600 transition">
                            Supprimer
                        </button>
                    @endcan
                </form>
                <a href="{{ route('courses.index') }}" 
                    class="px-3 py-1.5 text-sm bg-gray-500  text-white rounded hover:bg-gray-600 transition">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
@endsection


