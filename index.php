<?php
require_once 'functions.php';

$pokemon = null;
$error = null;
$busqueda = '';
// Si se ha enviado el formulario de búsqueda, procesamos la consulta
if (isset($_GET['pokemon'])) {
    $busqueda = trim($_GET['pokemon']);
    $pokemon  = buscarPokemon($busqueda);

    if ($busqueda !== '' && !$pokemon) {
        $error = "No se encontró el Pokémon \"$busqueda\". Prueba con otro nombre o número.";
    }
}

$destacados = ['pikachu', 'charizard', 'mewtwo', 'bulbasaur', 'gengar', 'eevee', 'snorlax', 'lucario'];
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
                                placeholder="Nombre o número (pikachu, 25, charizard…)"
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

            <?php if ($pokemon): ?>
                <?php $color = colorTipoPokemon($pokemon['tipos'][0] ?? 'normal'); ?>

                <div class="pokemon-card" style="--poke-color: <?= e($color) ?>;">

                    <div class="pokemon-card__header">
                        <div class="pokemon-info">
                            <div class="pokemon-number">#<?= e(str_pad((string) $pokemon['id'], 4, '0', STR_PAD_LEFT)) ?></div>
                            <h2 class="pokemon-name"><?= e($pokemon['nombre']) ?></h2>

                            <div class="pokemon-types">
                                <?php foreach ($pokemon['tipos'] as $tipo): ?>
                                    <span class="type-badge" style="background:<?= e(colorTipoPokemon($tipo)) ?>">
                                        <?= e($tipo) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                            <div class="pokemon-meta">
                                <div class="meta-item">
                                    <span class="meta-label">Altura</span>
                                    <span class="meta-value"><?= e($pokemon['altura']) ?></span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Peso</span>
                                    <span class="meta-value"><?= e($pokemon['peso']) ?></span>
                                </div>
                            </div>

                            <div class="pokemon-abilities">
                                <div class="abilities-label">Habilidades</div>
                                <div class="abilities-list">
                                    <?php foreach ($pokemon['habilidades'] as $hab): ?>
                                        <span class="ability-tag"><?= e($hab) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <div class="pokemon-sprite-wrap">
                            <?php if ($pokemon['sprite']): ?>
                                <img
                                    id="poke-sprite"
                                    src="<?= e((string) $pokemon['sprite']) ?>"
                                    data-normal="<?= e((string) $pokemon['sprite']) ?>"
                                    data-shiny="<?= e((string) $pokemon['sprite_shiny'] ?? '') ?>"
                                    data-mode="normal"
                                    alt="<?= e($pokemon['nombre']) ?>"
                                    class="pokemon-sprite"
                                >
                            <?php endif; ?>
                            <?php if ($pokemon['sprite_shiny']): ?>
                                <button type="button" class="shiny-btn" onclick="toggleShiny()">✨ Ver Shiny</button>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="pokemon-stats">
                        <h3 class="stats-title">Estadísticas Base</h3>
                        <div class="stats-grid">
                            <?php foreach ($pokemon['stats'] as $stat => $valor): ?>
                                <div class="stat-row">
                                    <div class="stat-name"><?= e($stat) ?></div>
                                    <div class="stat-bar-wrap">
                                        <div class="stat-bar">
                                            <div class="stat-bar__fill"
                                                 data-width="<?= min(($valor/255)*100, 100) ?>"
                                                 style="background:<?= e($color) ?>;">
                                            </div>
                                        </div>
                                        <div class="stat-value"><?= e((string) $valor) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="json-section">
                        <div class="json-header">
                            <span>📋 Respuesta JSON procesada</span>
                            <button onclick="toggleJson()" class="json-btn">Mostrar / Ocultar</button>
                        </div>
                        <pre id="json-out" class="json-out" style="display:none"><code><?= e((string) json_encode($pokemon, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></code></pre>
                    </div>
                </div>

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
