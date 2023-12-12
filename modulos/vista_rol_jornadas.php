<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="./assets/plugins/SweetAlert/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  

    <title>Programación de Partidos</title>
</head>

<body class="caja-general">
    <div class="caja_nav_regs_entrenador">
        <?php include('../layouts/nav.php') ?>
    </div>

    <div >
        <form action="../php/proceso_generar_enfrentamientos.php" method="post">
            <button id="boton-general" type="submit" name="generar_enfrentamientos" >Generar Enfrentamientos</button>
        </form>
    </div>
    <div id="mensaje-registro-entrenador">
        <h2>Programación de Partidos</h2>
    </div>


    <?php
    require('../conn.php');

    // Obtener todos los enfrentamientos
    $query_enfrentamientos = "SELECT * FROM enfrentamientos";
    $result_enfrentamientos = mysqli_query($conn, $query_enfrentamientos);

    $jornada_actual = null;
    $contador = 1; // Contador para simular "jornadas"

    while ($row_enfrentamiento = mysqli_fetch_assoc($result_enfrentamientos)) {
        if ($contador % 2 == 1) {

            echo '<div class="caja-form-lista-enfrentamientos">';
            // Mostrar el texto "Jornada" y el número de jornada cada dos enfrentamientos
            echo '<div class="caja_jornada">';
            echo "<h3>Jornada " . ceil($contador / 2) . "</h3>";
            echo '</div>';
        }

        // Mostrar los partidos
        $equipoLocal = obtenerEquipo($conn, $row_enfrentamiento['equipo_local']);
        $equipoVisitante = obtenerEquipo($conn, $row_enfrentamiento['equipo_visitante']);

        echo '<div class="partido">';

        echo '<div class="equipo_local_general">';
        echo '<div class="equipo_local">';
        echo "<img src='{$equipoLocal['logo']}' alt='Logo Equipo Local'>";
        echo '</div>';

        echo '<div class="equipo_local_nombre">';
        echo "{$equipoLocal['nombre_equipo']}";
        echo '</div>';

        echo '</div>';

        echo '<div class="caja_counter">';
        echo '<h2>VS</h2>';
        echo '</div>';

        echo '<div class="equipo_visitante_general">';

        echo '<div class="equipo_visitante">';
        echo "<img src='{$equipoVisitante['logo']}' alt='Logo Equipo Visitante'>";
        echo '</div>';

        echo '<div class="equipo_visitante_nombre">';
        echo "{$equipoVisitante['nombre_equipo']}";
        echo '</div>';
        echo '</div>';

        echo '<div class="fecha_partido">';
        echo "Fecha: {$row_enfrentamiento['fecha']}";
        echo '</div>';
        echo '<br><br>';
        echo '</div>';








        if ($contador % 2 == 0) {
            // Cerrar el contenedor después de mostrar dos partidos
            echo '</div>';
        }

        $contador++;
    }

    // Cerrar el contenedor si hay un número impar de partidos
    if ($contador % 2 == 1) {
        echo '</div>';
    }

    mysqli_free_result($result_enfrentamientos);
    mysqli_close($conn);

    // Función para obtener la información del equipo a partir de su ID
    function obtenerEquipo($conn, $id_equipo)
    {
        $query_equipo = "SELECT * FROM equipos WHERE id_equipo = $id_equipo";
        $result_equipo = mysqli_query($conn, $query_equipo);

        if ($result_equipo && $row_equipo = mysqli_fetch_assoc($result_equipo)) {
            return $row_equipo;
        }

        return null;
    }
    ?>
    <?php
    if (isset($_GET['error']) && $_GET['error'] == 1) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    text: "Enfrentamientos Generados Exitosamente!!",
                });
            });
          </script>';
    }
    ?>
    <script src="../assets/plugins/SweetAlert/dist/sweetalert2.all.min.js"></script>
</body>

</html>