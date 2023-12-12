<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usernameRes'])) {
    header("location: ../index.php");
    exit();
}

// Obtener el rol del usuario
$rol = $_SESSION['rol'];

// Verificar el rol antes de permitir el acceso
if ($rol !== 'Entrenador') {
    echo 'Acceso no autorizado.';
    exit();
}

require '../conn.php';
require '../php/funciones.php';
// Obtener el ID del entrenador
$entrenador_id = obtenerIdUsuario($_SESSION['usernameRes'], $conn);

// Verificar si el entrenador tiene un equipo asignado
$query_equipo = "SELECT nombre_equipo, logo FROM equipos WHERE entrenador_id = ?";
$stmt_equipo = mysqli_prepare($conn, $query_equipo);
mysqli_stmt_bind_param($stmt_equipo, "i", $entrenador_id);
mysqli_stmt_execute($stmt_equipo);
mysqli_stmt_bind_result($stmt_equipo, $nombre_equipo, $logo_equipo);
mysqli_stmt_fetch($stmt_equipo);
mysqli_stmt_close($stmt_equipo);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Mi Equipo</title>
</head>

<body class="caja-general">
    <div class="caja_nav_mi_equipo">
        <?php include('../layouts/nav_Entrenador.php') ?>

    </div>
    <div id="caja-contador">
        <p id="contador">Cargando contador...</p>
    </div>
    <div id="info-mi-equipo">
        <div>
            <h2>Mi Equipo</h2>
        </div>

        <div>
            <?php if (isset($nombre_equipo)) : ?>
                <p>Nombre del Equipo: <?php echo $nombre_equipo; ?></p>
                <?php if (isset($logo_equipo)) : ?>
                    <img src="<?php echo $logo_equipo; ?>" alt="Logo del Equipo">
                <?php endif; ?>
            <?php else : ?>
                <p>No tienes un equipo asignado.</p>
            <?php endif; ?>
        </div>

    </div>

    <script src="../contador_visitas/contador.js"></script>

    <script src="../assets/js/script.js"></script>
</body>

</html>