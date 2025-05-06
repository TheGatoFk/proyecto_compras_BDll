<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar por Categorías</title>
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="css/productos.css"> <!-- Vincula el archivo CSS de productos -->
</head>
<body>
    <?php include('menu.php'); ?> <!-- Menú reutilizable -->

    <div class="contenedor">
        <div class="titulo">
            <h1>Buscar por Categorías</h1>
        </div>

        <div class="categorias-container">
            <?php
            include 'conexion_portal_compras.php';
            if (!$conexion) {
                die("Conexión fallida: " . mysqli_connect_error());
            }

            // Función para eliminar tildes de los nombres
            function eliminar_tildes($cadena) {
                $buscar = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'];
                $reemplazar = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'];
                return str_replace($buscar, $reemplazar, $cadena);
            }

            // Consulta para obtener categorías y sus imágenes principales
            $query = "SELECT c.id_categoria, c.nombre, c.descripcion, i.url_imagen 
                      FROM categoria c
                      LEFT JOIN imagen_categoria i ON c.id_categoria = i.categoria_id_categoria
                      WHERE i.principal = 1"; // Solo selecciona las imágenes principales
            $result = mysqli_query($conexion, $query);

            if (mysqli_num_rows($result) > 0) {
                echo "<div class='categorias-list'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='categoria-item'>";
                    // Mostrar la imagen principal de la categoría
                    if (!empty($row['url_imagen'])) {
                        echo "<img src='" . $row['url_imagen'] . "' alt='" . $row['nombre'] . "'>";
                    } else {
                        // Imagen por defecto si no hay imagen principal
                        echo "<img src='imagenes/categorias/default.jpg' alt='Imagen no disponible'>";
                    }
                    echo "<h3>" . $row['nombre'] . "</h3>";
                    echo "<p>" . $row['descripcion'] . "</p>";
                    // Generar el enlace eliminando tildes y reemplazando espacios por guiones bajos
                    $nombre_sanitizado = strtolower(str_replace(' ', '_', eliminar_tildes($row['nombre'])));
                    echo "<a href='categorias_panel/" . $nombre_sanitizado . ".php' class='btn-categoria'>Ir a la categoría</a>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>No hay categorías disponibles</p>";
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
