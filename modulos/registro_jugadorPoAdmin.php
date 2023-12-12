<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="./assets/plugins/SweetAlert/dist/sweetalert2.min.css">
    <title>Registro de Jugador</title>
</head>

<body class="caja-general">
    <div class="caja_nav_regs_entrenador">
        <?php include('../layouts/nav.php') ?>
    </div>

    <div id="mensaje-registro-entrenador">
        <h2>Registro De Jugador</h2>
    </div>
    <div class="caja-form-regs-entrenador">
        <form action="../php/proceso_regJugador_admin.php" method="post">
            <div class="caja-text">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre_jugador_admin" required>
            </div>
            <div class="caja-compact">
                <div class="caja-text" id="caja-text-edad">
                    <label id="edad" for="edad">Edad</label>
                    <input type="number" id="edad" name="edad_jugador_admin" required>
                </div>

                <div class="caja-text">
                    <label id="contrasena_jugador" for="contrasena">Contraseña</label>
                    <input type="text" id="contrasena_jugador" name="contrasena_jugador_admin" required>
                </div>
            </div>
            <div class="caja-compact">
                <div class="caja-text">
                    <label for="posicion">Posición</label>
                    <input type="text" id="posicion" name="posicion_jugador_admin" required>
                </div>

                <div class="caja-text" >
                    <label for="cargo">Cargo:</label>
                    <input type="text" id="cargo" name="rol_jugador_admin" required value="Jugador" readonly>
                </div>

            </div>

            <div class="caja-text">
                <label for="correo">Correo:</label>
                <input type="text" id="correo_jugador" name="correo_jugador_admin" required>
            </div>

            <div class="btn-registrar">
                <button type="submit">Registrar</button>
            </div>
        </form>
    </div>
    <?php
   if (isset($_GET['error']) && $_GET['error'] == 1) {
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "El Jugador ya existe!!",
                });
            });
          </script>';
}

if (isset($_GET['error']) && $_GET['error'] == 2) {
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "success",
                    text: "Jugador Registrado Exitosamente!!",
                });
            });
          </script>';
}
if (isset($_GET['error']) && $_GET['error'] == 3) {
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    text: "Error al registrar el jugador",
                });
            });
          </script>';
}
    ?>
    <script src="../assets/js/script.js"></script>
    <script src="../assets/plugins/SweetAlert/dist/sweetalert2.all.min.js"></script>
</body>

</html>