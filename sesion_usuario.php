<?php
include('conexion_portal_compras.php');

// Recibir los datos del formulario
$email = trim($_POST['email']);
$contrasena = trim($_POST['contrasena']);

// Consulta preparada para evitar inyección SQL
$stmt = $conexion->prepare("SELECT * FROM usuario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    // Verificar contraseña usando password_verify
    if (password_verify($contrasena, $usuario['contrasena'])) {
        session_start();
        $_SESSION['usuario_id'] = $usuario['id_usuario'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];

        $stmt->close();
        header("Location: panel.php");
        exit();
    } else {
        $stmt->close();
        header("Location: error_sesion.php?error=true");
        exit();
    }
} else {
    $stmt->close();
    header("Location: error_sesion.php?error=true");
    exit();
}
?>
