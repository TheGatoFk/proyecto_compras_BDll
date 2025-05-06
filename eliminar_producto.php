<?php
include('conexion_portal_compras.php');

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si se recibió el ID del detalle de la orden y el ID de la orden
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_detalle_orden'], $_POST['id_orden']) && is_numeric($_POST['id_detalle_orden']) && is_numeric($_POST['id_orden'])) {
    $id_detalle_orden = intval($_POST['id_detalle_orden']); // Convertir a entero
    $id_orden = intval($_POST['id_orden']); // Convertir a entero

    // Eliminar el producto del carrito
    $sql = "DELETE FROM detalle_orden WHERE id_detalle_orden = $id_detalle_orden";
    if (mysqli_query($conexion, $sql)) {
        // Redirigir de vuelta al carrito con un mensaje de éxito
        header("Location: ver_carrito.php?id_orden=$id_orden&mensaje=Producto eliminado correctamente");
        exit();
    } else {
        // Mostrar un mensaje de error si la consulta falla
        echo "<p>Error al eliminar el producto: " . mysqli_error($conexion) . "</p>";
    }
} else {
    // Si no se recibe un ID válido, redirigir al carrito con un mensaje de error
    header("Location: ver_carrito.php?mensaje=Error: Producto no válido");
    exit();
}

// Cerrar la conexión
mysqli_close($conexion);
?>

