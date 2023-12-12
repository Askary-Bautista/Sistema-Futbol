<?php
// Crear conexión
$conn = mysqli_connect("localhost", "root", "", "liga_futbol");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}else{
 //echo 'Conectado a la base de datos';
}
?>
