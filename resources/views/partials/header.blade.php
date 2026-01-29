<header class="bg-linear-to-r from-purple-400 via-pink-300 to-red-300 p-4 shadow-md fixed top-0 left-0 right-0 z-50">
   <section class="flex justify-between container mx-auto">
        <div>
            <a href="{{ route('home') }}">logo</a>
        </div>
        @include('partials.navbar')
        @include('components.SocialLinks') 
    </section> 
</header>

