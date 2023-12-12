<?php
require '../conn.php';

$nombre_jugador_admin = $_POST["nombre_jugador_admin"];
$contrasena_jugador_admin = $_POST["contrasena_jugador_admin"];
$posicion_jugador_admin = $_POST["posicion_jugador_admin"];
$edad_jugador_admin = $_POST["edad_jugador_admin"];
$rol_jugador_admin = $_POST["rol_jugador_admin"];
$correo_jugador_admin = $_POST["correo_jugador_admin"];

$query_check = "SELECT COUNT(*) as contar FROM jugadores WHERE nombre = ? ";
$stmt_check = mysqli_prepare($conn, $query_check);

// Verificar la preparación de la consulta
if (!$stmt_check) {
    die("Error en la preparación de la consulta: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt_check, "s", $nombre_jugador_admin);
mysqli_stmt_execute($stmt_check);
mysqli_stmt_bind_result($stmt_check, $contar);
mysqli_stmt_fetch($stmt_check);
mysqli_stmt_close($stmt_check);

if ($contar > 0) {
    header("location:../modulos/registro_jugadorPoAdmin.php?error=1");
} else {
    $query_insert = "INSERT INTO jugadores (nombre, contrasena_jugador, posicion, edad, rol_jugador, correo_jugador) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $query_insert);

    // Verificar la preparación de la consulta
    if (!$stmt_insert) {
        die("Error en la preparación de la consulta: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt_insert, "ssssss", $nombre_jugador_admin, $contrasena_jugador_admin, $posicion_jugador_admin, $edad_jugador_admin, $rol_jugador_admin, $correo_jugador_admin);

    if (mysqli_stmt_execute($stmt_insert)) {
    
        header("location:../modulos/registro_jugadorPoAdmin.php?error=2");
    } else {
       header("location:../modulos/registro_jugadorPoAdmin.php?error=3");
    }

    mysqli_stmt_close($stmt_insert);
}

mysqli_close($conn);
