<?php
require_once 'functions.php';

//Preparar variables para la vista
$pokemon = null;
$error = null;
$busqueda = '';

// Procesar la búsqueda si viene por GET
if (isset($_GET['pokemon'])) {
    $busqueda = trim($_GET['pokemon']);
    $pokemon  = buscarPokemon($busqueda);

    if ($busqueda !== '' && !$pokemon) {
        $error = "No se encontró el Pokémon \"$busqueda\". Prueba con otro nombre o número.";
    }
}
// Datos para la vista
$destacados = ['pikachu', 'charizard', 'mewtwo', 'bulbasaur', 'gengar', 'eevee', 'snorlax', 'lucario'];
$pokemonTypes = $pokemon['tipos'] ?? [];
$pokemonAbilities = $pokemon['habilidades'] ?? [];
$pokemonStats = $pokemon['stats'] ?? [];
$spriteNormal = $pokemon['sprite'] ?? null;
$spriteShiny = $pokemon['sprite_shiny'] ?? null;
$pokemonColor = $pokemon ? colorTipoPokemon($pokemonTypes[0] ?? 'normal') : '#78909C';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokéAPI Explorer — PHP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="site-header">
        <div class="header-inner">
            <div class="logo">
                <span class="logo-ball">⚡</span>
                <span class="logo-text">PokéAPI<span class="logo-sub">Explorer</span></span>
            </div>
            <div class="header-badge">file_get_contents() · JSON · PHP</div>
        </div>
    </header>

    <main>

        <section class="hero">
            <div class="container hero-inner">
                <div class="hero-content">
                    <div class="hero-badge">⚡ PokéAPI · pokeapi.co</div>
                    <h1 class="hero-title">
                        Explora el mundo<br>
                        <span class="accent">Pokémon</span> con PHP
                    </h1>
                    <p class="hero-subtitle">
                        Consume <code>pokeapi.co/api/v2/pokemon/{nombre}</code> usando
                        <code>file_get_contents()</code> y muestra los datos JSON en tiempo real.
                    </p>

                    <form method="get" action="index.php" class="hero-search">
                        <div class="search-wrap">
                            <span class="search-icon">🔍</span>
                            <input
                                type="text"
                                name="pokemon"
                                class="search-input"
                                placeholder="Nombre o número (pikachu, 25, charizard…). Existen hasta 1025 Pokémon registrados."
                                value="<?= e($busqueda) ?>"
                                autocomplete="off"
                                autofocus
                            >
                            <button type="submit" class="search-btn">Buscar</button>
                        </div>
                    </form>

                    <div class="quick-select">
                        <span class="quick-label">Acceso rápido:</span>
                        <?php foreach ($destacados as $p): ?>
                            <a href="index.php?pokemon=<?= e($p) ?>" class="quick-tag">
                                <?= e(ucfirst($p)) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <div class="container">

            <?php if ($error): ?>
                <div class="alert alert--error">
                    <span>⚠</span>
                    <span><?= e($error) ?></span>
                </div>
            <?php endif; ?>

            <!-- Si hay datos de Pokémon, mostramos la tarjeta -->
            <?php if ($pokemon): ?>
                <?php include __DIR__ . '/views/pokemon-card.php'; ?>
            <!-- Si no hay búsqueda, mostramos un estado vacío con instrucciones -->
            <?php elseif ($busqueda === ''): ?>

                <div class="empty-state">
                    <div class="empty-icon">⚡</div>
                    <h3>Busca tu Pokémon favorito</h3>
                    <p>Introduce el nombre o el número de Pokédex en el buscador</p>
                    <p class="empty-hint">
                        Endpoint: <code>GET https://pokeapi.co/api/v2/pokemon/{nombre}</code>
                    </p>
                </div>

            <?php endif; ?>

        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-inner">
        
            <a href="https://pokeapi.co" target="_blank" rel="noopener">pokeapi.co ↗</a>
        </div>
    </footer>

    <script src="app.js" defer></script>
</body>
</html>
