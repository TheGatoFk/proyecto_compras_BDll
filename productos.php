<!-- filepath: c:\xampp\htdocs\proyecto_compras\productos.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="css/index.css"> <!-- Vincula el archivo CSS -->
    <style>
        .productos-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .producto-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .producto-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .producto-card h3 {
            margin: 10px 0;
        }
        .producto-card p {
            margin: 5px 0;
            color: #555;
        }
        .producto-card button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .producto-card button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="Contenedor">
        <!-- Barra superior (Logo + Menú) -->
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
            <h1>Lista de Productos</h1>
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

    <!-- Footer -->
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