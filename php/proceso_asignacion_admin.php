<?php
// Conexión a la base de datos y funciones necesarias
require '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar la asignación de equipos
    $equipos_asignados = $_POST['equipo'];

    foreach ($equipos_asignados as $id_jugador => $equipo_id) {
        // Actualizar la base de datos con la asignación de equipo
        $query_update = "UPDATE jugadores SET equipo_id = ? WHERE id_jugador = ?";
        $stmt_update = mysqli_prepare($conn, $query_update);
        mysqli_stmt_bind_param($stmt_update, "ii", $equipo_id, $id_jugador);
        mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);
    }

    //Equipo asignados exitosamente
    header("location:../modulos/jugadores_no_asignados_admin.php?error=1");
}
