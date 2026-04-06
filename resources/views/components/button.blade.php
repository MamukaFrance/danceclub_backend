@props([
    'href' => null,
    'variant' => 'primary'
])

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge([
        'class' => 'bg-blue-700 hover:bg-blue-800 text-white px-3 py-1.5 rounded-md cursor-pointer transition font-semibold'
    ]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge([
        'type' => 'button',
        'class' => 'bg-blue-700 hover:bg-blue-800 text-white px-3 py-1.5 rounded-md cursor-pointer transition font-semibold'
    ]) }}>
        {{ $slot }}
    </button>
@endif