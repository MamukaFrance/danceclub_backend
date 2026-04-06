@extends('layouts.app')

@section('title', 'Créer/Modifier un course')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md my-16">
    <x-alert/>
    <h2 class="text-2xl font-bold mb-6 text-center">
        Modifier un cours
    </h2>

    {{-- Formulaire --}}
    <form action="{{ route('courses.update', $course) }}" 
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
                value="{{ old('title', $course->title) }}"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900"
            >   
        </div>
        <div class="mb-4">
            <label for="style" class="block mb-2 font-semibold text-gray-700">Style</label>
            <input
                id="style"
                type="text"
                name="style" 
                placeholder="Style"
                value="{{ old('style', $course->style) }}" 
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900" >
        </div>
       <div class="mb-4">
            <label for="level" class="block mb-2 font-semibold text-gray-700">
                Niveau
            </label>

            <select
                id="level"
                name="level"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900"
                    >

                <option value="beginner"
                    {{ old('level'), $course->level == 'beginner' ? 'selected' : '' }}>
                    Débutant
                </option>

                <option value="intermediate"
                    {{ old('level'), $course->level == 'intermediate' ? 'selected' : '' }}>
                    Intermédiaire
                </option>

                <option value="advanced"
                    {{ old('level'), $course->level == 'advanced' ? 'selected' : '' }}>
                    Avancé
                </option>
            </select>
        </div>

        <div class="mb-4">
            <label for="capacity" class="block mb-2 font-semibold text-gray-700">Capacité</label>
            <input
                id="capacity"
                type="text"
                name="capacity" 
                placeholder="Capacité"
                value="{{ old('capacity', $course->capacity ) }}" 
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900" >
        </div>

        


        {{-- Contenu --}}
        <div class="mb-4">
            <label for="description" class="block mb-2 font-semibold text-gray-700">Contenu</label>
            <textarea 
                id="description"
                name="description" 
                placeholder="Contenu"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-900"
            >{{ old('description', $course->description ) }}</textarea>  
        </div>

        {{-- Bouton --}}
        <button
            type="submit"
            class="bg-blue-700 text-white px-6 py-3 rounded-md hover:bg-blue-900 transition font-semibold">
            Mettre à jour        
        </button>
    </form>
</div>
@endsection
