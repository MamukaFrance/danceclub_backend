@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <!-- Hero -->
    <section class="py-4 text-center container mx-auto">
        <h1 class="text-4xl font-bold">Nous Contacter</h1>
        <p class="text-lg">
            Envoyez-nous un message et nous vous répondrons rapidement.
        </p>
    </section>

    <x-alert/>

    <!-- Formulaire -->
    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <form method="POST" action="{{ route('mail.send') }}">
            @csrf

            <!-- Nom -->
            <div class="mb-4">
                <label for="name" class="block mb-2 font-semibold text-gray-700">
                    Nom
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Votre nom"
                    class="w-full px-4 py-2 text-base text-gray-700 border border-gray-300 rounded-md placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900"
                >

                @error('name')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block mb-2 font-semibold text-gray-900">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="votre@email.com"
                    class="w-full px-4 py-2 text-base text-gray-700 border border-gray-300 rounded-md placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900"
                >

                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Message -->
            <div class="mb-4">
                <label for="message" class="block mb-2 font-semibold text-gray-700">
                    Message
                </label>

                <textarea
                    id="message"
                    name="message"
                    placeholder="Votre message ici..."
                    class="w-full px-4 py-2 text-base text-gray-700 border border-gray-300 rounded-md min-h-30 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900"
                >{{ old('message') }}</textarea>

                @error('message')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>


            <!-- Bouton -->
            <button
                type="submit"
                class="bg-blue-700 text-white px-6 py-3 rounded-md hover:bg-blue-900 transition font-semibold"
            >
                Envoyer
            </button>
        </form>
    </div>
@endsection
