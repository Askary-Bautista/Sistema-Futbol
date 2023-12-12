<?php

function obtenerRolUsuario($usuario_Entrenador, $conn)
{
    $query = "SELECT rol FROM usuarios WHERE nombre_usuario = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $usuario_Entrenador);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $rol);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $rol;
}

function obtenerRolJugador($usuario_Jugador, $conn)
{
    $query = "SELECT rol_jugador FROM jugadores WHERE nombre = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $usuario_Jugador);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $rol_jugador);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $rol_jugador;
}


function obtenerIdUsuario($nombre_usuario, $conn)
{
    $query = "SELECT id_usuario FROM usuarios WHERE nombre_usuario = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $nombre_usuario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_usuario);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $id_usuario;
}
function obtenerIdJugador($nombre_jugador, $conn)
{
    $query = "SELECT id_jugador FROM jugadores WHERE nombre = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $nombre_jugador);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id_jugador);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $id_jugador;
}


function obtenerEquipoEntrenador($entrenador_id, $conn)
{
    $query = "SELECT id_equipo FROM equipos WHERE entrenador_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Error en la preparación de la consulta equipoEntrenador: " . mysqli_error($conn));
    }

    // Enlace de parámetros
    mysqli_stmt_bind_param($stmt, "i", $entrenador_id);

    // Ejecutar la consulta
    if (!mysqli_stmt_execute($stmt)) {
        die("Error al ejecutar la consulta equipoEntrenador: " . mysqli_error($conn));
    }

    // Enlace de resultados
    mysqli_stmt_bind_result($stmt, $equipo_id);

    // Obtener el valor
    mysqli_stmt_fetch($stmt);

    // Cerrar la declaración
    mysqli_stmt_close($stmt);

    if ($equipo_id === null) {
        die("Error: No se pudo obtener el ID del equipo para el entrenador.");
    }

    return $equipo_id;
}

function obtenerJugadoresEquipo($equipo_id, $conn)
{
    $query = "SELECT id_jugador, nombre, posicion, edad FROM jugadores WHERE equipo_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Error en la preparación de la consulta obtenerJugadoresEquipo: " . mysqli_error($conn));
    }

    // Enlace de parámetros
    mysqli_stmt_bind_param($stmt, "i", $equipo_id);

    // Ejecutar la consulta
    if (!mysqli_stmt_execute($stmt)) {
        die("Error al ejecutar la consulta obtenerJugadoresEquipo: " . mysqli_error($conn));
    }

    // Enlace de resultados
    mysqli_stmt_bind_result($stmt, $id_jugador, $nombre_jugador, $posicion_jugador, $edad_jugador);

    // Recoger los resultados en un array asociativo
    $resultados = array();
    while (mysqli_stmt_fetch($stmt)) {
        $resultados[] = array(
            'id_jugador' => $id_jugador,
            'nombre_jugador' => $nombre_jugador,
            'posicion_jugador' => $posicion_jugador,
            'edad_jugador' => $edad_jugador
        );
    }

    // Cerrar la declaración
    mysqli_stmt_close($stmt);

    return $resultados;
}

function darDeBajaJugador($id_jugador, $conn)
{
    $query = "UPDATE Jugadores SET equipo_id = NULL WHERE id_jugador = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Error en la preparación de la consulta darDeBajaJugador: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $id_jugador);

    if (!mysqli_stmt_execute($stmt)) {
        die("Error al ejecutar la consulta darDeBajaJugador: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
}

function obtenerConexion()
{
    // Crear conexión
    $conexion = mysqli_connect("localhost", "root", "", "liga_futbol");

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    } else {
        // echo 'Conectado a la base de datos';
    }

    return $conexion;
}

function obtenerNombreEquipo($equipoID)
{
    // Realiza la conexión a la base de datos (asegúrate de tener esta función)
    $conn = obtenerConexion();

    $query = "SELECT nombre_equipo FROM equipos WHERE id_equipo = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $equipoID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nombreEquipo);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Cierra la conexión a la base de datos
    mysqli_close($conn);

    return $nombreEquipo;
}

// En funciones.php

function obtenerListaEntrenadores($conn)
{
    $entrenadores = array();

    // Realiza la consulta para obtener la lista de entrenadores
    $query = "SELECT id_usuario, nombre_usuario FROM usuarios WHERE rol = 'Entrenador'";
    $result = mysqli_query($conn, $query);

    // Verifica si la consulta fue exitosa
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Agrega cada entrenador al array
            $entrenadores[] = array(
                'id_usuario' => $row['id_usuario'],
                'nombre_usuario' => $row['nombre_usuario']
            );
        }
        // Libera el resultado
        mysqli_free_result($result);
    }

    return $entrenadores;
}

