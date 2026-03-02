document.addEventListener('DOMContentLoaded', () => {
    const burger = document.getElementById('burger-btn');
    const menu = document.getElementById('menu');
    const overlay = document.getElementById('overlay');
    const closeBtn = document.getElementById('close-menu');

    if (!burger || !menu) return;

    function toggleMenu() {
        menu.classList.toggle('hidden');
        menu.classList.toggle('translate-x-full');
        overlay?.classList.toggle('hidden');
        burger.classList.toggle('open');
    }

    burger.addEventListener('click', toggleMenu);
    overlay?.addEventListener('click', toggleMenu);
    closeBtn?.addEventListener('click', toggleMenu);

    menu.querySelectorAll('a').forEach(link =>
        link.addEventListener('click', toggleMenu)
    );
});