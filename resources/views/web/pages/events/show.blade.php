@extends('layouts.app')

@section('title', 'Détails de Event')

@section('content')
<div class="max-w-xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">{{ $event->title }}</h1>
    <x-alert/>

    {{-- Informations de l'événement --}}
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <p><strong>Description :</strong> {{ $event->description }}</p>
        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
        <p><strong>Heure de début :</strong> {{ $event->start_time }}</p>
        <p><strong>Heure de fin :</strong> {{ $event->end_time }}</p>
        <p><strong>Capacité :</strong> {{ $event->capacity }}</p>
        <p><strong>Nombre de participants :</strong> {{ $event->eventParticipants->count() }}</p>
    </div>

    {{-- Liste des participants --}}
    <h2 class="text-xl font-semibold mb-2">Participants</h2>
    @if($event->eventParticipants->count())
        <table class="min-w-full bg-white border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Nom</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($event->eventParticipants as $participant)
                    <tr>
                        <td class="px-4 py-2 border">{{ $participant->id }}</td>
                        <td class="px-4 py-2 border">{{ $participant->user->name ?? 'Non défini' }}</td>
                        <td class="px-4 py-2 border">{{ $participant->user->email ?? 'Non défini' }}</td>
                        <td class="px-4 py-2 border">{{ $participant->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun participant inscrit pour cet événement.</p>
    @endif

    {{-- Actions CRUD --}}
    <div class="mt-6 flex items-center space-x-2">
        <x-button href="{{ route('events.edit', $event) }}"
            variant="primary">
            Modifier
        </x-button>
        <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
            @csrf
            @method('DELETE')
            <x-button type="submit" variant="danger">
                Supprimer
            </x-button>
            
        </form>
            <x-button href="{{ route('events.index') }}"
                variant="secondary">
                Retour à la liste
            </x-button>
    </div>
</div>
@endsection


