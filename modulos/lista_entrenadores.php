<?php
session_start();
require('../conn.php');
require('../php/funciones.php');

$equipos = obtenerListaEquipos($conn);

echo ' <link rel="stylesheet" href="../assets/css/style.css">';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Lista de Equipos</title>
    <!-- Agrega tus estilos o enlaces a hojas de estilo aquí si es necesario -->
</head>

<body class="caja-general">

    <?php include('../layouts/nav.php'); ?>
    <div id="mensaje-registro-entrenador">
        <h2>Lista de Equipos</h2>
    </div>
    <div class="caja-form-lista-entrenador">
        <?php
        // Mostrar la lista de equipos en una tabla
        if (!empty($equipos)) {
            echo '<table class="table" >';
            echo '<tr class="tabla_elemento_encabezado">
            <th>Nombre del Equipo</th>
            <th>Logo</th>
            <th>Entrenador</th>
            </tr>';

            foreach ($equipos as $equipo) {
                echo '<tr class="elemento_tabla">';
                echo '<td>' . $equipo['nombre_equipo'] . '</td>';
                echo '<td><img src="' . $equipo['logo'] . '" alt="Logo del Equipo" style="width: 50px; height: 50px;"></td>';
                echo '<td >' . $equipo['nombre_usuario'] . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo '<p>No hay equipos registrados.</p>';
        }
        ?>
    </div>

</body>

</html>