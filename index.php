<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="css/productos.css"> <!-- Vincula el archivo CSS de productos -->
    <title>Pagina Principal</title>
</head>

<body>
    <div class="Contenedor">
        <!-- Barra superior (Logo + Menú) -->
        <div class="top-bar">
            <!-- Logo -->
            <div class="logo">
                <h2>DataShop</h2>
            </div>
            <!-- Menú -->
            <div class="menu">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="iniciar_sesion_usuario.php">Iniciar sesión</a></li>
                    <li><a href="lista_producto.php">Carrito</a></li>
                    <li class="menu-item">
                        <a href="#">Productos por categorías</a>
                        <ul class="menu-categorias-vertical">
                            <li><a href="categorias/electrodomesticos.php">Electrodomésticos</a></li>
                            <li><a href="categorias/computacion.php">Computación</a></li>
                            <li><a href="categorias/muebles.php">Muebles</a></li>
                            <li><a href="categorias/salud.php">Salud</a></li>
                            <li><a href="categorias/cocina.php">Cocina</a></li>
                            <li><a href="categorias/bebes.php">Bebés</a></li>
                            <li><a href="categorias/deportes.php">Deportes</a></li>
                            <li><a href="productos.php">Otros</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <div class="titulo">
            <h1>Bienvenido a la tienda en linea</h1>
            <h2 class="subtitulo">Gestiona tus productos</h2>
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
                                    echo "<p><strong>Precio:</strong> Q" .number_format($row['precio'], 2) . "</p>";
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
    </div>
    
    <!-- Footer colocado fuera del Contenedor para que esté al final de la página -->
    <footer>
        <h3>Síguenos en nuestras redes sociales</h3>
        <div class="redes-sociales">
            <a href="https://www.facebook.com" target="_blank" title="Facebook">📘</a>
            <a href="https://www.twitter.com" target="_blank" title="Twitter">🐦</a>
            <a href="https://www.instagram.com" target="_blank" title="Instagram">📸</a>
            <a href="https://www.linkedin.com" target="_blank" title="LinkedIn">💼</a>
        </div>
    </footer>

</body>

</html>
