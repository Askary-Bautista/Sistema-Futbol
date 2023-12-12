
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Resto del código...

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usernameRes'])) {
    header("location: ../modulos/login.php");
    exit();
}
$usuario = $_SESSION['usernameRes'];
?>
<header>
    <nav>
        <ul>
            <!-- Enlaces de navegación -->
            <li><a href="../modulos/registro_jugador.php">Registrar Jugador</a></li>
            <li><a href="../modulos/regitro_equipo.php">Registrar Equipo</a></li>
            <li><a href="../modulos/vista_miEquipo.php">Mi Equipo</a></li>
            <li><a href="../modulos/jugadores_no_asignadores_entrenador.php">Jugadores Disponibles</a></li>
            <li><a href="../modulos/vista_misJugadores.php">Mis Jugadores</a></li>
            <li><a href="../modulos/vista_clasificacion_entrenador.php">Tabla Pocentual</a></li>
            <li id="li-Bienvenido">
                    <a >
                        Bienvenido <?php echo "$usuario" ?>
                        <ul id="li-cerrarSesion-Entrenador">
                            <li><a  href="../php/logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </a>
                </li>
            
        </ul>
    </nav>
</header>