<?php
include('conexion_portal_compras.php');

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$contrasena = $_POST['contrasena'];

$peticion = "INSERT INTO usuario (nombre, apellido, email, telefono, direccion, contraseña) 
VALUE ('$nombre', '$apellido', '$email', '$telefono', '$direccion', '$contrasena')";

$validacion = mysqli_query($conexion, $peticion);

if($validacion) {
    header('location:registro_usuario.php');
} else {
    echo "Algo a salido mal";
}

?>