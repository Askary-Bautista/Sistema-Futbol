<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usernameRes'])) {
    header("location: ../modulos/login.php");
    exit();
}

// Obtener el rol del usuario
$rol = $_SESSION['rol'];

// Verificar el rol antes de permitir el acceso
if ($rol !== 'Entrenador') {
    echo 'Acceso no autorizado.';
    exit();
}

// Procesar el formulario de registro de jugador
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../conn.php';
    require '../php/funciones.php';

    $nombre_jugador = $_POST["nombre_jugador"];
    $contrasena_jugador = $_POST["contrasena_jugador"];
    $posicion_jugador = $_POST["posicion_jugador"];
    $edad_jugador = $_POST["edad_jugador"];
    $rol_jugador = $_POST["rol_jugador"];
    $correo_jugador = $_POST["correo_jugador"];

    // Obtener el ID del entrenador y su equipo
    $entrenador_id = obtenerIdUsuario($_SESSION['usernameRes'], $conn);
    $equipo_id = obtenerEquipoEntrenador($entrenador_id, $conn);

    // Verificar si el jugador ya existe en el equipo
    $query_check = "SELECT COUNT(*) as contar FROM jugadores WHERE nombre = ? AND equipo_id = ?";
    $stmt_check = mysqli_prepare($conn, $query_check);
    mysqli_stmt_bind_param($stmt_check, "si", $nombre_jugador, $equipo_id);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_bind_result($stmt_check, $contar);
    mysqli_stmt_fetch($stmt_check);
    mysqli_stmt_close($stmt_check);

    if ($contar > 0) {
        echo "<script>alert('El jugador ya existe en tu equipo.')</script>";
    } else {
        // Insertar el jugador en la base de datos
        $query_insert = "INSERT INTO jugadores (nombre, contrasena_jugador, posicion, edad, rol_jugador, correo_jugador, equipo_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $query_insert);
        mysqli_stmt_bind_param($stmt_insert, "sssissi", $nombre_jugador, $contrasena_jugador, $posicion_jugador, $edad_jugador, $rol_jugador, $correo_jugador, $equipo_id);
        if (mysqli_stmt_execute($stmt_insert)) {
            echo "<script>alert('Jugador registrado exitosamente.')</script>";
            header("location:../index.php");
        } else {
            echo "<script>alert('Error al registrar el jugador.')</script>";
        }

        mysqli_stmt_close($stmt_insert);
    }

    mysqli_close($conn);
} else {
    echo "<script>alert('Error: No se recibieron datos del formulario.')</script>";
}
?>