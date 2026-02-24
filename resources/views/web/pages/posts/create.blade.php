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
                onchange="previewImage(event)"
            >   

            {{-- Aperçu de l'image choisie --}}
            <div class="mt-4">
                <p id="title-preview" class="mb-2 font-semibold text-gray-700 hidden">Image prévisualisée :</p>
                <img id="image-preview" class="max-w-full max-h-64 h-auto rounded-md hidden">
            </div>
        </div>

        {{-- Boutons --}}
        <div class="mt-6 flex justify-between">
            <button
                type="submit"
                class="px-5 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-900 transition"
            >
                Publier         
            </button>
            <a href="{{ route('posts.index') }}"
                type="button"
                class="px-5 py-2.5  bg-gray-500 text-white rounded-lg hover:bg-gray-700 transition">
                    Retour à la liste
            </a>
        </div>
    </form>
</div>

{{-- Script JS pour aperçu de l'image --}}
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('image-preview');
        const titlePreview = document.getElementById('title-preview');
        const imgActuelle = document.getElementById('image-actuelle');
        

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden'); // montrer l'image
                titlePreview.classList.remove('hidden'); 
                imgActuelle.classList.add('hidden'); // cacher l'image actuelle si en édition 
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.classList.add('hidden'); // cacher si plus d'image
            titlePreview.classList.add('hidden');
            imgActuelle.classList.remove('hidden'); // montrer l'image actuelle si en édition
        }
    }
</script>
@endsection
