@php
    $classes = match ($variant) {
        'primary' => 'bg-blue-700 text-white px-3 py-1.5 rounded-md  cursor-pointer hover:bg-blue-800 transition font-semibold',
        'secondary' => 'bg-gray-500 text-white px-3 py-1.5 rounded-md  cursor-pointer hover:bg-gray-600 transition font-semibold',
        'danger' => 'bg-red-500 text-white px-3 py-1.5 rounded-md  cursor-pointer hover:bg-red-600 transition font-semibold',
        'reset' => 'bg-yellow-500 text-white px-3 py-1.5 rounded-md  cursor-pointer hover:bg-yellow-600 transition font-semibold'    };
@endphp

@props(['href' => null])

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge([
        'type' => 'button',
        'class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif