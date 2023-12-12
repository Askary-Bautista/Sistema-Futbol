<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Registro de Usuario</title>
</head>

<body class="caja-general">
    <div class="caja_nav_regs_entrenador">
        <?php include('../layouts/nav_Entrenador.php') ?>
    </div>


    <div id="mensaje-registro-entrenador">
        <h2>Registro De Equipo</h2>
    </div>
    <div class="caja-form-regs-entrenador">
        <form action="../php/proceso_registro_equipo.php" method="post" enctype="multipart/form-data">
            <div class="caja-text">
                <label for="nombre_equipo">Nombre del Equipo:</label>
                <input type="text" id="nombre_equipo" name="nombre_equipo" required>
            </div>

            <div class="caja-text" id="caja-text-input">
                <label for="logo">Logo del Equipo:</label>
                <input type="file" id="logo_input" name="logo_equipo" required>
            </div>

            <div class="btn-registrar">
                <button type="submit">Registrar</button>
            </div>

        </form>
    </div>


    <script src="../assets/js/script.js"></script>
</body>

</html>