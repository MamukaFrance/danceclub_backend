@props([
    'href' => null,
    'variant' => 'primary'
])

@php
    $variants = [
        'primary' => 'bg-blue-700 hover:bg-blue-800 text-white',
        'secondary' => 'bg-gray-500 hover:bg-gray-600 text-white',
        'danger' => 'bg-red-500 hover:bg-red-600 text-white',
        'reset' => 'bg-yellow-500 hover:bg-yellow-600 text-white',
    ];

    $classes = ($variants[$variant] ?? $variants['primary']) . ' px-3 py-1.5 rounded-md cursor-pointer transition font-semibold';
@endphp

