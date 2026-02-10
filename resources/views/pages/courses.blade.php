@extends('layouts.app')

@section('title', 'Créer un post')

@section('content')

{{-- Affichage des cours existants --}}
<h2 class="text-2xl font-bold text-center my-6">Cours disponibles</h2>
<x-alert/>
<div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 justify-items-center mt-8">
    
    
    @foreach ($courses as $course)
        <div class="max-w-md group relative mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-lg">
            
            <!-- Titre -->
            <h3 class="mb-2 text-xl font-semibold text-gray-900 group-hover:text-indigo-600 transition">
                {{ $course->title }}
            </h3>

             <!-- Bouton de réservation -->
                <form class="flex justify-end my-4" action="{{route('courses.reserve', $course)}}" method="POST">
                    @csrf
                    <button type="submit" class="mt-4 max-w-sm rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 transition">
                        Réserver
                    </button>
                </form>

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

            <div class="flex justify-between flex-wrap gap-2 mt-4 items-center">
                <!-- Bouton de modification -->
                <a href="{{ route('course.edit', $course) }}" class="mt-4 max-w-sm rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 transition">
                    {{isset($course) ? 'Modifier' : 'Créer'}}
                </a>

               

                <!-- Bouton de suppression -->
                <form action="{{ route('course.destroy', $course) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="mt-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                        onclick="return confirm('Voulez-vous vraiment supprimer ce post ?')"
                    >
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>