<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Registro de Jugador</title>
</head>

<body class="caja-general">
    <div class="caja_nav_regs_entrenador">
        <?php include('../layouts/nav_Entrenador.php') ?>
    </div>

    <div id="mensaje-registro-entrenador">
        <h2>Registro De Jugador</h2>
    </div>
    <div class="caja-form-regs-jugador">
        <form action="../php/proceso_registro_jugador.php" method="post">

            <div class="caja-text">
                <label for="nombre">Nombre del Jugador:</label>
                <input type="text" id="nombre" name="nombre_jugador" required>
            </div>

            <div class="caja-compact">
                <div class="caja-text">
                    <label for="edad">Edad del Jugador:</label>
                    <input type="number" id="edad" name="edad_jugador" required>
                </div>
                <div class="caja-text">
                    <label for="posicion">Posición del Jugador:</label>
                    <input type="text" id="posicion" name="posicion_jugador" required>
                </div>
            </div>
            <div class="caja-compact" id="caja_compact_psw_cargo">
                <div class="caja-text" >
                    <label for="contrasena" >Contraseña del Jugador:</label>
                    <input type="text" id="contrasena_jugador" name="contrasena_jugador" required>
                </div>

                <div class="caja-text">
                    <label for="cargo">Cargo:</label>
                    <input type="text" id="cargo" name="rol_jugador" required value="Jugador" readonly>
                </div>
            </div>






            <div class="caja-text">
                <label for="correo">Correo:</label>
                <input type="text" id="correo_jugador" name="correo_jugador" required>
            </div>
            <div class="btn-registrar">
                <button type="submit">Registrar</button>
            </div>
        </form>
    </div>

    <script src="../assets/js/script.js"></script>
</body>

</html>