<?php
// Construir la ruta al archivo contador.txt
$rutaContador = realpath(__DIR__ . '/../contador_visitas') . '/contador.txt';

// Leer el contador actual
$contador = (int) file_get_contents($rutaContador);

// Incrementar el contador
$contador++;

// Escribir el nuevo valor en el archivo
file_put_contents($rutaContador, $contador);

// Devolver el contador como respuesta
echo $contador;
?>
