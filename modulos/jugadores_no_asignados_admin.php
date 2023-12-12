<?php
// Conexión a la base de datos y funciones necesarias
require '../conn.php';
require '../php/funciones.php';

// Obtener la lista de jugadores no asignados
$jugadores_no_asignados = obtenerJugadoresNoAsignados($conn);

// Obtener la lista de equipos disponibles
$equipos_disponibles = obtenerEquiposDisponibles($conn);

// Función para obtener jugadores no asignados
function obtenerJugadoresNoAsignados($conn)
{
    $query = "SELECT id_jugador, nombre FROM Jugadores WHERE equipo_id IS NULL";
    $result = mysqli_query($conn, $query);

    $jugadores = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $jugadores[] = $row;
    }

    return $jugadores;
}

// Función para obtener equipos disponibles
function obtenerEquiposDisponibles($conn)
{
    $query = "SELECT id_equipo, nombre_equipo FROM equipos";
    $result = mysqli_query($conn, $query);

    $equipos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $equipos[] = $row;
    }

    return $equipos;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Equipos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="./assets/plugins/SweetAlert/dist/sweetalert2.min.css">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />


</head>

<body class="caja-general">
    <?php include('../layouts/nav.php') ?>


    <div id="mensaje-registro-entrenador">
        <h2>Lista de Jugadores No Asignados</h2>
    </div>

    <div class="caja-lista-jugadores">
        <form action="../php/proceso_asignacion_admin.php" method="post">
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
                                    <?php foreach ($equipos_disponibles as $equipo) : ?>
                                        <option value=""></option>
                                        <option value="<?php echo $equipo['id_equipo']; ?>"><?php echo $equipo['nombre_equipo']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
            <br>
            <div class="btn-asignar">
                <button type="submit">Asignar Equipos</button>
            </div>
        </form>
    </div>
    <script>
        $('select').select2({
            templateSelection: function(data) {
                if (data.id === '') { // adjust for custom placeholder values
                    return 'Custom styled placeholder text';
                }

                return data.text;
            }
        });
    </script>   
    <?php
    if (isset($_GET['error']) && $_GET['error'] == 1) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    text: "Jugador/es  asignados Exitosamente!!",
                });
            });
          </script>';
    }
    ?>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script src="../assets/plugins/SweetAlert/dist/sweetalert2.all.min.js"></script>
</body>

</html>