@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white rounded shadow-lg p-6 text-center">

            <!-- Icône -->
            <div class="flex justify-center mb-4">
                <div class="bg-red-100 text-red-600 rounded-full p-4">
                    ❌
                </div>
            </div>

            <!-- Titre -->
            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Token invalide
            </h2>

            <!-- Message -->
            <p class="text-gray-600 mb-4">
                Le lien de check-in est invalide ou a expiré.
            </p>

            <!-- Infos -->
            <div class="bg-gray-50 rounded p-4 text-sm text-gray-500">
                Vérifiez que vous utilisez le bon lien ou contactez l’organisateur de l’événement.
            </div>

            

        </div>
    </div>

@endsection