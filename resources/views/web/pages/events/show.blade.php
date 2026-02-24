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
                    <th class="px-4 py-2 border">Date d'inscription</th>
                </tr>
            </thead>
            <tbody>
                @foreach($event->eventParticipants as $participant)
                    <tr>
                        <td class="px-4 py-2 border">{{ $participant->id }}</td>
                        <td class="px-4 py-2 border">{{ $participant->name ?? 'Non défini' }}</td>
                        <td class="px-4 py-2 border">{{ $participant->email ?? 'Non défini' }}</td>
                        <td class="px-4 py-2 border">{{ $participant->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun participant inscrit pour cet événement.</p>
    @endif

    {{-- Actions CRUD --}}
    <div class="mt-6 flex space-x-2">
        <a href="{{ route('events.edit', $event->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Modifier</a>

        <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Supprimer</button>
        </form>

        <a href="{{ route('events.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Retour à la liste</a>
    </div>
</div>
@endsection


