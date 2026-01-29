<!-- resources/views/components/section-image-text.blade.php -->
<section  {{ $attributes->merge(['class' => 'container mx-auto flex flex-col md:flex-row items-center gap-6 p-6 bg-gray-50 rounded-lg shadow-md']) }}>
    <!-- Image -->
    <div class="md:w-1/2">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-auto rounded-lg object-cover">
    </div>

    <!-- Texte -->
    <div class="md:w-1/2">
        <h2 class="text-3xl font-bold mb-4 text-center">{{ $title }}</h2>
        <p class="text-gray-700 mb-4 text-center">{{ $slot }}</p>
        @isset($link)
            <div class="flex justify-center">
            <a href="{{ $link }}" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md transition">
                {{ $linkText ?? 'En savoir plus' }}
            </a>
        </div>
        @endisset
    </div>
</section>
