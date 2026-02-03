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
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900"
                >
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block mb-2 font-semibold text-gray-700">
                    Email
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900"
                >
            </div>

            <!-- Message -->
            <div class="mb-2">
                <label for="message" class="block mb-2 font-semibold text-gray-700">
                    Message
                </label>
                <textarea
                    id="message"
                    name="message"
                    rows="5"
                    placeholder="Votre message ici..."
                    value="{{ old('message') }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900"
                ></textarea>
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
