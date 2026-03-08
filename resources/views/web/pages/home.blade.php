@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="relative w-full container mx-auto h-[60vh] overflow-hidden mb-10">
        <!-- Vidéo -->
        <!-- <video 
            class="w-full h-[60vh] object-cover"
            autoplay
            muted
            loop
            playsinline
        >
            <source src="https://youtu.be/hCDBeKenL94?si=_Jc9bhCQyiCuzIhp" type="video/mp4">
            Votre navigateur ne supporte pas la vidéo.
        </video> -->

        <iframe
            class="w-full h-[60vh]"
            src="https://www.youtube.com/embed/hCDBeKenL94?autoplay=1&mute=1&loop=1&playlist=hCDBeKenL94"
            title="YouTube video"
            frameborder="0"
            allow="autoplay; encrypted-media"
            allowfullscreen>
        </iframe>

        <!-- Overlay texte -->
        <div class="absolute inset-0 flex items-center justify-center bg-black/40">
            <h2 class="text-white text-4xl font-bold text-center">
                Bienvenue au Dance Club
            </h2>
        </div>
    </section>
    
    <x-section-image-text 
        image="{{ Vite::asset('resources/images/mon-image.jpg') }}" 
        title="Titre de ma section"
        link="#"
        linkText="Voir plus"
    >
    Ceci est le texte de ma section. Il peut contenir plusieurs phrases.
    </x-section-image-text>

    <section class="container mx-auto my-10">
        <h2 class="text-3xl font-bold mb-6 text-center">Nos Cours Populaires</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 justify-items-center ">
        <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 justify-items-center items-start"> -->
        <!-- <div class="columns-1 md:columns-3 gap-6 space-y-6"> -->
            <x-card 
                image="{{ Vite::asset('resources/images/mon-image.jpg') }}" 
                title="Cours de Salsa"
            >
                Apprenez les bases de la <strong>salsa</strong> avec nos instructeurs expérimentés.
            </x-card>

            <x-card 
                image="{{ Vite::asset('resources/images/mon-image.jpg') }}" 
                title="Cours de Hip-Hop"
            >
                Rejoignez nos cours de hip-hop pour tous les niveaux.
            </x-card>

            <x-card 
                image="{{ Vite::asset('resources/images/mon-image.jpg') }}" 
                title="Cours de Ballet"
            >
                Découvrez la grâce et la discipline du ballet classique.
            </x-card>

            <x-card 
                image="{{ Vite::asset('resources/images/mon-image.jpg') }}" 
                title="Cours de Ballet"
            >
                Découvrez la grâce et la discipline du ballet classique.
            </x-card>

            <x-card 
                image="{{ Vite::asset('resources/images/mon-image.jpg') }}" 
                title="Cours de Ballet"
            >
                Découvrez la grâce et la discipline du ballet classique.
            </x-card>
        </div>

    
@endsection



