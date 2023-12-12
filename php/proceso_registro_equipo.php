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

// Procesar el formulario de registro de equipo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../conn.php';

    $nombre_equipo = $_POST["nombre_equipo"];

    // Manejar la carga del logo
    $logo_tmp = $_FILES["logo_equipo"]["tmp_name"];
    $logo_nombre = $_FILES["logo_equipo"]["name"];
    $logo_extension = pathinfo($logo_nombre, PATHINFO_EXTENSION);
    $directorio_destino = "../uploads/";

    // Generar un nombre único para evitar conflictos
    $nombre_logo_unico = uniqid('logo_', true) . '.' . $logo_extension;
    $ruta_logo_destino = $directorio_destino . $nombre_logo_unico;

    // Mover la imagen al directorio de destino
    move_uploaded_file($logo_tmp, $ruta_logo_destino);

    // Verificar si el equipo ya existe
    $query_check = "SELECT COUNT(*) as contar FROM Equipos WHERE nombre_equipo = ?";
    $stmt_check = mysqli_prepare($conn, $query_check);
    mysqli_stmt_bind_param($stmt_check, "s", $nombre_equipo);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_bind_result($stmt_check, $contar);
    mysqli_stmt_fetch($stmt_check);
    mysqli_stmt_close($stmt_check);

    if ($contar > 0) {
        echo "<script>alert('El equipo ya existe. Elige otro nombre.')</script>";
    } else {
        // Insertar el equipo en la base de datos
        $query_insert = "INSERT INTO Equipos (nombre_equipo, entrenador_id, logo) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $query_insert);
        $entrenador_id = obtenerIdUsuario($_SESSION['usernameRes']);
        mysqli_stmt_bind_param($stmt_insert, "sis", $nombre_equipo, $entrenador_id, $ruta_logo_destino);
        
        if (mysqli_stmt_execute($stmt_insert)) {
            echo "<script>alert('Equipo registrado exitosamente.')</script>";
            header("location: ../index.php");
        } else {
            echo "<script>alert('Error al registrar el equipo.')</script>";
        }

        mysqli_stmt_close($stmt_insert);
    }

    mysqli_close($conn);
}

function obtenerIdUsuario($nombre_usuario) {
    require '../conn.php';
    
    $query = "SELECT id_usuario FROM Usuarios WHERE nombre_usuario = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $nombre_usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_usuario);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $id_usuario;
}
?>