// Animate stat bars on page load
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.stat-bar__fill').forEach((bar) => {
        const width = bar.dataset.width + '%';
        bar.style.width = '0%';
        requestAnimationFrame(() => {
            setTimeout(() => {
                bar.style.width = width;
            }, 60);
        });
    });
});

// Toggle shiny/normal sprite
function toggleShiny() {
    const img = document.getElementById('poke-sprite');
    const btn = document.querySelector('.shiny-btn');

    if (!img || !btn) {
        return;
    }

    const normal = img.dataset.normal;
    const shiny = img.dataset.shiny;

    if (!normal || !shiny) {
        return;
    }

    if (img.dataset.mode === 'shiny') {
        img.src = normal;
        img.dataset.mode = 'normal';
        btn.textContent = '✨ Ver Shiny';
        return;
    }

    img.src = shiny;
    img.dataset.mode = 'shiny';
    btn.textContent = '🔙 Ver Normal';
}

// Toggle JSON output visibility
function toggleJson() {
    const el = document.getElementById('json-out');

    if (!el) {
        return;
    }

    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
