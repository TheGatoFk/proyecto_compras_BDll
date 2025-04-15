<?php
include('conexion_portal_compras.php');

$email = trim($_POST['email']);
$contrasena = trim($_POST['contrasena']);

$stmt = $conexion->prepare("SELECT * FROM usuario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado && $resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    // Comparación directa sin password_verify
    if ($contrasena === $usuario['contrasena']) {
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
