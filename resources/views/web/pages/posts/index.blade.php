@extends('layouts.app')

@section('title', 'Créer un post')

@section('content')

{{-- Affichage des posts existants --}}
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center my-4">
        <h2 class="text-2xl font-bold text-center">Tous les posts</h2>
        <a href="{{ route('posts.create') }}"
            type="button"
            class="px-3 py-1.5 text-sm bg-green-500 text-white rounded hover:bg-green-600 transition">
            Créer un Post
        </a>
    </div>
    <x-alert/>
    @if($posts->isEmpty())
        <p class="text-center text-gray-500">Aucun post pour le moment.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center items-start">
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
                    <a href="{{ route('posts.show', $post) }}"
                        class="px-3 py-1.5 text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                        Voir
                    </a>
                    <div class="flex flex-wrap justify-between">
                        @can('update', $post)
                            <a type="button" href="{{ route('posts.edit', $post->id) }}" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mr-2 rounded">
                                Modifier
                            </a>
                        @endcan
                        @can('delete', $post)
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
                        @endcan
                    </div>
                </x-card>
            @endforeach
        </div>
    @endif
</div>
@endsection