// En funciones.php

function obtenerListaEquipos($conn)
{
    $equipos = array();

    // Realiza la consulta para obtener la lista de equipos con información del entrenador
    $query = "SELECT e.id_equipo, e.nombre_equipo, e.logo, u.nombre_usuario as nombre_usuario
              FROM equipos e
              JOIN usuarios u ON e.entrenador_id = u.id_usuario";
    $result = mysqli_query($conn, $query);

    // Verifica si la consulta fue exitosa
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Agrega cada equipo al array
            $equipos[] = array(
                'id_equipo' => $row['id_equipo'],
                'nombre_equipo' => $row['nombre_equipo'],
                'logo' => $row['logo'],
                'nombre_usuario' => $row['nombre_usuario']
            );
        }
        // Libera el resultado
        mysqli_free_result($result);
    }

    return $equipos;
}


function obtenerDatosPartido($conn, $idPartido)
{
    $queryPartido = "SELECT equipo_local_id, equipo_visitante_id FROM partidos WHERE id_partido = ?";
    $stmtPartido = mysqli_prepare($conn, $queryPartido);

    if ($stmtPartido) {
        mysqli_stmt_bind_param($stmtPartido, "i", $idPartido);
        mysqli_stmt_execute($stmtPartido);
        mysqli_stmt_bind_result($stmtPartido, $equipoLocalId, $equipoVisitanteId);

        if (mysqli_stmt_fetch($stmtPartido)) {
            mysqli_stmt_close($stmtPartido);
            return [
                'equipo_local_id' => $equipoLocalId,
                'equipo_visitante_id' => $equipoVisitanteId,
            ];
        } else {
            mysqli_stmt_close($stmtPartido);
            return null;
        }
    } else {
        die("Error al preparar la consulta para obtener datos del partido: " . mysqli_error($conn));
    }
}

function obtenerLogoEquipo($equipo_id, $conn)
{
    $query = "SELECT logo FROM equipos WHERE id_equipo = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Error en la preparación de la consulta obtenerLogoEquipo: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $equipo_id);

    if (!mysqli_stmt_execute($stmt)) {
        die("Error al ejecutar la consulta obtenerLogoEquipo: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_result($stmt, $logo);

    if (mysqli_stmt_fetch($stmt)) {
        mysqli_stmt_close($stmt);
        return $logo;
    } else {
        mysqli_stmt_close($stmt);
        return "../images/no-fotos.png"; // Puedes establecer una ruta por defecto
    }
}

function darDeBajaEquipo($equipo_id, $conn)
{
    // Quitar el valor de la columna "logo" en lugar de eliminar el equipo
    $query = "UPDATE equipos SET logo = NULL WHERE id_equipo = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Error en la preparación de la consulta darDeBajaEquipo: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $equipo_id);

    if (!mysqli_stmt_execute($stmt)) {
        die("Error al ejecutar la consulta darDeBajaEquipo: " . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);

    // Quitar el equipo al entrenador
    $queryQuitarEquipo = "UPDATE usuarios SET equipo_id = NULL WHERE equipo_id = ?";
    $stmtQuitarEquipo = mysqli_prepare($conn, $queryQuitarEquipo);

    if (!$stmtQuitarEquipo) {
        die("Error en la preparación de la consulta quitarEquipoEntrenador: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmtQuitarEquipo, "i", $equipo_id);

    if (!mysqli_stmt_execute($stmtQuitarEquipo)) {
        die("Error al ejecutar la consulta quitarEquipoEntrenador: " . mysqli_stmt_error($stmtQuitarEquipo));
    }

    mysqli_stmt_close($stmtQuitarEquipo);
}
