<?php
// Conexión a la base de datos (asegúrate de tener la ruta correcta en tu archivo conn.php)
require '../conn.php';



// Consulta SQL para obtener los IDs y nombres de todos los equipos
$queryEquipos = "SELECT id_equipo, nombre_equipo FROM equipos";
$resultEquipos = mysqli_query($conn, $queryEquipos);

// Verificar si la consulta fue exitosa
if ($resultEquipos) {
    $equipos = [];

    // Obtener los IDs y nombres de los equipos
    while ($row = mysqli_fetch_assoc($resultEquipos)) {
        $equipos[] = ['id_equipo' => $row['id_equipo'], 'nombre_equipo' => $row['nombre_equipo']];
    }

    // Cerrar el resultado de la consulta
    mysqli_free_result($resultEquipos);
} else {
    // Manejar el error según tu lógica
    echo "Error al obtener los equipos desde la base de datos: " . mysqli_error($conn);
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);

// Ahora, $equipos contiene arrays asociativos con los IDs y nombres de los equipos
?>
