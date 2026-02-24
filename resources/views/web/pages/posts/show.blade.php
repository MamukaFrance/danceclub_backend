@extends('layouts.app')

@section('title', 'Détails de Post')

@section('content')
<div class="max-w-md mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Informations du post</h1>
    <x-card 
        image="{{ $post->image ? asset('storage/' . $post->image) : null }}" 
        title="{{ $post->title }}"
        >
        <p>{{ $post->content }}</p>
        <p class="text-gray-500 text-sm my-3">
            Publié le : {{ $post->created_at->format('d/m/Y H:i') }}
        </p>
        @if($post->updated_at != $post->created_at)
            <p class="text-gray-500 text-sm">
                Modifié le : {{ $post->updated_at->format('d/m/Y H:i') }}
            </p>
        @endif
    </x-card>

    {{-- Actions CRUD --}}
    <div class="mt-6 flex space-x-2">
        @can('update', $post)
            <a href="{{ route('posts.edit', $post->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Modifier
            </a>
        @endcan
        @can('delete', $post)
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Supprimer</button>
            </form>
        @endcan

        <a href="{{ route('posts.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Retour à la liste
        </a>
    </div>
</div>
@endsection


