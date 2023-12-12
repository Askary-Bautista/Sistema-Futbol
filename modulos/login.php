<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="./assets/plugins/SweetAlert/dist/sweetalert2.min.css">
    <title>Iniciar Sesión</title>
</head>



<body class="caja-general">
    <div class="caja_nav_regs_entrenador">
        <?php include('../layouts/nav.php') ?>
        
    </div>

    <div id="mensaje-registro-entrenador">
        <h2>Iniciar Sesión</h2>
    </div>

    <div class="caja-form-regs-entrenador">
        <div class="opciones-form">
            <button id="btnEntrenador">Entrenador</button>
            <button id="btnJugador">Jugador</button>
        </div>

        <div class="caja_form_entrenador" id="caja_form_entrenador">
            <div class="titulo-form">
                <h5>Entrenador</h5>
            </div>


            <form id="loginFormEntrenador" action="../php/proceso_login.php" method="post">
                <div class="caja-text">
                    <label for="usernameEntrenador">Nombre de Entrenador:</label>
                    <input type="text" id="usernameEntrenador" name="username_entrenador" required>
                </div>

                <div class="caja-text">
                    <label for="passwordEntrenador">Contraseña de Entrenador:</label>
                    <input type="password" id="passwordEntrenador" name="password_entrenador" required>
                </div>

                <div class="btn-registrar">
                    <button type="submit">Iniciar Sesión</button>
                </div>
            </form>

        </div>

        <div class="caja_form_jugador" id="caja_form_jugador" style="display: none;">
            <div class="titulo-form">
                <h5>Jugador</h5>
            </div>
            <form id="loginFormJugador" action="../php/proceso_login.php" method="post">

                <div class="caja-text">
                    <label for="usernameJugador">Nombre de Jugador:</label>
                    <input type="text" id="usernameJugador" name="username_jugador" required>
                </div>

                <div class="caja-text">
                    <label for="passwordJugador">Contraseña de Jugador:</label>
                    <input type="password" id="passwordJugador" name="password_jugador" required>
                </div>

                <div class="btn-registrar">
                    <button type="submit">Iniciar Sesión</button>
                </div>

            </form>
        </div>
    </div>

    <?php
    if (isset($_GET['error']) && $_GET['error'] == 1) {
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Usuario o contraseña incorrectos",
                });
            });
          </script>';
    }
    ?>
    <script src="../assets/plugins/SweetAlert/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let cajaFormEntrenador = document.getElementById("caja_form_entrenador");
            let cajaFormJugador = document.getElementById("caja_form_jugador");
            let btnEntrenador = document.getElementById("btnEntrenador");
            let btnJugador = document.getElementById("btnJugador");

            btnEntrenador.addEventListener("click", function() {
                cajaFormEntrenador.style.display = "block";
                cajaFormJugador.style.display = "none";
                btnEntrenador.classList.add("btnEntrenadorSelect");
                btnJugador.classList.remove("btnJugadorSelect");
            });

            btnJugador.addEventListener("click", function() {
                cajaFormEntrenador.style.display = "none";
                cajaFormJugador.style.display = "block";
                btnJugador.classList.add("btnJugadorSelect");
                btnEntrenador.classList.remove("btnEntrenadorSelect");
            });

        });
    </script>
</body>

</html>