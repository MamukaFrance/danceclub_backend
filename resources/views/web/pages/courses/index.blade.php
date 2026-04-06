@extends('layouts.app')

@section('title', 'Créer un post')

@section('content')

<div class="container mx-auto px-4 py-6">

    {{-- Affichage des cours existants --}}
    <div class="flex justify-center items-center gap-6 mb-6">
        <h2 class="text-2xl font-bold text-center my-6">Cours disponibles</h2>
        <a href="{{ route('courses.create') }}"
                type="button"
                class="px-3 py-1.5 text-sm bg-green-500 text-white rounded hover:bg-green-600 transition">
                Créer un cours
            </a>
    </div>

    <x-alert/>
    
    @if($courses->isEmpty())
        <p class="text-center text-gray-500">Aucun cours pour le moment.</p>
    @else
        <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 justify-items-center mt-8"> 
            @foreach ($courses as $course)
                <div class="max-w-md group relative mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-lg">
                    
                    <!-- Titre -->
                    <h3 class="mb-2 text-xl font-semibold text-gray-900 group-hover:text-indigo-600 transition">
                        {{ $course->title }}
                    </h3>

                    <!-- Bouton de réservation -->
                    <x-course-reserve-button :course="$course" />

                    <!-- Description -->
                    <p class="text-gray-600 leading-relaxed">
                        {{ $course->description }}
                    </p>

                    <!-- Ligne décorative -->
                    <div class="mt-4 h-px w-full bg-linear-to-r from-indigo-500 via-purple-500 to-pink-500 opacity-70"></div>

                    <!-- Places restantes -->
                    <p class="mt-4 text-gray-700">
                        {{ $course->remaining_seats }} places restantes sur {{ $course->capacity }}.
                    </p>

                    <div class="flex justify-end mt-4">
                        <a href="{{ route('courses.show', $course) }}"
                            class="px-3 py-1.5 text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                            Détails
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection