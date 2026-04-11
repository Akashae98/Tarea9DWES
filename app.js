// Animar las barras de estadísticas al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.stat-bar__fill').forEach((statBarFill) => {
        const targetWidth = statBarFill.dataset.width + '%';
        statBarFill.style.width = '0%';
        requestAnimationFrame(() => {
            setTimeout(() => {
                statBarFill.style.width = targetWidth;
            }, 60);
        });
    });
});

// Cambiar entre sprite normal y shiny
function toggleShiny() {
    const spriteImage = document.getElementById('poke-sprite');
    const shinyButton = document.querySelector('.shiny-btn');

    if (!spriteImage || !shinyButton) {
        return;
    }

    const normalSprite = spriteImage.dataset.normal;
    const shinySprite = spriteImage.dataset.shiny;

    if (!normalSprite || !shinySprite) {
        return;
    }

    if (spriteImage.dataset.mode === 'shiny') {
        spriteImage.src = normalSprite;
        spriteImage.dataset.mode = 'normal';
        shinyButton.textContent = '✨ Ver Shiny';
        return;
    }

    spriteImage.src = shinySprite;
    spriteImage.dataset.mode = 'shiny';
    shinyButton.textContent = '🔙 Ver Normal';
}

// Mostrar u ocultar el JSON
function toggleJson() {
    const jsonOutput = document.getElementById('json-out');

    if (!jsonOutput) {
        return;
    }

    jsonOutput.style.display = jsonOutput.style.display === 'none' ? 'block' : 'none';
}
