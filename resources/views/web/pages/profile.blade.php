@extends('layouts.app') {{-- Hérite du layout principal --}}

@section('title', 'Mon Profil') {{-- Titre de la page --}}

@section('content')
<div class="container max-w-xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4 text-center">Mon Profil</h1>
    <x-alert/>

    {{-- Formulaire de modification --}}
    <div class="bg-white shadow rounded p-4">
        <form action="{{route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="flex justify-center items-center">
                <div class="w-10 h-10 border rounded-full flex items-center justify-center  bg-cyan-200">
                    <i class="fas fa-user"></i>
                </div>
                <p class="ml-2">{{ $user->email }}</p>
            </div>
            <div class="mb-4">
                <label for="name" class="block font-medium mb-1">Nom <span class="text-red-400">*</span></label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" placeholder="Jhone"
                       class="w-full border border-gray-300 rounded p-2" >
            </div>

            <div class="mb-4">
                <label for="phone" class="block font-medium mb-1">Phone</label>
                <input type="tel" name="phone" id="email" value="{{ $user->phone }}"placeholder="0712345678"
                       class="w-full border border-gray-300 rounded p-2" >
            </div>

            <p><strong>Date de création : </strong> {{ $user->created_at->format('d/m/Y') }}</p>
            <p><strong>Date de modification : </strong> {{ $user->updated_at->format('d/m/Y') }}</p>
            <button type="submit"
                class= "bg-blue-600 mt-4 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Mettre à jour
            </button>
        </form>
    </div>
</div>
@endsection
