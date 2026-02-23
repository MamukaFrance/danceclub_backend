@extends('layouts.app')

@section('title', 'Détails de EventParticipant')

@section('content')
    <div class="mt-4 flex justify-center">
                
        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition">
            <h1 class="mb-2 text-center text-2xl font-bold text-gray-800">
                Détails de EventParticipant
            </h1>

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
                <a href="{{ route('eventparticipant.index') }}" 
                    class="px-3 py-1.5 text-sm bg-gray-500  text-white rounded hover:bg-gray-600 transition">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
@endsection


