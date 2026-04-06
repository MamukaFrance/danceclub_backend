@extends('layouts.app')

@section('title', isset($post) ? 'Modifier un post' : 'Créer un post')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md my-16">
    <x-alert/>
     <h2 class="text-2xl font-bold mb-6 text-center">
        Créer un post
    </h2>
    {{-- Formulaire --}}
    <form action="{{ route('posts.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
    >
        @csrf

        {{-- Titre --}}
        <div class="mb-4">
            <label for="title" class="block mb-2 font-semibold text-gray-700">Titre</label>
            <input 
                id="title"
                type="text" 
                name="title" 
                placeholder="Titre"
                value="{{ old('title') }}"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900"
            >   
        </div>

        {{-- Contenu --}}
        <div class="mb-4">
            <label for="content" class="block mb-2 font-semibold text-gray-700">Contenu</label>
            <textarea 
                id="content"
                name="content" 
                placeholder="Contenu"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900"
            >{{ old('content') }}</textarea>  
        </div>

        {{-- Image --}}
        <div class="mb-4">
            <label for="image" class="block mb-2 font-semibold text-gray-700">Image</label>
            <input 
                id="image"
                type="file" 
                name="image"
                accept="image/*"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900"
            >   

            {{-- Aperçu de l'image choisie --}}
            <div class="mt-4">
                <p id="title-preview" class="mb-2 font-semibold text-gray-700 hidden">Image prévisualisée :</p>
                <img id="image-preview" class="max-w-full max-h-64 h-auto rounded-md hidden">
            </div>
        </div>

        {{-- Boutons --}}
        <div class="mt-6 flex items-center justify-between">
            <x-button type="submit" variant="primary">
                Publier
            </x-button>
             <x-button href="{{ route('posts.index') }}" variant="secondary">
                Retour à la liste
            </x-button>
        </div>
    </form>
</div>
@endsection
