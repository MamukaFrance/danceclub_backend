<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Site')</title>
    <!-- CSS -->
     @vite('resources/css/app.css')

    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <!-- <link rel="stylesheet" href="{{ asset('css/header.css') }}"> -->
    <!-- <style>
        /* Header Styles - Inline */
        header {
            background-color: #1b1b18;
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 1.5rem;
            margin: 0;
            flex: 1;
            color: #f53003;
        }

        header nav {
            display: flex;
            gap: 2rem;
        }

        header nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        header nav a:hover {
            color: #f53003;
        }
    </style> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body class="bg-gray-100 min-h-screen flex flex-col mt-15">
    <!-- Header -->
    @include('partials.header')

    <!-- Contenu principal -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- JS -->
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
</body>
</html>
