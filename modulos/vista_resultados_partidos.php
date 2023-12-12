<?php
require '../conn.php';

// Obtener resultados de los partidos
$queryResultados = "
    SELECT e.id_enfrentamiento, e.fecha, local.nombre_equipo as equipo_local, visitante.nombre_equipo as equipo_visitante, p.goles_local, p.goles_visitante
    FROM enfrentamientos e
    LEFT JOIN partidos p ON e.id_partido = p.id_partido
    LEFT JOIN equipos local ON e.equipo_local = local.id_equipo
    LEFT JOIN equipos visitante ON e.equipo_visitante = visitante.id_equipo
    WHERE p.confirmado = 1
";

$resultResultados = mysqli_query($conn, $queryResultados);

if (!$resultResultados) {
    die("Error al ejecutar la consulta: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Resultados y Clasificación</title>
</head>

<body class="caja-general">
    <?php include('../layouts/nav.php') ?>

    <div id="mensaje-registro-entrenador">
        <h2>Resultados y Clasificación</h2>
    </div>


    <!-- Mostrar resultados de los partidos -->
    <div class="caja-form-lista-resultados-partidos">
        <table class="table" border="1">
            <tr class="tabla_elemento_encabezado">
                <th>Fecha</th>
                <th>Equipo Local</th>
                <th>Equipo Visitante</th>
                <th>Goles Equipo Local</th>
                <th>Goles Equipo Visitante</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($resultResultados)) {
                echo "<tr class='elemento_tabla'>
                <td>{$row['fecha']}</td>
                <td>{$row['equipo_local']}</td>
                <td>{$row['equipo_visitante']}</td>
                <td>{$row['goles_local']}</td>
                <td>{$row['goles_visitante']}</td>
              </tr>";
            }
            ?>
        </table>
    </div>

</body>

</html>