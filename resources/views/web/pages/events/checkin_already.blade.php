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
            <h2>Ce participant a deja fait son checkin sur l'event</h2> 
        </div>
    </div>
@endsection