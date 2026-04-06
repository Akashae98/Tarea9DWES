<?php
/**
 * Librería de funciones para consumo de la PokeAPI.
 *
 * Contiene funciones para realizar peticiones HTTP usando
 * file_get_contents() y utilidades específicas pra mostrar los datos del Pokémon.
 *
 * @package ApiExplorer
 * @author  Carol
 * @version 1.0
 */

/**
 * Obtiene datos de un Pokémon desde PokeAPI.
 *
 * Consulta el endpoint de PokeAPI y devuelve información básica del Pokémon.
 *
 * @param string $nombre Nombre o ID del Pokémon a buscar (ej: "pikachu", "25").
 * @return array|null Array con datos del Pokémon o null si no existe.
 */
function buscarPokemon($nombre) {
    // Normaliza el nombre para la URL y realiza la petición
    $nombre = strtolower(trim($nombre));
    // Usamos file_get_contents() para obtener los datos JSON de la API
    $json = @file_get_contents("https://pokeapi.co/api/v2/pokemon/{$nombre}");
    // Si la respuesta es falsa, el Pokémon no existe o hubo un error
    if (!$json) {
        return null;
    }
    // Decodifica el JSON a un array asociativo
    $datos = json_decode($json, true);
    if (!is_array($datos)) {
        return null;
    }

    $sprites = $datos['sprites'] ?? [];
    $artwork = $sprites['other']['official-artwork'] ?? [];
    // Devuelve un array con los datos formateados del Pokémon
    return [
        'id' => (int) ($datos['id'] ?? 0),
        'nombre' => ucfirst((string) ($datos['name'] ?? $nombre)),
        'altura' => ((float) ($datos['height'] ?? 0) / 10) . ' m',
        'peso' => ((float) ($datos['weight'] ?? 0) / 10) . ' kg',
        'tipos' => array_map(fn($tipo) => ucfirst((string) ($tipo['type']['name'] ?? '')), $datos['types'] ?? []),
        'habilidades' => array_map(fn($habilidad) => ucfirst((string) ($habilidad['ability']['name'] ?? '')), $datos['abilities'] ?? []),
        'stats' => formatearStats($datos['stats'] ?? []),
        'sprite' => $artwork['front_default'] ?? ($sprites['front_default'] ?? null),
        'sprite_shiny' => $artwork['front_shiny'] ?? ($sprites['front_shiny'] ?? null),
    ];
}

/**
 * Formatea el array de estadísticas de un Pokémon.
 *
 * Convierte el formato de la API en un array más simple con los nombres en español.
 *
 * @param array $stats Array de estadísticas devuelto por PokeAPI.
 * @return array Array asociativo con nombre de stat y valor base.
 */
function formatearStats($stats) {
    $nombres = [
        'hp'              => 'PS',
        'attack'          => 'Ataque',
        'defense'         => 'Defensa',
        'special-attack'  => 'Atq. Esp.',
        'special-defense' => 'Def. Esp.',
        'speed'           => 'Velocidad',
    ];

    $resultado = [];
    foreach ($stats as $stat) {
        $clave = $stat['stat']['name'] ?? '';
        $nombre = $nombres[$clave] ?? $clave;
        $resultado[$nombre] = $stat['base_stat'] ?? 0;
    }

    return $resultado;
}

/**
 * Devuelve el color CSS asociado a un tipo de Pokémon.
 *
 * Mapea los tipos de Pokémon a colores hexadecimales para la interfaz visual.
 *
 * @param string $tipo Nombre del tipo en inglés (fire, water, grass...).
 * @return string Color en formato hexadecimal CSS.
 */
function colorTipoPokemon($tipo) {
    $colores = [
        'fire'     => '#FF6B35',
        'water'    => '#4FC3F7',
        'grass'    => '#66BB6A',
        'electric' => '#FFD600',
        'psychic'  => '#EC407A',
        'ice'      => '#80DEEA',
        'dragon'   => '#7E57C2',
        'dark'     => '#5D4037',
        'fairy'    => '#F48FB1',
        'fighting' => '#E53935',
        'poison'   => '#9C27B0',
        'ground'   => '#FFA726',
        'flying'   => '#90CAF9',
        'bug'      => '#9CCC65',
        'rock'     => '#8D6E63',
        'ghost'    => '#5C6BC0',
        'steel'    => '#90A4AE',
        'normal'   => '#BDBDBD',
    ];

    return $colores[strtolower($tipo)] ?? '#78909C';
}

/**
 * Escapa texto para imprimirlo de forma segura en HTML.
 *
 * @param string $valor Texto a escapar.
 * @return string
 */
function e($valor) {
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
