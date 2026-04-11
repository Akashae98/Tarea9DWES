<!-- Tarjeta visual con los datos del Pokémon buscado -->

<div class="pokemon-card" style="--poke-color: <?= e($pokemonColor) ?>;">
    <div class="pokemon-card__header">
        <div class="pokemon-info">
            <div class="pokemon-number"><?= e($pokemonNumber) ?></div>
            <h2 class="pokemon-name"><?= e($pokemon['nombre']) ?></h2>

            <div class="pokemon-types">
                <?php foreach ($pokemonTypes as $tipo): ?>
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
                    <?php foreach ($pokemonAbilities as $hab): ?>
                        <span class="ability-tag"><?= e($hab) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="pokemon-sprite-wrap">
            <?php if ($spriteNormal): ?>
                <img
                    id="poke-sprite"
                    src="<?= e((string) $spriteNormal) ?>"
                    data-normal="<?= e((string) $spriteNormal) ?>"
                    data-shiny="<?= e((string) ($spriteShiny ?? '')) ?>"
                    data-mode="normal"
                    alt="<?= e($pokemon['nombre']) ?>"
                    class="pokemon-sprite"
                >
            <?php endif; ?>
            <?php if ($spriteShiny): ?>
                <button type="button" class="shiny-btn" onclick="toggleShiny()">✨ Ver Shiny</button>
            <?php endif; ?>
        </div>
    </div>

    <div class="pokemon-stats">
        <h3 class="stats-title">Estadísticas Base</h3>
        <div class="stats-grid">
            <?php foreach ($pokemonStats as $stat => $valor): ?>
                <div class="stat-row">
                    <div class="stat-name"><?= e($stat) ?></div>
                    <div class="stat-bar-wrap">
                        <div class="stat-bar">
                            <div
                                class="stat-bar__fill"
                                data-width="<?= min(($valor / 255) * 100, 100) ?>"
                                style="background:<?= e($pokemonColor) ?>;"
                            ></div>
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
        <pre id="json-out" class="json-out" style="display:none"><code><?= e($pokemonJson) ?></code></pre>
    </div>
</div>
