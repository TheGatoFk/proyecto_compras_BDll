<?php
include '../conexion_portal_compras.php'; // Ruta ajustada para la conexión

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consulta para obtener los productos de la categoría 11
$query = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.stock, i.url_imagen 
          FROM producto p
          LEFT JOIN imagen_producto i ON p.id_producto = i.producto_id_producto
          WHERE p.id_producto IN (105,106,107,108,109,110,111,112,113,114)";
$result = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/productos.css"> <!-- Ruta ajustada para los estilos -->
    <link rel="stylesheet" href="../css/index.css"> <!-- Ruta ajustada para los estilos -->
    <title>Gaming</title>
</head>
<body>
    <div class="Contenedor">
        <div class="top-bar">
            <div class="logo">
                <h2>DataShop</h2>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="../iniciar_sesion_usuario.php">Iniciar sesión</a></li>
                    <li><a href="../lista_producto.php">Carrito</a></li>
                    <li><a href="../productos.php">Productos</a></li>
                </ul>
            </div>
        </div>

        <div class="titulo">
            <h1>Productos en la categoría: Gaming</h1>
            <h2 style="text-align: center;">Productos para videojuegos</h2>
        </div>

        <div class="productos-container">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="producto-card">
                        <img src="../imagenes/<?php echo htmlspecialchars($row['url_imagen']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>">
                        <h3><?php echo htmlspecialchars($row['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
                        <p><strong>Precio:</strong> Q<?php echo number_format($row['precio'], 2); ?></p>
                        <p><strong>Stock:</strong> <?php echo $row['stock']; ?></p>
                        <form action="../carrito.php" method="post">
                            <input type="hidden" name="id_producto" value="<?php echo $row['id_producto']; ?>">
                            <button type="submit">Agregar al carrito</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay productos disponibles en esta categoría.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>