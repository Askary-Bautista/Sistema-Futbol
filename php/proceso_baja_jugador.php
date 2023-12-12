<?php
session_start();

if (!isset($_SESSION['usernameRes'])) {
    header("location: ../modulos/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../conn.php';
    require '../php/funciones.php';

    $id_jugador = $_POST['id_jugador'];

    // Lógica para dar de baja al jugador (actualizar equipo_id a NULL)
    darDeBajaJugador($id_jugador, $conn);

    // Cerrar la conexión
    mysqli_close($conn);

    // Redirigir a la página de mis jugadores
    header("location: ../modulos/vista_misJugadores.php");
    exit();
} else {
    // Si no es una solicitud POST, redirigir a una página de error o a la página principal
    header("location: ../index.php");
    exit();
}
?>
