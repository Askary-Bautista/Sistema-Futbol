<?php
require '../conn.php';
require_once '../php/funciones.php';

session_start();

$usuario_Entrenador = isset($_POST["username_entrenador"]) ? $_POST["username_entrenador"] : null;
$psw_Entrenador = isset($_POST["password_entrenador"]) ? $_POST["password_entrenador"] : null;

$usuario_Jugador = isset($_POST["username_jugador"]) ? $_POST["username_jugador"] : null;
$psw_Jugador = isset($_POST["password_jugador"]) ? $_POST["password_jugador"] : null;

if ($usuario_Entrenador !== null && $psw_Entrenador !== null) {
    $q = "SELECT COUNT(*) as contar FROM usuarios WHERE nombre_usuario = ? AND contrasena = ?";
    $stmt = mysqli_prepare($conn, $q);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $usuario_Entrenador, $psw_Entrenador);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $contar);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($contar > 0) {
            $_SESSION['usernameRes'] = $usuario_Entrenador;
            $_SESSION['rol'] = obtenerRolUsuario($usuario_Entrenador, $conn);
            header("location:../modulos/vista_miEquipo.php");
            exit;
        }
    }
}

// Autenticación para el jugador
if ($usuario_Jugador !== null && $psw_Jugador !== null) {
    $q_jugador = "SELECT COUNT(*) as contar FROM jugadores WHERE nombre = ? AND contrasena_jugador = ?";
    $stmt_jugador = mysqli_prepare($conn, $q_jugador);

    if ($stmt_jugador) {
        mysqli_stmt_bind_param($stmt_jugador, "ss", $usuario_Jugador, $psw_Jugador);
        mysqli_stmt_execute($stmt_jugador);
        mysqli_stmt_bind_result($stmt_jugador, $contar_jugador);
        mysqli_stmt_fetch($stmt_jugador);
        mysqli_stmt_close($stmt_jugador);

        if ($contar_jugador > 0) {
            $_SESSION['usernameRes'] = $usuario_Jugador;
            $_SESSION['rol_jugador'] = obtenerRolJugador($usuario_Jugador, $conn);
            header("location:../modulos/vista_miEquipo_jugador.php");
            exit;
        }
    }
}

// En proceso_login.php
header("location:../modulos/login.php?error=1");
exit;

