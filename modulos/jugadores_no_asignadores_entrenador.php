<?php

session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usernameRes'])) {
    header("location: ../modulos/login.php");
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
$equipo_id_entrenador = obtenerEquipoEntrenador($entrenador_id, $conn);

// Obtener la lista de jugadores no asignados al equipo del entrenador
$jugadores_no_asignados = obtenerJugadoresNoAsignados($conn, $equipo_id_entrenador);

function obtenerJugadoresNoAsignados($conn)
{
    $query = "SELECT id_jugador, nombre FROM Jugadores WHERE equipo_id IS NULL";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Error en la preparación de la consulta obtenerJugadoresNoAsignados: " . mysqli_error($conn));
    }

    if (!mysqli_stmt_execute($stmt)) {
        die("Error al ejecutar la consulta obtenerJugadoresNoAsignados: " . mysqli_stmt_error($stmt));
    }

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Error al obtener el resultado de la consulta obtenerJugadoresNoAsignados: " . mysqli_stmt_error($stmt));
    }

    $jugadores = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $jugadores[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $jugadores;
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="caja-general">
    <div class="caja_nav_regs_entrenador">
        <?php include('../layouts/nav_Entrenador.php') ?>
    </div>

    <div id="mensaje-registro-entrenador">

        <h2>Lista de Jugadores No Asignados a tu Equipo</h2>
    </div>
    <div class="caja-form-regs-entrenador">
        <form action="../php/proceso_asignacion_entrenador.php" method="post">
            <table class="table">
                <thead id="thead_tabla_asignarJugadores_admin">
                    <tr id="tr_asignarJugadores_admin">
                        <th class="th_tabla_asignarJugadores_admin">Jugador</th>
                        <th class="th_tabla_asignarJugadores_admin">Equipo</th>
                    </tr>

                </thead>

                <tbody id="tbody_tabla_asignarJugadores_admin">
                    <?php foreach ($jugadores_no_asignados as $jugador) : ?>
                        <tr id="tr_tabla_asignarJugadores_admin">
                            <td class="td_asignarJugadores_admin"><?php echo $jugador['nombre']; ?></td>
                            <td class="td_asignarJugadores_admin">
                                <select class="js-example-placeholder-single js-states form-control" name="equipo[<?php echo $jugador['id_jugador']; ?>]">
                                    <option value=""></option>
                                    <option value="<?php echo $equipo_id_entrenador; ?>">Mi Equipo</option>
                                </select>
                            </td>
                           
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

            <div class="btn-asignar">
                <button type="submit">Asignar Equipos</button>
            </div>
        </form>
    </div>
    <script>
  $('select').select2({
  templateSelection: function (data) {
    if (data.id === '') { // adjust for custom placeholder values
      return 'Custom styled placeholder text';
    }

    return data.text;
  }
});
</script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

</body>

</html>