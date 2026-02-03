@props([
    'type' => 'success',
    'message' => session('success'),
])

@php
    $classes = match ($type) {
        'success' => 'border-green-500 bg-green-50 text-green-700',
        'error'   => 'border-red-500 bg-red-50 text-red-700',
        'info'    => 'border-blue-500 bg-blue-50 text-blue-700',
        default   => 'border-gray-400 bg-gray-50 text-gray-700',
    };
@endphp

@if (session('success'))
    <div class="max-w-md mx-auto mb-4 rounded-lg text-center border p-3 {{ $classes }}">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="max-w-md mx-auto mb-4 rounded-lg text-center border p-3 {{ $classes }}">
        {{ $errors->first() }}
    </div>
@endif
@if (session('info'))
    <div class="max-w-md mx-auto mb-4 rounded-lg text-center border p-3 {{ $classes }}">
        {{ session('info') }}
    </div>
@endif