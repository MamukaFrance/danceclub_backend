document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('image');
    const preview = document.getElementById('image-preview');
    const titlePreview = document.getElementById('title-preview');
    const imgActuelle = document.getElementById('image-actuelle');
    const removeCheckbox = document.getElementById('remove_image');

    if (!input) return; // sécurité si pas sur la page

    if(removeCheckbox) {removeCheckbox.addEventListener('change', function() {

        if (removeCheckbox.checked) {
            if(imgActuelle) {
                imgActuelle.classList.add('hidden');
            }
        }else {
            if(imgActuelle) {
                imgActuelle.classList.remove('hidden');
            }
        } 
    })};


    input.addEventListener('change', function (event) {

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