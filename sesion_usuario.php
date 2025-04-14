<?php
include('conexion_portal_compras.php');

// Recibir los datos del formulario
$email = trim($_POST['email']); // Eliminar espacios adicionales
$contrasena = trim($_POST['contrasena']); // Eliminar espacios adicionales

// Evitar inyección SQL usando consultas preparadas
$stmt = $conexion->prepare("SELECT * FROM usuario WHERE email = ?");
$stmt->bind_param("s", $email); // "s" es el tipo de dato para cadenas (string)
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si el usuario existe
if ($resultado->num_rows > 0) {
    // El usuario existe, ahora verificar la contraseña
    $usuario = $resultado->fetch_assoc();

    // Comparar la contraseña proporcionada con la almacenada (sin cifrado)
    if ($contrasena === $usuario['contrasena']) {
        // Si las contraseñas coinciden, iniciar sesión
        session_start();
        $_SESSION['usuario_id'] = $usuario['id_usuario'];

        // Redirigir a panel.php
        $stmt->close(); // Cerrar la conexión antes de redirigir
        header("Location: panel.php");
        exit();
    } else {
        // Contraseña incorrecta, redirigir a error_sesion.php
        $stmt->close(); // Cerrar la conexión antes de redirigir
        header("Location: error_sesion.php?error=true");
        exit();
    }
} else {
    // Si el correo no existe, redirigir a error_sesion.php
    $stmt->close(); // Cerrar la conexión antes de redirigir
    header("Location: error_sesion.php?error=true");
    exit();
}
?>
