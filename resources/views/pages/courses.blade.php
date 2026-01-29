@extends('layouts.app')

@section('title', 'Créer un post')

@section('content')

{{-- Affichage des cours existants --}}
<h2 class="text-2xl font-bold text-center my-6">Cours disponibles</h2>
<div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 justify-items-center mt-8">
    
    @foreach ($courses as $course)
        <div class="max-w-md group relative mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-lg">
            
            <!-- Titre -->
            <h3 class="mb-2 text-xl font-semibold text-gray-900 group-hover:text-indigo-600 transition">
                {{ $course->title }}
            </h3>

            <!-- Description -->
            <p class="text-gray-600 leading-relaxed">
                {{ $course->description }}
            </p>

            <!-- Ligne décorative -->
            <div class="mt-4 h-px w-full bg-linear-to-r from-indigo-500 via-purple-500 to-pink-500 opacity-70"></div>

        </div>
    @endforeach
</div>