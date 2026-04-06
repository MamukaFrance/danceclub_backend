@extends('layouts.app')

@section('title', 'Détails de Post')

@section('content')
<div class="max-w-md mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4 text-center">Informations du post</h1>
    <x-card 
        image="{{ $post->image ?? null }}" 
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
    <div class="mt-6 flex justify-between items-center flex-wrap gap-2">
        @can('update', $post)
        <x-button href="{{ route('posts.edit', $post) }}"
            variant="primary">
            Modifier
        </x-button>
        @endcan
        @can('delete', $post)
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="danger">
                    Supprimer
                </x-button>
            </form>
        @endcan

        <x-button href="{{ route('posts.index') }}"
            variant="secondary">
            Retour à la liste
        </x-button>
    </div>
</div>
@endsection


