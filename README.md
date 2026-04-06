# Tarea 9 DWES

Mini aplicación en PHP para consultar PokeAPI y mostrar el resultado del pokémon en una página web.

## Incluye

- `index.php`: buscador principal de Pokémon.
- `functions.php`: funciones para consultar la API y formatear los datos.
- `style.css`: estilos visuales.

## Servicio web usado

Se ha usado PokeAPI, una API pública gratuita para pruebas.

- Sitio oficial: https://pokeapi.co/
- Endpoint principal: `https://pokeapi.co/api/v2/pokemon/{nombre}`

La web permite buscar Pokémon por nombre o por número de Pokédex.

## Ejecución local

1. Copia el proyecto en `C:\xampp\htdocs\Tarea9DWES`.
2. Arranca Apache en XAMPP.
3. Abre `http://localhost/Tarea9DWES/`.
4. Escribe un nombre como `pikachu`, `charizard` o un número como `25`.


## PHPDoc

Las funciones de `functions.php` incluyen comentarios `/** */` con `@param` y `@return`.
Puedes consultar la documentacion visualmente en Tarea9DWES_doc.