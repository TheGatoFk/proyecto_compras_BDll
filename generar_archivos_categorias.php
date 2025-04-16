<?php
include 'conexion_portal_compras.php';

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consulta para obtener las categorías
$query = "SELECT id_categoria, nombre, descripcion, producto_id_producto FROM categoria";
$result = mysqli_query($conexion, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id_categoria = $row['id_categoria'];
        $nombre_categoria = $row['nombre'];
        $descripcion_categoria = $row['descripcion'];
        $producto_id_producto = $row['producto_id_producto'];

        // Convertir el nombre de la categoría en un formato adecuado para un archivo
        $nombre_archivo = strtolower(str_replace(' ', '_', preg_replace('/[^A-Za-z0-9 ]/', '', $nombre_categoria))) . ".php";

        // Crear el contenido del archivo PHP
        $contenido = <<<PHP
<?php
include 'conexion_portal_compras.php';

if (!\$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Consulta para obtener los productos de la categoría $id_categoria
\$query = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.stock, i.url_imagen 
          FROM producto p
          LEFT JOIN imagen_producto i ON p.id_producto = i.producto_id_producto
          WHERE p.id_producto = $producto_id_producto";
\$result = mysqli_query(\$conexion, \$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/productos.css"> <!-- Estilos de productos -->
    <link rel="stylesheet" href="css/index.css"> <!-- Estilos generales -->
    <title>$nombre_categoria</title>
</head>
<body>
    <div class="Contenedor">
        <div class="top-bar">
            <div class="logo">
                <h2>DataShop</h2>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="iniciar_sesion_usuario.php">Iniciar sesión</a></li>
                    <li><a href="lista_producto.php">Carrito</a></li>
                    <li><a href="productos.php">Productos</a></li>
                </ul>
            </div>
        </div>

        <div class="titulo">
            <h1>Productos en la categoría: $nombre_categoria</h1>
            <h2 style="text-align: center;">$descripcion_categoria</h2>
        </div>

        <div class="productos-container">
            <?php if (mysqli_num_rows(\$result) > 0): ?>
                <?php while (\$row = mysqli_fetch_assoc(\$result)): ?>
                    <div class="producto-card">
                        <img src="imagenes/<?php echo htmlspecialchars(\$row['url_imagen']); ?>" alt="<?php echo htmlspecialchars(\$row['nombre']); ?>">
                        <h3><?php echo htmlspecialchars(\$row['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars(\$row['descripcion']); ?></p>
                        <p><strong>Precio:</strong> Q<?php echo number_format(\$row['precio'], 2); ?></p>
                        <p><strong>Stock:</strong> <?php echo \$row['stock']; ?></p>
                        <form action="carrito.php" method="post">
                            <input type="hidden" name="id_producto" value="<?php echo \$row['id_producto']; ?>">
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
PHP;

        // Crear el archivo PHP
        file_put_contents($nombre_archivo, $contenido);
        echo "Archivo creado: $nombre_archivo<br>";
    }
} else {
    echo "No se encontraron categorías.";
}

mysqli_close($conexion);
?>