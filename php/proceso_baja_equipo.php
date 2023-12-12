<?php
session_start();
require('../conn.php');
require('funciones.php'); // Asegúrate de que la ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se recibió el ID del equipo
    if (isset($_POST['equipo_id'])) {
        $equipo_id = $_POST['equipo_id'];

        // Realiza la conexión a la base de datos
        $conn = obtenerConexion();

        // Lógica para dar de baja al equipo
        darDeBajaEquipo($equipo_id, $conn);

        // Cierra la conexión a la base de datos
        mysqli_close($conn);

        // Redirige a la página de lista de equipos después de dar de baja
        header("Location: ../modelos/lista_entrenadores.php");
        exit();
    } else {
        // Si no se proporcionó el ID del equipo, redirige a alguna página de error o manejo adecuado

        exit();
    }
} else {
    // Si no es una solicitud POST, redirige a alguna página de error o manejo adecuado

    exit();
}
