@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">

        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Inscription
        </h1>

        {{-- Messages d’erreurs --}}
        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 text-red-700 p-3 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            {{-- Nom --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Nom
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    required
                    class="px-4 py-2 mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

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
                    required
                    class="px-4 py-2 mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
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
                    required
                    class="px-4 py-2 mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            {{-- Confirmation --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                    Confirmer le mot de passe
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    required
                    class="px-4 py-2 mt-1 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>

            {{-- Bouton --}}
            <button
                type="submit"
                class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition"
            >
                S’inscrire
            </button>
        </form>

        {{-- Lien connexion --}}
        <p class="mt-6 text-center text-sm text-gray-600">
            Déjà un compte ?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">
                Se connecter
            </a>
        </p>

    </div>
</div>
@endsection
