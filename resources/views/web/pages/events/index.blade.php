
@extends('layouts.app')

@section('title', 'Liste des Events')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-6">

    <div class="flex justify-center items-center gap-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Liste des Events</h1>
        <x-button href="{{ route('events.create') }}"
            variant="primary"
            class="bg-green-500 hover:bg-green-600">
            Créer un Event
        </x-button>
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
                        <x-button type="submit" variant="danger">
                            Annuler
                        </x-button>
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

            <div class="flex justify-end gap-2">
                <x-button href="{{ route('events.show', $event) }}"
                    variant="primary">
                    Détails
                </x-button>
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