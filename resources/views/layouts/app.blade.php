<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Mon Site')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" 
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    </head>
    <body class="bg-gray-100 min-h-screen flex flex-col text-gray-800 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
        <div class="flex flex-col flex-1 mt-7">
            @include('partials.header')

            <!-- Contenu principal -->
            <main class="flex-1 container mx-auto px-4 py-8">
                @yield('content')
            </main>

            @include('partials.footer')
        </div>
        <script src="//unpkg.com/alpinejs" defer></script>
    </body>
</html>
