@extends('layouts.app')

@section('title', 'Liste de Events')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                Liste des Events
            </h1>
            <a href="{{ route('event.create') }}"
                type="button"
            class="px-3 py-1.5 text-sm bg-green-500 text-white rounded hover:bg-green-600 transition">
            Créer un Event
            </a>
        </div>

        @if ($events->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition">

                        <h2 class="text-lg font-semibold text-gray-900 mb-2">
                            {{ $event->title }}
                        </h2>

                        <p class="text-sm text-gray-600 mb-1">
                            📅 <span class="font-medium">Date :</span> {{ $event->date }}
                        </p>

                        <p class="text-sm text-gray-600 mb-3">
                            👥 <span class="font-medium">Capacité :</span> {{ $event->capacity }}
                        </p>

                        <div class="flex gap-2">
                            <a href="{{ route('event.show', $event) }}"
                            class="px-3 py-1.5 text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                Voir
                            </a>

                            <a href="{{ route('event.edit', $event) }}"
                            class="px-3 py-1.5 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                                Éditer
                            </a>

                            <form action="{{ route('event.destroy', $event) }}"
                                method="POST"
                                onsubmit="return confirm('Supprimer cet event ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 text-sm bg-red-500 text-white rounded hover:bg-red-600 transition">
                                    Supprimer
                                </button>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center">
                Aucun event disponible.
            </p>
        @endif

    </div>
@endsection
