<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="./assets/plugins/SweetAlert/dist/sweetalert2.min.css">
    <title>Registro de Usuario</title>
</head>

<body class="caja-general">
    <div class="caja_nav_regs_entrenador">
        <?php include('../layouts/nav.php') ?>
    </div>


    <div id="mensaje-registro-entrenador">
        <h2>Registro De Entrenador</h2>
    </div>
    <div class="caja-form-regs-entrenador">
        <form action="../php/proceso_registro_usuarios.php" method="post">
            <div class="caja-text">
                <label for="nombre_usuario">Nombre de Usuario:</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" required>
            </div>

            <div class="caja-text">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena_usuario" name="contrasena_usuario" required>
            </div>

            <div class="caja-text">
                <label for="contrasena">Correo:</label>
                <input type="text" id="correo_usuario" name="correo_usuario" required>
            </div>

            <div class="caja-text">
                <label for="cargo">Cargo:</label>
                <input type="text" id="cargo" name="rol" required value="Entrenador" readonly>
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
                        icon: "success",
                        text: "Entrenador Registrado Exitosamente!!",
                    });
                });
              </script>';
    }
    ?>
    <script src="../assets/js/script.js"></script>
    <script src="../assets/plugins/SweetAlert/dist/sweetalert2.all.min.js"></script>
</body>

</html>