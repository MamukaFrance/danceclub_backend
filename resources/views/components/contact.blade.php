<div {{ $attributes->merge(['class' => 'flex items-center gap-4 mb-2']) }}>
    <!-- Icône -->
    <i class="{{ $icon }}"></i>

    <!-- Texte -->
    <div>
        <p>{{ $line1 }}</p>
        @isset($line2)
            <p>{{ $line2 }}</p>
        @endisset
    </div>
</div>
