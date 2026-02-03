<a {{ $attributes->merge([
    'class' => 'block md:inline-block py-3 md:py-0 hover:text-blue-900'
]) }}>
    {{ $slot }}
</a>
