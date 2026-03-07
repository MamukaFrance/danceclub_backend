@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">

        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Connexion
        </h1>

        {{-- Message d’erreur --}}
        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 text-red-700 p-3 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    placeholder="john@example.com"
                    required
                    class="mt-1 px-4 py-2 w-full text-gray-900 border rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            {{-- Mot de passe --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Mot de passe
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    placeholder="Votre mot de passe"
                    required
                    class="mt-1 w-full px-4 py-2 text-gray-900 border rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            {{-- Bouton --}}
            <button
                type="submit"
                class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition"
            >
                Se connecter
            </button>
        </form>

        {{-- Lien inscription (optionnel) --}}
        <p class="mt-6 text-center text-sm text-gray-600">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">
                S’inscrire
            </a>
        </p>

    </div>
</div>
@endsection
