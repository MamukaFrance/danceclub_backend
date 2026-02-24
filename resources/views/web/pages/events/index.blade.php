
@extends('layouts.app')

@section('title', 'Liste des Events')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Liste des Events</h1>
        <a href="{{ route('events.create') }}"
            class="px-3 py-1.5 text-sm bg-green-500 text-white rounded hover:bg-green-600 transition">
            Créer un Event
        </a>
    </div>

    <x-alert/>

    @php
    use App\Enums\EventParticipantStatus;
    @endphp

    @if ($events->count())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($events as $event)
        <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-lg transition">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-900">{{ $event->title }}</h2>

                @php
                    $participant = $event->eventParticipants
                        ->where('user_id', auth()->id())
                        ->first();
                @endphp

                @if ($participant && $participant->status === EventParticipantStatus::REGISTERED)

                    <form action="{{ route('eventparticipants.cancel', $participant) }}" method="POST">
                        @csrf
                        <button 
                            type="submit"
                            class="max-w-sm rounded-md bg-red-500 px-4 py-2 text-white hover:bg-red-600 transition">
                            Annuler
                        </button>
                    </form>

                @else

                    <form action="{{ route('eventparticipants.register', $event) }}" method="POST">
                        @csrf
                        <button 
                            type="submit"
                            {{ $event->is_full ? 'disabled' : '' }}
                            class="max-w-sm rounded-md 
                            {{ $event->is_full 
                                ? 'bg-gray-400 cursor-not-allowed' 
                                : 'bg-indigo-600 hover:bg-indigo-700' }} 
                            px-4 py-2 text-white transition">
                            Participer
                        </button>
                    </form>

                @endif
            </div>

            <p class="text-sm text-gray-600 mb-1">
                📅 <span class="font-medium">Date :</span> {{ $event->date }}
            </p>

            <p class="text-sm text-gray-600 mb-1">
                👥 <span class="font-medium">Capacité :</span> {{ $event->capacity }}
            </p>

            <p class="text-sm text-gray-600 mb-3">
                🟢 <span class="font-medium">Places restantes :</span> {{ $event->remaining_seats }}
            </p>

            <div class="flex gap-2">
                <a href="{{ route('events.show', $event) }}"
                    class="px-3 py-1.5 text-sm bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                    Voir
                </a>

                @can('update', $event)
                    <a href="{{ route('events.edit', $event) }}"
                    class="px-3 py-1.5 text-sm bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                        Éditer
                    </a>
                @endcan

                <form action="{{ route('events.destroy', $event) }}"
                    method="POST"
                    onsubmit="return confirm('Supprimer cet event ?')">
                    @csrf
                    @method('DELETE')
                    @can('delete', $event)
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
        Aucun event disponible.
    </p>
    @endif

</div>
@endsection