<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usernameRes'])) {
    header("location: ../index.php");
    exit();
}
require '../conn.php';
require '../php/funciones.php';

// Reemplaza esto con el nombre real del jugador
// Reemplaza esto con el nombre real del jugador
$id_jugador = obtenerIdJugador($_SESSION['usernameRes'], $conn);

// Verificar si se encontró el jugador
if ($id_jugador !== null) {
    // Consultar el equipo al que pertenece el jugador
    $query_equipo_jugador = "
    SELECT e.nombre_equipo, e.logo, u.nombre_usuario as nombre_entrenador
    FROM equipos e
    JOIN usuarios u ON e.entrenador_id = u.id_usuario
    WHERE e.id_equipo = (SELECT equipo_id FROM jugadores WHERE id_jugador = ?)
";
    $stmt_equipo_jugador = mysqli_prepare($conn, $query_equipo_jugador);



    // Verifica si la preparación de la consulta fue exitosa
    if ($stmt_equipo_jugador) {
        mysqli_stmt_bind_param($stmt_equipo_jugador, "i", $id_jugador);
        mysqli_stmt_execute($stmt_equipo_jugador);
        mysqli_stmt_bind_result($stmt_equipo_jugador, $nombre_equipo_jugador, $logo_equipo_jugador,$entrenador_equipo_jugador);
        mysqli_stmt_fetch($stmt_equipo_jugador);
        mysqli_stmt_close($stmt_equipo_jugador);

        // Verificar si se encontró el equipo del jugador
        if ($nombre_equipo_jugador !== null) {
            //echo "El jugador pertenece al equipo: $nombre_equipo_jugador";
        } else {
            //echo "No se encontró información sobre el equipo del jugador.";
        }
    } else {
        // Imprime el error de la preparación de la consulta
        echo "Error en la preparación de la consulta: " . mysqli_error($conn);
    }
} else {
    echo "No se encontró el jugador.";
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Mi Equipo</title>
</head>

<body class="caja-general">
    <div class="caja_nav_mi_equipo">
        <?php include('../layouts/nav_jugador.php') ?>
    </div>

    <div id="info-mi-equipo">
        <div>
            <h2>Mi Equipo</h2>
        </div>

        <div>
            <?php if (isset($nombre_equipo_jugador)) : ?>
                <p>Nombre del Equipo: <?php echo $nombre_equipo_jugador; ?></p>
                <p>Nombre del Entrenador: <?php echo $entrenador_equipo_jugador; ?></p>
                <?php if (isset($logo_equipo_jugador)) : ?>
                    <img src="<?php echo $logo_equipo_jugador; ?>" alt="Logo del Equipo">
                <?php endif; ?>
              
            <?php else : ?>
                <p>No tienes un equipo asignado.</p>
            <?php endif; ?>
        </div>

    </div>

    <script src="../assets/js/script.js"></script>
</body>

</html>