<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/plugins/SweetAlert/dist/sweetalert2.min.css">
</head>

<body class="caja-general">
    <div class="caja-form-registrar-marcador">
        <h2>Registrar Marcador</h2>
        <form method="post" action="../php/proceso_formulario_marcador.php">
            <input type="hidden" name="id_partido" value="<?php echo $_GET['id_partido']; ?>">
            <label for="goles_equipo_local" style="margin-right: 20px;">Golles Equipo Local:</label>
            <input type="number" name="goles_equipo_local" style="width: 150px;" required>
            <br><br>
            <label for="goles_equipo_visitante">Goles Equipo Visitante:</label>
            <input type="number" name="goles_equipo_visitante" style="width: 150px;" required>
            <br><br>
            <button type="submit">Confirmar</button>
        </form>
    </div>

    <script src="../assets/js/script.js"></script>
    <script src="../assets/plugins/SweetAlert/dist/sweetalert2.all.min.js"></script>

    <script>
        // Esta función se llama al hacer clic en el botón "Confirmar"
        function cerrarModal(registroExitoso) {
    // Obtener la ventana modal
    var miModal = document.getElementById('miModal');
    var btnCerrarModal = document.getElementById('cerrarModalBtn');

    // Ocultar la ventana modal y el botón de cerrar
    miModal.style.display = 'none';
    btnCerrarModal.style.display = 'none';

    // Enviar una señal a la página principal solo si el registro fue exitoso
    if (registroExitoso) {
        console.log('Registro exitoso. Enviando señal de cierre.');
        window.parent.postMessage('modalClosed', '*');
    } else {
        console.log('Registro no exitoso. No se enviará la señal de cierre.');
    }
}

    </script>
</body>

</html>
