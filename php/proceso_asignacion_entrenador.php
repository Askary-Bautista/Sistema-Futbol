<?php
require '../conn.php'; // Asegúrate de tener la ruta correcta hacia tu archivo conn.php
require '../php/funciones.php';

session_start();

// Obtén el ID del entrenador desde la sesión
$entrenador_id = obtenerIdUsuario($_SESSION['usernameRes'], $conn);

// Verifica que se haya enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica que se hayan enviado datos
    if (isset($_POST['equipo'])) {
        // Recorre la lista de jugadores y sus equipos asignados
        foreach ($_POST['equipo'] as $id_jugador => $equipo_id) {
            // Asigna el equipo al jugador
            asignarEquipoAJugador($id_jugador, $equipo_id, $conn);
        }

        echo "<script>alert('Equipos asignados exitosamente.')</script>";
        header("location:../index.php");
    } else {
        echo "<script>alert('No se enviaron datos válidos.')</script>";
        header("location:../modulos/asignar_equipos.php");
    }
} else {
    echo "<script>alert('Acceso no autorizado.')</script>";
    header("location:../index.php");
}

// Función para asignar un equipo a un jugador
function asignarEquipoAJugador($id_jugador, $equipo_id, $conn) {
    $query = "UPDATE Jugadores SET equipo_id = ? WHERE id_jugador = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $equipo_id, $id_jugador);

    if (!mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Error al asignar equipo a jugador.')</script>";
        header("location:../modulos/asignar_equipos.php");
    }

    mysqli_stmt_close($stmt);
}
?>
