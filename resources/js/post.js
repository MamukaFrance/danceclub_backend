document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('image');

    if (!input) return; // sécurité si pas sur la page

    input.addEventListener('change', function (event) {

        const preview = document.getElementById('image-preview');
        const titlePreview = document.getElementById('title-preview');
        const imgActuelle = document.getElementById('image-actuelle');

        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                titlePreview.classList.remove('hidden');

                if (imgActuelle) {
                    imgActuelle.classList.add('hidden');
                }
            };

            reader.readAsDataURL(event.target.files[0]);
        }
    });
});