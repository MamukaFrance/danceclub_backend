@extends('layouts.app')

@section('content')

@php
    $config = [
        'success' => [
            'border' => 'border-green-400',
            'color' => 'green',
            'title' => 'Présence validée',
            'icon' => '✓',
            'message' => null,
        ],
        'already' => [
            'border' => 'border-yellow-400',
            'color' => 'yellow',
            'title' => 'Déjà enregistré',
            'icon' => '⚠️',
            'message' => 'Ce participant a déjà été enregistré.',
        ],
        'invalid' => [
            'border' => 'border-red-400',
            'color' => 'red',
            'title' => 'Token invalide',
            'icon' => '❌',
            'message' => 'Le lien de check-in est invalide ou a expiré.',
        ],
    ];

    $current = $config[$status];
@endphp

<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6 text-center border-2 {{ $current['border'] }}">

        <!-- Icône -->
        <div class="flex justify-center mb-4">
            <div class="bg-{{ $current['color'] }}-100 text-{{ $current['color'] }}-600 rounded-full p-4">
                {{ $current['icon'] }}
            </div>
        </div>

        <!-- Titre -->
        <h2 class="text-2xl font-bold text-gray-800 mb-2">
            {{ $current['title'] }}
        </h2>

        <!-- Message -->
        @if($current['message'])
            <p class="text-gray-600 mb-4">
                {{ $current['message'] }}
            </p>
        @endif

        <!-- Infos participant -->
        @isset($participant)
            <div class="mt-4 space-y-2 text-gray-600">
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
        @endisset

        <!-- Bouton -->
        <div class="mt-6">
            <a href="{{ url('/') }}"
               class="inline-block bg-{{ $current['color'] }}-600 hover:bg-{{ $current['color'] }}-700 text-white font-semibold py-2 px-6 rounded-xl transition duration-200">
                Retour à l'accueil
            </a>
        </div>

    </div>
</div>

@endsection