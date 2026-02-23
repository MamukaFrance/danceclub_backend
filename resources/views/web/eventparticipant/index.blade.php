@extends('layouts.app')

@section('title', 'Liste de EventParticipants')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">
                Liste des EventParticipants
            </h1>
            <a href="{{ route('eventparticipant.create') }}"
                type="button"
            class="px-3 py-1.5 text-sm bg-green-500 text-white rounded hover:bg-green-600 transition">
            Créer un EventParticipant
            </a>
        </div>

        <x-alert/>

        @if ($eventParticipants->count())
            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($eventParticipants as $eventParticipant)
                    <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition">

                                <p class="text-sm text-gray-600">
            <span class="font-medium">Event id :</span>
            {{ $eventParticipant->event->name ?? '-' }}
        </p>
        <p class="text-sm text-gray-600">
            <span class="font-medium">User id :</span>
            {{ $eventParticipant->user->name ?? '-' }}
        </p>
        <p class="text-sm text-gray-600">
            <span class="font-medium">Status :</span>
            {{ $eventParticipant->status }}
        </p>

                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('eventparticipant.show', $eventParticipant) }}"
                            class="px-3 py-1.5 text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                Voir
                            </a>
                            @can('update', $eventParticipant)
                                <a href="{{ route('eventparticipant.edit', $eventParticipant) }}"
                                class="px-3 py-1.5 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                                    Éditer
                                </a>
                            @endcan

                            <form action="{{ route('eventparticipant.destroy', $eventParticipant) }}"
                                method="POST"
                                onsubmit="return confirm('Supprimer cet eventParticipant ?')">
                                @csrf
                                @method('DELETE')
                                @can('delete', $eventParticipant)
                                    <button type="submit"
                                        class="px-3 py-1.5 text-sm bg-red-500 text-white rounded hover:bg-red-600 transition">
                                        Supprimer
                                    </button>
                                @endcan
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center">
                Aucun eventParticipant disponible.
            </p>
        @endif

    </div>
@endsection
