<?php
include('conexion_portal_compras.php');

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si se recibió el ID de la orden
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_orden']) && is_numeric($_POST['id_orden'])) {
    $id_orden = intval($_POST['id_orden']); // Convertir a entero

    // Actualizar el estado de la orden a "finalizada"
    $sql = "UPDATE orden SET estado = 'finalizada' WHERE id_orden = $id_orden";
    if (mysqli_query($conexion, $sql)) {
        // Redirigir con un mensaje de éxito
        header("Location: panel.php?mensaje=Orden finalizada correctamente");
        exit();
    } else {
        // Mostrar un mensaje de error si la consulta falla
        echo "<p>Error al finalizar la orden: " . mysqli_error($conexion) . "</p>";
    }
} else {
    // Si no se recibe un ID válido, redirigir con un mensaje de error
    header("Location: panel.php?mensaje=Error: No se pudo finalizar la orden");
    exit();
}

// Cerrar la conexión
mysqli_close($conexion);
?>