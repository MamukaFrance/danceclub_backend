@extends('layouts.app')

@section('title', 'Créer un post')

@section('content')

{{-- Affichage des posts existants --}}
<div class="mt-8">
    <h2 class="text-2xl font-bold mb-8 text-center">Tous les posts</h2>
    @if($posts->isEmpty())
        <p class="text-center text-gray-500">Aucun post pour le moment.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 justify-items-center items-start">
            @foreach($posts as $post)
                <x-card 
                    image="{{ $post->image ? asset('storage/' . $post->image) : null }}" 
                    title="{{ $post->title }}"
                >
                    {{ $post->content }}

                    <p class="text-gray-500 text-sm my-3">
                        Publié le : {{ $post->created_at->format('d/m/Y H:i') }}
                    </p>
                    @if($post->updated_at != $post->created_at)
                        <p class="text-gray-500 text-sm">
                            Modifié le : {{ $post->updated_at->format('d/m/Y H:i') }}
                        </p>
                    @endif
                    <div class="flex flex-wrap justify-between">
                        <a type="button" href="{{ route('posts.edit', $post->id) }}" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mr-2 rounded">Modifier</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="mt-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                onclick="return confirm('Voulez-vous vraiment supprimer ce post ?')"
                            >
                                Supprimer
                            </button>
                        </form>
                    </div>
                     <!-- Debug: Afficher le chemin réel -->
                    <!-- @if($post->image)
                        <p class="text-xs text-blue-500">Chemin DB: {{ $post->image }}</p>
                        <p class="text-xs text-green-500">URL finale: {{ asset($post->image) }}</p>
                    @endif -->
                </x-card>
            @endforeach
        </div>
    @endif
</div>
@endsection
