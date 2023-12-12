<?php
require '../conn.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPartido = $_POST["id_partido"];
    $golesEquipoLocal = $_POST["goles_equipo_local"];
    $golesEquipoVisitante = $_POST["goles_equipo_visitante"];

    // Asegúrate de que los valores sean numéricos
    $golesEquipoLocal = intval($golesEquipoLocal);
    $golesEquipoVisitante = intval($golesEquipoVisitante);

    // Obtener los datos del partido
    $queryPartido = "SELECT equipo_local_id, equipo_visitante_id FROM partidos WHERE id_partido = ?";
    $stmtPartido = mysqli_prepare($conn, $queryPartido);

    if ($stmtPartido) {
        mysqli_stmt_bind_param($stmtPartido, "i", $idPartido);
        mysqli_stmt_execute($stmtPartido);
        mysqli_stmt_bind_result($stmtPartido, $equipoLocalId, $equipoVisitanteId);
        mysqli_stmt_fetch($stmtPartido);
        mysqli_stmt_close($stmtPartido);

        // Actualizar marcador y marcar como confirmado
        $queryActualizarMarcador = "UPDATE partidos SET goles_local = ?, goles_visitante = ?, confirmado = 1 WHERE id_partido = ?";
        $stmtActualizarMarcador = mysqli_prepare($conn, $queryActualizarMarcador);

        if ($stmtActualizarMarcador) {
            mysqli_stmt_bind_param($stmtActualizarMarcador, "iii", $golesEquipoLocal, $golesEquipoVisitante, $idPartido);
            mysqli_stmt_execute($stmtActualizarMarcador);
            mysqli_stmt_close($stmtActualizarMarcador);

            // Llamar a la función para actualizar partidos ganados


            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $idPartido = $_POST["id_partido"];
                $golesEquipoLocal = $_POST["goles_equipo_local"];
                $golesEquipoVisitante = $_POST["goles_equipo_visitante"];

                // Asegúrate de que los valores sean numéricos
                $golesEquipoLocal = intval($golesEquipoLocal);
                $golesEquipoVisitante = intval($golesEquipoVisitante);

                // Obtener los datos del partido
                $queryPartido = "SELECT equipo_local_id, equipo_visitante_id FROM partidos WHERE id_partido = ?";
                $stmtPartido = mysqli_prepare($conn, $queryPartido);

                if ($stmtPartido) {
                    mysqli_stmt_bind_param($stmtPartido, "i", $idPartido);
                    mysqli_stmt_execute($stmtPartido);
                    mysqli_stmt_bind_result($stmtPartido, $equipoLocalId, $equipoVisitanteId);
                    mysqli_stmt_fetch($stmtPartido);
                    mysqli_stmt_close($stmtPartido);

                    // Actualizar marcador y marcar como confirmado
                    $queryActualizarMarcador = "UPDATE partidos SET goles_local = ?, goles_visitante = ?, confirmado = 1 WHERE id_partido = ?";
                    $stmtActualizarMarcador = mysqli_prepare($conn, $queryActualizarMarcador);

                    if ($stmtActualizarMarcador) {
                        mysqli_stmt_bind_param($stmtActualizarMarcador, "iii", $golesEquipoLocal, $golesEquipoVisitante, $idPartido);
                        mysqli_stmt_execute($stmtActualizarMarcador);
                        mysqli_stmt_close($stmtActualizarMarcador);

                

                        // Ejecutar el procedimiento almacenado para actualizar partidos ganados
                        $queryActualizarPartidosGanados = "CALL actualizarPartidosGanados()";
                        $result = mysqli_query($conn, $queryActualizarPartidosGanados);

                        if ($result) {
                            //echo "Procedimiento actualizarPartidosGanados ejecutado correctamente.";
                        } else {
                            echo "Error al ejecutar el procedimiento: " . mysqli_error($conn);
                        }

                        // Llamar a la función para actualizar partidos empatados
                        actualizarPartidosEmpatados($conn);
                    } else {
                        die("Error al preparar la consulta para actualizar marcador: " . mysqli_error($conn));
                    }
                }
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $idPartido = $_POST["id_partido"];
                $golesEquipoLocal = $_POST["goles_equipo_local"];
                $golesEquipoVisitante = $_POST["goles_equipo_visitante"];

                // ... (Código para actualizar marcador)

                // Luego de actualizar los partidos ganados, ejecuta el procedimiento para actualizar partidos perdidos
                $queryActualizarPerdidos = "CALL actualizarPartidosPerdidos()";
                $resultActualizarPerdidos = mysqli_query($conn, $queryActualizarPerdidos);

                if ($resultActualizarPerdidos) {
                  //  echo "Procedimiento actualizarPartidosPerdidos ejecutado correctamente.";
                } else {
                    echo "Error al ejecutar el procedimiento actualizarPartidosPerdidos: " . mysqli_error($conn);
                }
            }



            // Llamar a la función para actualizar partidos empatados
            actualizarPartidosEmpatados($conn);
        } else {
            die("Error al preparar la consulta para actualizar marcador: " . mysqli_error($conn));
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $idPartido = $_POST["id_partido"];
    $golesEquipoLocal = $_POST["goles_equipo_local"];
    $golesEquipoVisitante = $_POST["goles_equipo_visitante"];

    // Lógica para confirmar el marcador
    $queryConfirmarMarcador = "UPDATE partidos SET goles_local = $golesEquipoLocal, goles_visitante = $golesEquipoVisitante, confirmado = 1 WHERE id_partido = $idPartido";

    $resultConfirmarMarcador = mysqli_query($conn, $queryConfirmarMarcador);

    if ($resultConfirmarMarcador) {
       // echo "Marcador confirmado exitosamente.";

       
        // Ejecutar la consulta después de confirmar el marcador
        $queryDespuesDeConfirmar = "
            TRUNCATE TABLE total_partidos;
        ";

        $resultDespuesDeConfirmar1 = mysqli_query($conn, $queryDespuesDeConfirmar);

        if ($resultDespuesDeConfirmar1) {
            // Ahora ejecutamos la segunda parte de la consulta
            $queryDespuesDeConfirmar2 = "
                INSERT INTO total_partidos (total_partidos_confirmados)
                SELECT COUNT(*) as total_registros FROM partidos WHERE confirmado = 1;
            ";

            $resultDespuesDeConfirmar2 = mysqli_query($conn, $queryDespuesDeConfirmar2);

            if ($resultDespuesDeConfirmar2) {
                //echo "Consulta ejecutada después de confirmar el marcador.";
            } else {
                echo "Error al ejecutar la segunda parte de la consulta después de confirmar el marcador: " . mysqli_error($conn);
            }
        } else {
            echo "Error al ejecutar la primera parte de la consulta después de confirmar el marcador: " . mysqli_error($conn);
        }
    } else {
        echo "Error al confirmar el marcador: " . mysqli_error($conn);
    }
} else {
    // Si el formulario no se envió correctamente, redirigir a alguna página de error o manejar según sea necesario
    echo "Error: El formulario no se envió correctamente.";
}



function actualizarPartidosEmpatados($conn)
{
    $sqlBorrarEmpatados = "DELETE FROM p_empatados";

    if ($conn->query($sqlBorrarEmpatados) === TRUE) {
      //  echo "Se eliminaron todos los datos de p_empatados correctamente.";
    } else {
        echo "Error al eliminar datos: " . $conn->error;
    }

    $query = "INSERT INTO p_empatados (equipo_id, cantidad)
      SELECT e.id_equipo, IFNULL(COUNT(p.id_partido), 0) AS partidos_empatados
      FROM equipos e
      LEFT JOIN (
          SELECT equipo_local_id AS equipo_id, id_partido
          FROM partidos
          WHERE goles_local = goles_visitante
          UNION ALL
          SELECT equipo_visitante_id AS equipo_id, id_partido
          FROM partidos
          WHERE goles_visitante = goles_local
      ) p ON e.id_equipo = p.equipo_id
      GROUP BY e.id_equipo
      ON DUPLICATE KEY UPDATE cantidad = VALUES(cantidad)";

    if ($conn->query($query)) {
        //echo "Tabla p_empatados actualizada correctamente.";
    } else {
        echo "Error al ejecutar la consulta de actualización: " . $conn->error;
    }
}
