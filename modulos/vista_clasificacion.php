<?php
require '../conn.php';

// Asegúrate de definir $equipos como un array vacío al principio
$equipos = [];
// Obtener el valor de total_partidos_confirmados
$queryTotalPartidos = "SELECT total_partidos_confirmados FROM total_partidos";
$resultTotalPartidos = mysqli_query($conn, $queryTotalPartidos);

// Inicializar $totalPartidosConfirmados con un valor predeterminado
$totalPartidosConfirmados = 0;

if ($resultTotalPartidos) {
    $rowTotalPartidos = mysqli_fetch_assoc($resultTotalPartidos);
    // Verificar si $rowTotalPartidos no es null antes de intentar acceder a sus elementos
    if ($rowTotalPartidos !== null) {
        $totalPartidosConfirmados = $rowTotalPartidos['total_partidos_confirmados'];
    } else {
        // Manejar la situación cuando $rowTotalPartidos es null
      //  echo "Error: El resultado de la consulta es nulo.";
    }
} else {
    echo "Error al obtener el valor de total_partidos_confirmados: " . mysqli_error($conn);
}

// Determinar si el botón debe estar habilitado
$botonHabilitado = ($totalPartidosConfirmados == 10);

// Resto del código...

function actualizarTablaPorcentual($conn)
{
    // ... (Código de la función actualizarTablaPorcentual)
    // Eliminar registros existentes de tabla_porcentual
    $queryEliminarRegistros = "TRUNCATE TABLE tabla_porcentual";
    $resultEliminarRegistros = mysqli_query($conn, $queryEliminarRegistros);

    if ($resultEliminarRegistros) {
    } else {
        die("Error al eliminar registros existentes: " . mysqli_error($conn));
    }

    // Consulta SQL para tabla_porcentual
    $sqlTablaPorcentual = "
    INSERT INTO tabla_porcentual (equipo_id, nombre_club, p_jugados, p_ganados, p_empatados, p_perdidos, puntos_generales, diferencia_goles, puesto)
    SELECT
        t.equipo_id,
        e.nombre_equipo AS nombre_club,
        COALESCE(t.p_jugados, 0) AS p_jugados,
        COALESCE(t.p_ganados, 0) AS p_ganados,
        COALESCE(t.p_empatados, 0) AS p_empatados,
        COALESCE(t.p_perdidos, 0) AS p_perdidos,
        COALESCE((t.p_ganados * 3 + t.p_empatados), 0) AS puntos_generales,
        COALESCE((t.p_ganados - t.p_perdidos), 0) AS diferencia_goles,
        ROW_NUMBER() OVER (ORDER BY COALESCE((t.p_ganados * 3 + t.p_empatados), 0) DESC, COALESCE((t.p_ganados - t.p_perdidos), 0) DESC) AS puesto
    FROM (
        SELECT
            p_jugados.equipo_id,
            p_jugados.cantidad AS p_jugados,
            COALESCE(p_ganados.cantidad, 0) AS p_ganados,
            COALESCE(p_empatados.cantidad, 0) AS p_empatados,
            COALESCE(p_perdidos.cantidad, 0) AS p_perdidos
        FROM
            p_jugados
            LEFT JOIN p_ganados ON p_jugados.equipo_id = p_ganados.equipo_id
            LEFT JOIN p_empatados ON p_jugados.equipo_id = p_empatados.equipo_id
            LEFT JOIN p_perdidos ON p_jugados.equipo_id = p_perdidos.equipo_id
    ) AS t
    LEFT JOIN equipos AS e ON t.equipo_id = e.id_equipo
    ORDER BY puesto;
    ";

    $resultTablaPorcentual = mysqli_query($conn, $sqlTablaPorcentual);

    if ($resultTablaPorcentual) {
    } else {
        die("Error al actualizar tabla porcentual: " . mysqli_error($conn));
    }
}

// Llamar a la función para actualizar tabla porcentual si se presionó el botón
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["actualizar_tabla"])) {
        actualizarTablaPorcentual($conn);
    }
}

// Recuperar y mostrar la tabla porcentual
$queryMostrarTabla = "SELECT * FROM tabla_porcentual";
$resultMostrarTabla = mysqli_query($conn, $queryMostrarTabla);

if ($resultMostrarTabla) {

    echo '<div class="caja_nav_regs_entrenador">';
    include('../layouts/nav.php');
    echo "</div>";

    echo "<div>";


    // Mostrar el formulario
    echo "<form action='" . $_SERVER["PHP_SELF"] . "' method='post'>
        <button id='boton-general' type='submit' name='actualizar_tabla' " . ($botonHabilitado ? '' : 'disabled') . ">
            Actualizar Tabla Porcentual
        </button>    
        </form>";

    echo "</div>";

    echo "<div  id='mensaje-registro-entrenador'>";
    echo "<h2>Tabla Porcentual Actualizada</h2>";
    echo "</div>";

    echo "<div class='caja-form-lista-resultados-partidos'>";
    echo "<table class='table' border='1'>
            <tr class='tabla_elemento_encabezado'>
                <th>Puesto</th>
                <th>Equipo</th>
                <th>P. Jugados</th>
                <th>P. Ganados</th>
                <th>P. Empatados</th>
                <th>P. Perdidos</th>
                <th>Puntos Generales</th>
                <th>Diferencia de Goles</th>
            </tr>";

    while ($row = mysqli_fetch_assoc($resultMostrarTabla)) {
        echo "<tr class='elemento_tabla'>";
        echo "<td> # " . $row['puesto'] . "</td>";
        echo "<td>" . $row['nombre_club'] . "</td>";
        echo
        "<td>" . $row['p_jugados'] . "</td>";
        echo "<td>" . $row['p_ganados'] . "</td>";
        echo "<td>" . $row['p_empatados'] . "</td>";
        echo "<td>" . $row['p_perdidos'] . "</td>";
        echo "<td>" . $row['puntos_generales'] . "</td>";
        echo "<td>" . $row['diferencia_goles'] . "</td>";
        // Agrega más celdas según tus necesidades
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
} else {
    echo "Error al recuperar la tabla porcentual: " . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="es">


<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Ver Clasificación</title>
</head>

<body class="caja-general">
    <!-- ... (resto del cuerpo del HTML) -->
</body>

</html>