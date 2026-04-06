@props([
    'href' => null,
    'variant' => 'primary'
])

@php
    $classes = 'bg-blue-700 text-white px-3 py-1.5 rounded-md cursor-pointer hover:bg-blue-800 transition font-semibold';      
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge([
        'type' => 'button',
        'class' => $classes
    ]) }}>
        {{ $slot }}
    </button>
@endif