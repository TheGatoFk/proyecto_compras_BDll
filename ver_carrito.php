<?php
include('conexion_portal_compras.php');

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/productos.css">
    <style>
        .carrito-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .carrito-table th, .carrito-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .carrito-table th {
            background-color: #f4f4f4;
        }
        .carrito-table img {
            width: 100px;
            height: auto;
        }
        .carrito-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .carrito-actions button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        .carrito-actions button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php include('menu.php'); ?>

    <div class="contenedor">
        <?php
        echo "<h1>Carrito de Compras</h1>";

        // Validar que el ID de la orden sea válido
        if (!isset($_GET['id_orden']) || !is_numeric($_GET['id_orden'])) {
            die("<p>Error: No se encontró el carrito solicitado. Por favor, verifica el enlace.</p>");
        }

        $id_orden = intval($_GET['id_orden']); // Convertir a entero

        // Consulta SQL para obtener los productos del carrito
        $query = "SELECT p.nombre, p.descripcion, p.precio, d.cantidad, d.precio_total, i.url_imagen, d.id_detalle_orden
                  FROM detalle_orden d
                  JOIN producto p ON d.id_producto = p.id_producto
                  LEFT JOIN imagen_producto i ON p.id_producto = i.producto_id_producto AND i.principal = 'S'
                  WHERE d.orden_id_orden = $id_orden";

        $result = mysqli_query($conexion, $query);

        if (!$result) {
            die("<p>Error en la consulta: " . mysqli_error($conexion) . "</p>");
        }

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='carrito-table'>
                    <tr>
                        <th>Imagen</th>
                        <th>Producto</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Precio Total</th>
                        <th>Acciones</th>
                    </tr>";

            // Dentro del bucle while, ajusta los precios con number_format()
            while ($row = mysqli_fetch_assoc($result)) {
                // Ruta de la imagen
                $url_imagen = !empty($row['url_imagen']) ? 'imagenes/' . htmlspecialchars($row['url_imagen']) : 'imagenes/imagen_por_defecto.jpg';
                $nombre = htmlspecialchars($row['nombre'] ?? 'Sin nombre');
                $descripcion = htmlspecialchars($row['descripcion'] ?? 'Sin descripción');
                $precio = number_format($row['precio'] ?? 0, 2); // Redondear a 2 decimales
                $cantidad = htmlspecialchars($row['cantidad'] ?? '0');
                $precio_total = number_format($row['precio_total'] ?? 0, 2); // Redondear a 2 decimales
                $id_detalle_orden = htmlspecialchars($row['id_detalle_orden'] ?? '');

                echo "<tr>
                        <td><img src='$url_imagen' alt='$nombre'></td>
                        <td>$nombre</td>
                        <td>$descripcion</td>
                        <td>Q$precio</td>
                        <td>$cantidad</td>
                        <td>Q$precio_total</td>
                        <td>
                            <form action='eliminar_producto.php' method='post' style='display:inline;'>
                                <input type='hidden' name='id_detalle_orden' value='" . htmlspecialchars($id_detalle_orden) . "'>
                                <input type='hidden' name='id_orden' value='" . htmlspecialchars($id_orden) . "'>
                                <button type='submit' style='background-color: #dc3545; color: white;'>Eliminar</button>
                            </form>
                            <form action='panel.php' method='get' style='display:inline;'>
                                <button type='submit' style='background-color: #007bff; color: white;'>+</button>
                            </form>
                        </td>
                      </tr>";
            }

            echo "</table>";

            echo "<div class='carrito-actions'>
                    <form action='finalizar_compra.php' method='post' style='display:inline;'>
                        <input type='hidden' name='id_orden' value='" . htmlspecialchars($id_orden) . "'>
                        <button type='submit' style='background-color: #28a745; color: white;'>Finalizar Compra</button>
                    </form>
                    <form action='eliminar_carrito.php' method='post' style='display:inline;'>
                        <input type='hidden' name='id_orden' value='" . htmlspecialchars($id_orden) . "'>
                        <button type='submit' style='background-color: #dc3545; color: white;'>Eliminar Carrito</button>
                    </form>
                  </div>";
        } else {
            echo "<p>Tu carrito está vacío.</p>";
        }

        mysqli_close($conexion);
        ?>
    </div>
</body>
</html>