@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white rounded shadow-lg p-6 text-center">

            <!-- Icône -->
            <div class="flex justify-center mb-4">
                <div class="bg-green-100 text-green-600 rounded-full p-4">
                    ✅
                </div>
            </div>

            <!-- Titre -->
            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Présence validée
            </h2>

            <!-- Infos -->
            <div class="mt-4 text-gray-600">
                <p>
                    <span class="font-semibold text-gray-800">Participant :</span><br>
                    {{ $participant->user->name }}
                </p>

                <p>
                    <span class="font-semibold text-gray-800">Événement :</span><br>
                    {{ $participant->event->title }}
                </p>

                <p>
                    <span class="font-semibold text-gray-800">Date :</span><br>
                    {{ \Carbon\Carbon::parse($participant->event->date)->format('d/m/Y') }}
                </p>
            </div>

            <!-- Bouton -->
            <div class="mt-6">
                <a href="{{ route('home') }}"
                class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded transition">
                    Retour à l'accueil
                </a>
            </div>

        </div>
    </div>

@endsection