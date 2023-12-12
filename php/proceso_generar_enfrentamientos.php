<?php
require '../conn.php';

// Borrar enfrentamientos existentes
$queryBorrarEnfrentamientos = "DELETE FROM enfrentamientos";
if (!mysqli_query($conn, $queryBorrarEnfrentamientos)) {
    die("Error al borrar enfrentamientos existentes: " . mysqli_error($conn));
}

// Borrar enfrentamientos existentes
$queryBorrarPartidos = "DELETE FROM partidos";
if (!mysqli_query($conn, $queryBorrarPartidos)) {
    die("Error al borrar partidos existentes: " . mysqli_error($conn));
}

// Borrar p_jugados existentes
$queryBorrarP_Jugados = "DELETE FROM p_jugados";
if (!mysqli_query($conn, $queryBorrarP_Jugados)) {
    die("Error al borrar p_jugados existentes: " . mysqli_error($conn));
}
//Borrar datos tabla total_partidos

$queryDespuesDeConfirmar = "DELETE FROM total_partidos";
if (!mysqli_query($conn, $queryDespuesDeConfirmar)) {
    die("Error al borrar p_jugados existentes: " . mysqli_error($conn));
}




// Obtener la lista de equipos disponibles
$queryEquipos = "SELECT id_equipo FROM equipos";
$resultEquipos = mysqli_query($conn, $queryEquipos);

$equiposDisponibles = [];
while ($row = mysqli_fetch_assoc($resultEquipos)) {
    $equiposDisponibles[] = $row['id_equipo'];
}

mysqli_free_result($resultEquipos);

// Generar enfrentamientos para todos los equipos
$fechaActual = strtotime(date('Y-m-d')); // Obtener la fecha actual en formato timestamp
$incrementoDias = 1; // Incremento inicial de días

for ($i = 0; $i < count($equiposDisponibles); $i++) {
    // Asegurarse de que un equipo no tenga más de un partido en una jornada
    $equiposDisponiblesTemp = array_diff($equiposDisponibles, [$equiposDisponibles[$i]]);
    shuffle($equiposDisponiblesTemp);

    $equipoLocal = $equiposDisponibles[$i];
    $equipoVisitante = $equiposDisponiblesTemp[0];

    // Generar fecha para el partido (sumar días al incremento actual)
    $fechaPartido = date('Y-m-d', strtotime('+' . $incrementoDias . ' days', $fechaActual));

    // Aumentar el incremento de días para la próxima jornada
    $incrementoDias++;

    // Insertar enfrentamiento en la tabla partidos
    $queryInsertPartido = "INSERT INTO partidos (equipo_local_id, equipo_visitante_id) VALUES (?, ?)";
    $stmtInsertPartido = mysqli_prepare($conn, $queryInsertPartido);

    if ($stmtInsertPartido) {
        mysqli_stmt_bind_param($stmtInsertPartido, "ii", $equipoLocal, $equipoVisitante);
        mysqli_stmt_execute($stmtInsertPartido);

        // Obtener el ID del partido insertado
        $idPartido = mysqli_insert_id($conn);

        // Insertar enfrentamiento en la tabla enfrentamientos
        $queryInsertEnfrentamiento = "INSERT INTO enfrentamientos (id_partido, fecha, equipo_local, equipo_visitante) VALUES (?, ?, ?, ?)";
        $stmtInsertEnfrentamiento = mysqli_prepare($conn, $queryInsertEnfrentamiento);

        if ($stmtInsertEnfrentamiento) {
            mysqli_stmt_bind_param($stmtInsertEnfrentamiento, "issi", $idPartido, $fechaPartido, $equipoLocal, $equipoVisitante);
            mysqli_stmt_execute($stmtInsertEnfrentamiento);
        } else {
            die("Error al preparar la consulta para insertar enfrentamiento: " . mysqli_error($conn));
        }
    } else {
        die("Error al preparar la consulta para insertar partido: " . mysqli_error($conn));
    }
}

//Borrar datos tabla p_ganados
$queryEliminarTablaPGanados = "TRUNCATE TABLE p_ganados";
$resultEliminarRegistros = mysqli_query($conn, $queryEliminarTablaPGanados);

//Borrar datos tabla p_perdidos
$queryEliminarTablaPPerdidos = "TRUNCATE TABLE p_perdidos";
$resultEliminarRegistros = mysqli_query($conn, $queryEliminarTablaPPerdidos);

//Borrar datos tabla p_empatados
$queryEliminarTablaPEmpatados = "TRUNCATE TABLE p_empatados";
$resultEliminarRegistros = mysqli_query($conn, $queryEliminarTablaPEmpatados);

//Borrar datos tabla tabla_Porcentual
$queryEliminarTablaPorcentual = "TRUNCATE TABLE tabla_porcentual";
$resultEliminarRegistros = mysqli_query($conn, $queryEliminarTablaPorcentual);


// Ejecutar la consulta para actualizar la tabla partidos jugados
$queryActualizarPartidosJugados = "
    INSERT INTO p_jugados (equipo_id, cantidad)
    SELECT equipo_id, COUNT(*) as total_repeticiones
    FROM (
    SELECT equipo_local_id as equipo_id FROM partidos
    UNION ALL
    SELECT equipo_visitante_id as equipo_id FROM partidos
    UNION ALL
    SELECT equipo_id FROM tabla_porcentual
    ) equipos_combinados
    GROUP BY equipo_id;
    ";



$resultado = mysqli_query($conn, $queryActualizarPartidosJugados);

if ($resultado) {
    echo "Consulta ejecutada correctamente.";
} else {
    echo "Error al ejecutar la consulta: " . mysqli_error($conn);
}

mysqli_close($conn);

// Redirecciona a la página principal o a donde desees después de generar los enfrentamientos

header("location:../modulos/vista_rol_jornadas.php?error=1");
exit();
