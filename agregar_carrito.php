<?php
session_start(); // Inicia la sesión
include('conexion_portal_compras.php');

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    die("<p style='color: red; font-weight: bold;'>Para poder generar un carrito, tiene que iniciar sesión.</p>
         <a href='iniciar_sesion_usuario.php' style='color: blue;'>Iniciar sesión</a>");
}

$id_usuario = $_SESSION['usuario_id']; // Recupera el ID del usuario desde la sesión
$id_producto = $_POST['id_producto'];
$cantidad = $_POST['cantidad'];

// Validar que $id_usuario sea válido
if (empty($id_usuario) || !is_numeric($id_usuario)) {
    die("<p>Error: ID del usuario no es válido.</p>");
}

// Validar que $id_producto y $cantidad sean válidos
if (empty($id_producto) || !is_numeric($id_producto) || empty($cantidad) || !is_numeric($cantidad)) {
    die("<p>Error: Datos del producto o cantidad no son válidos.</p>");
}

// Escapar los valores
$id_usuario = intval($id_usuario);
$id_producto = intval($id_producto);
$cantidad = intval($cantidad);

// Crear una orden si no existe
$query_orden = "SELECT id_orden FROM orden WHERE usuario_id_usuario = $id_usuario AND estado = 'pendiente'";
$result_orden = mysqli_query($conexion, $query_orden);

if (!$result_orden) {
    die("<p>Error en la consulta de orden: " . mysqli_error($conexion) . "</p>");
}

if (mysqli_num_rows($result_orden) == 0) {
    $query_crear_orden = "INSERT INTO orden (id_pago, total, fecha_orden, estado, usuario_id_usuario) 
                          VALUES (0, 0, NOW(), 'pendiente', $id_usuario)";
    if (mysqli_query($conexion, $query_crear_orden)) {
        $id_orden = mysqli_insert_id($conexion);
    } else {
        die("<p>Error al crear la orden: " . mysqli_error($conexion) . "</p>");
    }
} else {
    $row_orden = mysqli_fetch_assoc($result_orden);
    $id_orden = $row_orden['id_orden'];
}

// Obtener el precio del producto
$query = "SELECT precio, stock FROM producto WHERE id_producto = $id_producto";
$result = mysqli_query($conexion, $query);
if (!$result) {
    die("<p>Error en la consulta del producto: " . mysqli_error($conexion) . "</p>");
}

$row = mysqli_fetch_assoc($result);
$precio = $row['precio'];
$stock = $row['stock'];

// Validar que haya suficiente stock
if ($cantidad > $stock) {
    die("<p style='color: red;'>Error: No hay suficiente stock disponible.</p>
         <a href='productos.php' style='color: blue;'>Volver a productos</a>");
}

// Calcular el precio total
$precio_total = $precio * $cantidad;

// Insertar en detalle_orden
$query_detalle = "INSERT INTO detalle_orden (id_producto, cantidad, precio_total, orden_id_orden)
                  VALUES ($id_producto, $cantidad, $precio_total, $id_orden)";
if (mysqli_query($conexion, $query_detalle)) {
    $mensaje = "Producto agregado al carrito correctamente.";
} else {
    $mensaje = "Error al agregar el producto al carrito: " . mysqli_error($conexion);
}

mysqli_close($conexion);

// Después de agregar el producto al carrito
header("Location: ver_carrito.php?id_orden=$id_orden");
exit();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto al Carrito</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/productos.css">
</head>
<body>
    <?php include('menu.php'); ?>

    <div class="contenedor">
        <h1>Resultado de la operación</h1>
        <p><?php echo $mensaje; ?></p>
        <p>Producto: <?php echo htmlspecialchars($id_producto); ?></p>
        <p>Cantidad: <?php echo htmlspecialchars($cantidad); ?></p>
        <p>Precio total: <?php echo htmlspecialchars($precio_total); ?></p>
        <a href="productos.php">Volver a productos</a>
    </div>
</body>
</html>