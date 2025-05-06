<?php
include('conexion_portal_compras.php');

$email = trim($_POST['email']);
$contrasena = trim($_POST['contrasena']);

// Preparar la consulta para evitar inyecciones SQL
$stmt = $conexion->prepare("SELECT * FROM usuario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado && $resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    // Comparar la contraseña usando password_verify (si las contraseñas están hasheadas)
    if ($contrasena === $usuario['contrasena']) { // Cambiar a password_verify si usas hashes
        session_start();
        $_SESSION['usuario_id'] = $usuario['id_usuario']; // Consistencia en el nombre
        $_SESSION['usuario_nombre'] = $usuario['nombre']; // Guardar el nombre del usuario en la sesión

        $stmt->close();
        header("Location: panel.php"); // Redirigir al panel del usuario
        exit();
    } else {
        $stmt->close();
        header("Location: iniciar_sesion_usuario.php?error=credenciales_invalidas"); // Redirigir con mensaje de error
        exit();
    }
} else {
    $stmt->close();
    header("Location: iniciar_sesion_usuario.php?error=credenciales_invalidas"); // Redirigir con mensaje de error
    exit();
}
?>
