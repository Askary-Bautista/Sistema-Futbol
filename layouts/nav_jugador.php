
<?php
$usuario = $_SESSION['usernameRes'];
?>
<header>
        <nav>
            <ul >
                <!-- Enlaces de navegación -->
                <li><a href="../modulos/vista_miEquipo_jugador.php">Mi Equipo</a></li>
                <li><a href="../modulos/vista_clasificacion_jugador.php">Ver Clasificacion</a></li>
                <li id="li-Bienvenido">
                    <a href="#">
                        Bienvenido <?php echo "$usuario" ?>
                        <ul id="li-cerrarSesion">
                            <li id="li-cerrarSesion-Jugador"><a href="../php/logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </a>
                </li>
            </ul>
        </nav>
    </header>