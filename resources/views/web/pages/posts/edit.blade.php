@extends('layouts.app')

@section('title', isset($post) ? 'Modifier un post' : 'Créer un post')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md my-16">
    <x-alert/>
     <h2 class="text-2xl font-bold mb-6 text-center">
        Modifier un post
    </h2>
    {{-- Formulaire --}}
    <form action="{{ route('posts.update', $post) }}" 
        method="POST" 
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        {{-- Titre --}}
        <div class="mb-4">
            <label for="title" class="block mb-2 font-semibold text-gray-700">Titre</label>
            <input 
                id="title"
                type="text" 
                name="title" 
                placeholder="Titre"
                value="{{ old('title', $post->title ) }}"
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
            >{{ old('content', $post->content ) }}</textarea>  
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

        {{-- Image actuelle si en édition --}}
        @if(isset($post) && $post->image)
            <div id="image-actuelle" class="mb-4">
                <p class="mb-2 font-semibold text-gray-700">Image actuelle :</p>
                <img 
                    src="{{ $post->image }}" 
                    alt="Image du post" 
                    class="max-w-full max-h-64 h-auto rounded-md"
                >
            </div>
        @endif

        {{-- Bouton --}}
        <div class="flex justify-between items-center pt-4">
            <button
                type="submit"
                class="bg-blue-700 text-white px-6 py-3 rounded-md hover:bg-blue-900 transition font-semibold"
            >
                Mettre à jour          
            </button>
            <a href="{{ route('posts.index') }}"
                type="button"
                class="px-5 py-2  bg-gray-500 text-white rounded-lg hover:bg-gray-700 transition">
                    Retour à la liste
            </a>
        </div>
    </form>
</div>
@endsection
 