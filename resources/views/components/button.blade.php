@props([
    'href' => null,
    'variant' => 'primary'
])

<button {{ $attributes->merge([
        'type' => 'button',
        'class' => 'bg-blue-700 text-white px-3 py-1.5 rounded-md  cursor-pointer hover:bg-blue-800 transition font-semibold'
        ]) }}>
        {{ $slot }}
</button>