<?php
session_start();

// Verificar si el usuario no está autenticado
if (!isset($_SESSION['usernameRes'])) {
    // Redireccionar a la página de inicio de sesión
    header("location:modulos/login.php");
    exit;
}

// Obtener el rol del usuario
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
$rol_jugador = isset($_SESSION['rol_jugador']) ? $_SESSION['rol_jugador'] : null;
$rol_admin = isset($_SESSION['rol_admin']) ? $_SESSION['rol_admin'] : null;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Estilos SweetAlert -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/plugins/SweetAlert/dist/sweetalert2.min.css">
</head>

<body class="caja-general">


    <?php
    // Mostrar funciones según el rol
    if ($rol_admin === 'Administrador') {
        include('./layouts/nav.php');
        
    } elseif ($rol === 'Entrenador') {
        include('./layouts/nav_Entrenador.php');
        
    } elseif ($rol_jugador === 'Jugador') {
        include('./layouts/nav_jugador.php');
    }
    ?>

</body>

<script src="./assets/plugins/SweetAlert/dist/sweetalert2.all.min.js"></script>

</html>