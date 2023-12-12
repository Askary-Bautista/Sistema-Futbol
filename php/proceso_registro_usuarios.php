<?php
require('../php/funciones.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si el campo de nombre de usuario fue enviado
    if (isset($_POST['nombre_usuario'])) {
        $nombre_usuario = $_POST['nombre_usuario'];
        $contrasena_usuario = $_POST['contrasena_usuario'];
        $correo_usuario = $_POST['correo_usuario'];
        

        // Realizar la conexión a la base de datos
        $conn = obtenerConexion();

        // Verificar la conexión
        if ($conn === false) {
            die("Error en la conexión a la base de datos: " . mysqli_connect_error());
        }

        // Consulta para registrar un nuevo usuario
        $query = "INSERT INTO usuarios (nombre_usuario,contrasena,correo) VALUES (?,?,?)";

        // Preparar la consulta
        $stmt = mysqli_prepare($conn, $query);

        // Verificar si la preparación fue exitosa
        if ($stmt) {
            // Vincular el parámetro
            mysqli_stmt_bind_param($stmt, "sss", $nombre_usuario,$contrasena_usuario,$correo_usuario);

            // Ejecutar la consulta
            if (mysqli_stmt_execute($stmt)) {
                // Éxito al registrar el usuario
                header("location:../modulos/registro_entrenador.php?error=2");
            } else {
                // Error al ejecutar la consulta
                echo "Error al ejecutar la consulta: " . mysqli_stmt_error($stmt);
            }

            // Cerrar la consulta
            mysqli_stmt_close($stmt);
        } else {
            // Error en la preparación de la consulta
            echo "Error en la preparación de la consulta: " . mysqli_error($conn);
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($conn);
    } else {
        // Campo de nombre de usuario no presente
        echo "Campo de nombre de usuario no presente";
    }
} else {
    // Método de solicitud no es POST
    echo "Solicitud no válida";
}
?>