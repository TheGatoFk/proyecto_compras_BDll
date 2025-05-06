<?php
include('conexion_portal_compras.php');

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si se recibió el ID de la orden
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_orden']) && is_numeric($_POST['id_orden'])) {
    $id_orden = intval($_POST['id_orden']); // Convertir a entero

    // Eliminar los productos asociados a la orden
    $sql_detalle = "DELETE FROM detalle_orden WHERE orden_id_orden = $id_orden";
    if (mysqli_query($conexion, $sql_detalle)) {
        // Eliminar la orden
        $sql_orden = "DELETE FROM orden WHERE id_orden = $id_orden";
        if (mysqli_query($conexion, $sql_orden)) {
            // Redirigir con un mensaje de éxito a panel.php
            header("Location: panel.php?mensaje=Carrito eliminado correctamente");
            exit();
        } else {
            echo "<p>Error al eliminar la orden: " . mysqli_error($conexion) . "</p>";
        }
    } else {
        echo "<p>Error al eliminar los productos del carrito: " . mysqli_error($conexion) . "</p>";
    }
} else {
    // Si no se recibe un ID válido, redirigir a panel.php con un mensaje de error
    header("Location: panel.php?mensaje=Error: No se pudo eliminar el carrito");
    exit();
}

// Cerrar la conexión
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Producto del Carrito</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/productos.css">
</head>
<body>
    <?php include('menu.php'); ?>

    <div class="contenedor">
    </div>
</body>
</html>