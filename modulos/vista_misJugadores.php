<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usernameRes'])) {
    header("../index.php");
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

// Obtener el ID del equipo del entrenador
$equipo_id = obtenerEquipoEntrenador($entrenador_id, $conn);

// Obtener la lista de jugadores del equipo
$jugadores = obtenerJugadoresEquipo($equipo_id, $conn);

// Cerrar la conexión
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Mis Jugadores</title>
</head>

<body class="caja-general">
    <div class="caja_nav_mis_jugadores">
        <?php include('../layouts/nav_Entrenador.php') ?>
    </div>
    
        <div id='mensaje-registro-entrenador'>
            <h2>Mis Jugadores</h2>
        </div>
        <div class='caja-form-lista-resultados-partidos'>

            <?php if (!empty($jugadores)) : ?>
             
                <table class="table">
                    <thead id="thead_tabla_misJugadores">
                        <tr class='tabla_elemento_encabezado'>
                            <th class="th_tabla_misJugadores">ID</th>
                            <th class="th_tabla_misJugadores">Nombre</th>
                            <th class="th_tabla_misJugadores">Posición</th>
                            <th class="th_tabla_misJugadores">Edad</th>
                            <th class="th_tabla_misJugadores">Opciones</th>
                        </tr>
                    </thead>
                

                    <tbody id="tbody_tabla_misJugadores">
                        <?php foreach ($jugadores as $jugador) : ?>
                            <tr class='elemento_tabla'>
                                <td class="td_tabla_misJugadores"><?php echo $jugador['id_jugador']; ?></td>
                                <td class="td_tabla_misJugadores"><?php echo $jugador['nombre_jugador']; ?></td>
                                <td class="td_tabla_misJugadores"><?php echo $jugador['posicion_jugador']; ?></td>
                                <td class="td_tabla_misJugadores"><?php echo $jugador['edad_jugador']; ?></td>
                                <td class="td_tablas_misJugadores">
                                    <form action="../php/proceso_baja_jugador.php" method="post">
                                        <input type="hidden" name="id_jugador" value="<?php echo $jugador['id_jugador']; ?>">
                                        <button type="submit">Dar de Baja</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
                
                <?php else : ?>
                    
                    <div id='mensaje-sin-jugadores'>
                    <p>No tienes jugadores asignados.</p>
                    </div>
       
                <?php endif; ?>
              
    
    <script src="../assets/js/script.js"></script>
</body>

</html>