<?php
include('conexion_portal_compras.php');

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$email = $_POST['email'];
$contrasena = $_POST['contrasena'];

$peticion = "INSERT INTO usuario (nombre, apellido, telefono, direccion, email, contrasena) 
VALUE ('$nombre', '$apellido', '$telefono', '$direccion','$email', '$contrasena')";

$validacion = mysqli_query($conexion, $peticion);

if($validacion) {
    header('location:registro_usuario.php');
} else {
    echo "Algo a salido mal";
}

?>
