<?php
$conexion = mysqli_connect('127.0.0.1:3307', 'root', '', 'proyecto_compras');
if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
?>