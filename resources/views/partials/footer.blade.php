<footer class="bg-gray-700 text-gray-300 py-6 mt-16 ">
    <section class="flex justify-around mb-4 container mx-auto">
        <div><a href=""></a>logo</div>
        <div>
            <x-contact 
                icon="fas fa-phone" 
                line1="01 23 45 67 89" 
                line2="01 23 45 67 90" 
            />

            <x-contact 
                icon="fas fa-envelope" 
                line1="contact@mon-site.com" 
            />
            <x-contact
                icon="fas fa-map-marker-alt"
                line1="123 Rue de la Danse"
            /> 
        </div>
        <div>location</div>
    </section>
    
    <div class="container mx-auto px-4">
        <hr>
        <p class="text-center text-sm mt-4">&copy; {{ date('Y') }} Mon Site. Tous droits réservés.</p>
    </div>
</footer>
