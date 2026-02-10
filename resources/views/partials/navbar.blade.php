<nav class="px-4 relative">
    <div class="flex items-center justify-between">
        <!-- Burger -->
        <button id="burger-btn"
            class="cursor-pointer md:hidden relative w-8 h-6 flex flex-col justify-between
                   transition-all duration-300">
            <span class="line block h-0.5 w-full bg-white transition-all duration-300"></span>
            <span class="line block h-0.5 w-full bg-white transition-all duration-300"></span>
            <span class="line block h-0.5 w-full bg-white transition-all duration-300"></span>
        </button>

         <!-- Overlay -->
        <div id="overlay"
            class="fixed inset-0 bg-black/50 hidden md:hidden transition-opacity duration-300">
        </div>
    </div>

    <!-- Menu slide -->
    <div
        id="menu"
        class="fixed top-0 right-0 h-screen w-64
           bg-blue-700 text-white
           transform translate-x-full
           transition-transform duration-300 ease-in-out
           md:static md:translate-x-0 md:h-auto md:w-auto md:gap-4 md:bg-transparent
           hidden md:flex flex-wrap
           px-8 py-4 md:py-0 space-y-1 md:space-y-0"
    >
        <div class="flex justify-end">
            <span id="close-menu" class="text-white  md:hidden cursor-pointer text-2xl">X</span>
        </div>

        <x-nav-link href="{{ route('home') }}">Accueil</x-nav-link>
        <x-nav-link href="{{ route('about') }}">À propos</x-nav-link>

        @auth
            <x-nav-link href="{{ route('post.index') }}">Posts</x-nav-link>
            <x-nav-link href="{{ route('post.create') }}">Créer un post</x-nav-link>
            <x-nav-link href="{{ route('course.index') }}">Courses</x-nav-link>
            <x-nav-link href="{{ route('course.create') }}">Créer une course</x-nav-link>
            <x-nav-link href="{{ route('profile.edit') }}">Mon profil</x-nav-link>
        @endauth

        <x-nav-link href="{{ route('mail.index') }}">Contact</x-nav-link>
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="cursor-pointer block md:inline-block py-3 md:py-0 hover:text-blue-900">
                    Se déconnecter
                </button>
            </form>
        @endauth
        @guest
            <x-nav-link href="{{ route('login') }}">Se connecter</x-nav-link>
        @endguest

       
    </div>
</nav>
