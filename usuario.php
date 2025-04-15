<?php
include('conexion_portal_compras.php');

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$email = $_POST['email'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Cifrar la contraseña

$sql = "INSERT INTO usuario (nombre, apellido, telefono, direccion, email, contrasena, fecha_registro) 
        VALUES ('$nombre', '$apellido', '$telefono', '$direccion', '$email', '$contrasena', NOW())";

$validacion = mysqli_query($conexion, $sql);

if ($validacion) {
    header('location:registro_usuario.php');
} else {
    echo "Algo ha salido mal: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>
