@extends('layouts.app')

@section('title', 'Liste des Events')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
         <div class="w-full max-w-md bg-white rounded shadow-lg p-6 text-center">
            <!-- Icône -->
            <div class="flex justify-center mb-4">
                <div class="bg-gray-100 text-gray-600 rounded-full p-4">
                    ⚠️
                </div>
            </div>
            <!-- Titre -->
            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Déjà enregistré
            </h2>
            <!-- Message -->
            <p class="text-gray-600 mb-4">
                Ce participant a déjà été enregistré pour cet événement.
            </p>
             <!-- Infos -->
            <div class="mt-4 text-gray-600">
                <p>
                    <span class="font-semibold text-gray-800">Participant :</span>
                    {{ $participant->user->name }}
                </p>

                <p>
                    <span class="font-semibold text-gray-800">Événement :</span>
                    {{ $participant->event->title }}
                </p>

                <p>
                    <span class="font-semibold text-gray-800">Date :</span>
                    {{ \Carbon\Carbon::parse($participant->event->date)->format('d/m/Y') }}
                </p>
            </div>

            

        </div>
    </div>
@endsection