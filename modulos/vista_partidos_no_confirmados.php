<?php
require '../conn.php';

// Consulta para obtener los partidos no confirmados
$queryPartidosNoConfirmados = "SELECT partidos.id_partido, equipos_local.nombre_equipo as equipo_local, equipos_visitante.nombre_equipo as equipo_visitante
                               FROM partidos
                               INNER JOIN equipos as equipos_local ON partidos.equipo_local_id = equipos_local.id_equipo
                               INNER JOIN equipos as equipos_visitante ON partidos.equipo_visitante_id = equipos_visitante.id_equipo
                               WHERE partidos.confirmado = 0";

$resultPartidosNoConfirmados = mysqli_query($conn, $queryPartidosNoConfirmados);

if (!$resultPartidosNoConfirmados) {
    die("Error al ejecutar la consulta: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Registrar Marcador</title>
</head>

<body class="caja-general">

    <?php include('../layouts/nav.php') ?>

    <div id="mensaje-registro-entrenador">
        <h2>Partidos no confirmados</h2>
    </div>

    <div class="caja-form-lista-entrenador">
        <table class="table" border="1">
            <tr class="tabla_elemento_encabezado">
                <th>Equipo Local</th>
                <th>Equipo Visitante</th>
                <th>Acciones</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($resultPartidosNoConfirmados)) {
                echo "<tr class='elemento_tabla'>";
                echo "<td>" . $row['equipo_local'] . "</td>";
                echo "<td>" . $row['equipo_visitante'] . "</td>";
                echo "<td><a href='#' onclick='abrirModal(" . $row['id_partido'] . ");'>Registrar Marcador</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>


    <!-- Ventana modal -->
    <div id="miModal" class="modal">

       
        <div class="modal-contenido">
            <!-- Contenido del formulario -->
            <div id="contenidoModal"></div>
        </div>
    </div>
    <script>
    window.addEventListener('message', function(event) {
        // Verificar si la señal proviene de la modal y tiene el mensaje 'modalClosed'
        if (event.source === window && event.data === 'modalClosed') {
            console.log('Señal de cierre recibida. Recargando la página principal.');
            // Recargar la página principal
            location.reload();
        } else {
            console.log('Señal inesperada:', event.data);
        }
    });
</script>
    <script src="../assets/js/script.js"></script>
 

</body>

</html>

<?php
mysqli_free_result($resultPartidosNoConfirmados);
mysqli_close($conn);
?>