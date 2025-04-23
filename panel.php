<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: iniciar_sesion_usuario.php");
    exit();
}

// Obtener el nombre del usuario desde la sesión
$usuario_nombre = $_SESSION['usuario_nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi cuenta - DataShop</title>
    <link rel="stylesheet" href="css/panel.css">
    <link rel="stylesheet" href="css/productos.css"> <!-- Vincula el CSS de productos -->
</head>
<body>

    <!-- Barra superior -->
    <div class="top-bar">
        <div class="logo">
            <h2>DataShop</h2>
        </div>
        <div class="menu">
            <ul>
                <li><a href="panel.php">Inicio</a></li>
                <li><a href="mi_cuenta.php">Mi cuenta</a></li>
                <li><a href="panel.php">Carrito</a></li>
                <li><a href="productos_panel.php">Productos</a></li>
            </ul>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="contenedor">
        <div class="titulo">
            <h1>Bienvenido, <?php echo htmlspecialchars($usuario_nombre); ?>!</h1>
            <h2 class="subtitulo">Gestiona tus productos</h2>
        </div>

        <div class="productos-container">
            <?php
            include 'conexion_portal_compras.php';
            if (!$conexion) {
                die("Conexión fallida: " . mysqli_connect_error());
            }

            // Consulta para obtener productos y sus imágenes
            $query = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.stock, i.url_imagen 
                      FROM producto p
                      LEFT JOIN imagen_producto i ON p.id_producto = i.producto_id_producto";
            $result = mysqli_query($conexion, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='producto-card'>";
                    echo "<img src='imagenes/" . $row['url_imagen'] . "' alt='" . $row['nombre'] . "'>";
                    echo "<h3>" . $row['nombre'] . "</h3>";
                    echo "<p>" . $row['descripcion'] . "</p>";
                    echo "<p><strong>Precio:</strong> Q" . number_format($row['precio'], 2) . "</p>";
                    echo "<p><strong>Stock:</strong> " . $row['stock'] . "</p>";
                    echo "<form action='carrito.php' method='post'>
                            <input type='hidden' name='id_producto' value='" . $row['id_producto'] . "'>
                            <button type='submit'>Agregar al carrito</button>
                          </form>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay productos disponibles</p>";
            }

            mysqli_close($conexion);
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>Síguenos en nuestras redes sociales:</p>
        <div class="redes-sociales">
            <a href="https://www.facebook.com" target="_blank">Facebook</a>
            <a href="https://www.twitter.com" target="_blank">Twitter</a>
            <a href="https://www.instagram.com" target="_blank">Instagram</a>
            <a href="https://www.linkedin.com" target="_blank">LinkedIn</a>
        </div>
    </footer>
</body>
</html>
