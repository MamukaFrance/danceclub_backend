@extends('layouts.app')

@section('title', 'Créer un post')

@section('content')

{{-- Affichage des posts existants --}}
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-center items-center gap-6 mb-6">
        <h2 class="text-2xl font-bold text-center">Tous les posts</h2>
        <x-button href="{{ route('posts.create') }}"
            variant="primary"
            class="bg-green-500 hover:bg-green-600">
            Créer un post
        </x-button>
    </div>
    <x-alert/>
    @if($posts->isEmpty())
        <p class="text-center text-gray-500">Aucun post pour le moment.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center items-start">
            @foreach($posts as $post)
                <x-card 
                    image="{{ $post->image ?? null }}" 
                    title="{{ $post->title }}"
                    >
                    {{ $post->content }}

                    <p class="text-gray-500 text-sm my-3">
                        Publié le : {{ $post->created_at->format('d/m/Y H:i') }}
                    </p>
                    @if($post->updated_at != $post->created_at)
                        <p class="text-gray-500 text-sm my-3">
                            Modifié le : {{ $post->updated_at->format('d/m/Y H:i') }}
                        </p>
                    @endif
                    <div class="flex justify-end mt-4">
                        <x-button href="{{ route('posts.show', $post) }}"
                            variant="primary">
                            Détails
                        </x-button>
                    </div>
                    
                </x-card>
            @endforeach
        </div>
    @endif
</div>
@endsection
