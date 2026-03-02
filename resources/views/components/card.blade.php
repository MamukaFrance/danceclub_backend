<!-- resources/views/components/card.blade.php -->
<div {{ $attributes->merge(['class' => 'bg-white p-4 max-w-md rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300']) }}>
    <!-- Image -->
    @if($image)
        <img src="{{ $image }}" alt="{{ $title }}" class="rounded-lg w-full h-48 object-cover loading="lazy"">
    @else
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
            <span class="text-gray-400">Pas d'image</span>
        </div>
    @endif

    <!-- Contenu -->
    <div class="p-4">
        <h2 class="text-xl font-bold mb-2">{{ $title }}</h2>
        <p class="text-gray-600">{{ $slot }}</p>
    </div>
</div>
