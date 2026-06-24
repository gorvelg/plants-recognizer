document.addEventListener('click', (event) => {
    const toggleBtn = event.target.closest('.toggle-menu');

    if (!toggleBtn) {
        return;
    }

    document.body.classList.toggle('sidebar-open');
});
