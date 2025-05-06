<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo "Sesión no iniciada. Redirigiendo...";
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

    <?php include('menu.php'); ?> <!-- Menú reutilizable -->

    <!-- Contenido principal -->
    <div class="contenedor">
        <div class="titulo">
            <h1>Bienvenido, <?php echo htmlspecialchars($usuario_nombre); ?>!</h1>
            <h2 class="subtitulo">Gestiona tus productos</h2>
        </div>

        <!-- Buscador -->
        <div class="buscador-container">
            <input type="text" id="buscador" placeholder="Buscar productos...">
            <button onclick="filtrarProductos()">Buscar</button>
        </div>
        <div class="mensaje-no-encontrado" id="mensaje-no-encontrado">Producto no encontrado</div>

        <div class="productos-container" id="productos-container">
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
                    echo "<div class='producto-card' data-nombre='".strtolower($row['nombre'])."' data-descripcion='".strtolower($row['descripcion'])."'>";
                    echo "<img src='imagenes/" . $row['url_imagen'] . "' alt='" . $row['nombre'] . "'>";
                    echo "<div class='contenido-producto'>";
                        echo "<h3>" . $row['nombre'] . "</h3>";
                        echo "<p>" . $row['descripcion'] . "</p>";
                        echo "<p><strong>Precio:</strong> Q" . number_format($row['precio'], 2) . "</p>";
                        echo "<p><strong>Stock:</strong> " . $row['stock'] . "</p>";
                    echo "</div>";
                    echo "<form action='agregar_carrito.php' method='post'>
                            <input type='hidden' name='id_producto' value='" . $row['id_producto'] . "'>
                            <input type='number' name='cantidad' min='1' max='" . $row['stock'] . "' placeholder='Cantidad' required>
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

        <!-- Contenedor para la paginación -->
        <div id="paginacion" style="text-align: center; margin-top: 20px;"></div>
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

    <!-- Script de paginación y búsqueda -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const itemsPorPagina = 16;
            const contenedor = document.getElementById("productos-container");
            const items = contenedor.querySelectorAll(".producto-card");
            const paginacion = document.getElementById("paginacion");
            const buscador = document.getElementById("buscador");
            const mensajeNoEncontrado = document.getElementById("mensaje-no-encontrado");

            let paginaActual = 1;
            let productosFiltrados = Array.from(items);
            const botonesVisibles = 10;

            // Función para filtrar productos
            function filtrarProductos() {
                const termino = buscador.value.toLowerCase();
                productosFiltrados = Array.from(items).filter(item => {
                    const nombre = item.dataset.nombre;
                    const descripcion = item.dataset.descripcion;
                    return nombre.includes(termino) || descripcion.includes(termino);
                });

                mensajeNoEncontrado.style.display = productosFiltrados.length === 0 ? 'block' : 'none';
                mostrarPagina(1);
            }

            // Función para mostrar página
            function mostrarPagina(pagina) {
                paginaActual = pagina;
                const inicio = (pagina - 1) * itemsPorPagina;
                const fin = inicio + itemsPorPagina;

                items.forEach(item => item.style.display = 'none');
                productosFiltrados.slice(inicio, fin).forEach(item => item.style.display = 'block');

                renderizarPaginacion();
                window.scrollTo({ top: 0, behavior: "smooth" });
            }

            // Función para renderizar paginación
            function renderizarPaginacion() {
                const totalPaginas = Math.ceil(productosFiltrados.length / itemsPorPagina);
                paginacion.innerHTML = "";

                const crearBoton = (texto, clase, disabled, onClick) => {
                    const boton = document.createElement("button");
                    boton.textContent = texto;
                    boton.className = clase;
                    boton.disabled = disabled;
                    boton.addEventListener("click", onClick);
                    return boton;
                };

                paginacion.appendChild(crearBoton("◀", "paginacion-btn", paginaActual === 1, () => mostrarPagina(paginaActual - 1)));

                for (let i = 1; i <= totalPaginas; i++) {
                    paginacion.appendChild(crearBoton(i, `paginacion-btn${i === paginaActual ? " active" : ""}`, false, () => mostrarPagina(i)));
                }

                paginacion.appendChild(crearBoton("▶", "paginacion-btn", paginaActual === totalPaginas, () => mostrarPagina(paginaActual + 1)));
            }

            buscador.addEventListener("keyup", filtrarProductos);
            mostrarPagina(1);
        });
    </script>
</body>
</html>
