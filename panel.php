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

        <!-- Contenedor para la paginación -->
        <div id="paginacion" style="text-align: center; margin-top: 20px;"></div>

        <script>
        document.addEventListener("DOMContentLoaded", () => {
            const itemsPorPagina = 16;
            const contenedor = document.getElementById("productos-container");
            const items = contenedor.querySelectorAll(".producto-card");
            const paginacion = document.getElementById("paginacion");

            let paginaActual = 1;
            const botonesVisibles = 10;

            // Función para mostrar página
            function mostrarPagina(pagina) {
                paginaActual = pagina;
                const inicio = (pagina - 1) * itemsPorPagina;
                const fin = inicio + itemsPorPagina;

                // Ocultar todos los productos primero
                items.forEach(item => {
                    item.style.display = 'none';
                });

                // Mostrar solo los productos de la página actual
                Array.from(items).slice(inicio, fin).forEach(item => {
                    item.style.display = 'block';
                });

                renderizarPaginacion();
                window.scrollTo({ top: 0, behavior: "smooth" });
            }

            // Función para renderizar paginación
            function renderizarPaginacion() {
                const totalPaginas = Math.ceil(items.length / itemsPorPagina);
                paginacion.innerHTML = "";

                // Botón Anterior
                const anterior = document.createElement("button");
                anterior.textContent = "◀";
                anterior.disabled = (paginaActual === 1);
                anterior.className = "paginacion-btn flecha";
                anterior.addEventListener("click", () => mostrarPagina(paginaActual - 1));
                paginacion.appendChild(anterior);

                // Calcular rango de botones a mostrar
                let inicioRango = Math.max(1, paginaActual - Math.floor(botonesVisibles / 2));
                let finRango = Math.min(totalPaginas, inicioRango + botonesVisibles - 1);

                if (finRango - inicioRango + 1 < botonesVisibles) {
                    inicioRango = Math.max(1, finRango - botonesVisibles + 1);
                }

                // Botón Primera Página
                if (inicioRango > 1) {
                    const primeraPagina = document.createElement("button");
                    primeraPagina.textContent = "1";
                    primeraPagina.className = "paginacion-btn";
                    primeraPagina.addEventListener("click", () => mostrarPagina(1));
                    paginacion.appendChild(primeraPagina);

                    if (inicioRango > 2) {
                        const puntosInicio = document.createElement("span");
                        puntosInicio.textContent = "...";
                        puntosInicio.style.margin = "0 5px";
                        paginacion.appendChild(puntosInicio);
                    }
                }

                // Botones numéricos
                for (let i = inicioRango; i <= finRango; i++) {
                    const boton = document.createElement("button");
                    boton.textContent = i;
                    boton.className = "paginacion-btn" + (i === paginaActual ? " active" : "");
                    boton.addEventListener("click", () => mostrarPagina(i));
                    paginacion.appendChild(boton);
                }

                // Botón Última Página
                if (finRango < totalPaginas) {
                    if (finRango < totalPaginas - 1) {
                        const puntosFin = document.createElement("span");
                        puntosFin.textContent = "...";
                        puntosFin.style.margin = "0 5px";
                        paginacion.appendChild(puntosFin);
                    }

                    const ultimaPagina = document.createElement("button");
                    ultimaPagina.textContent = totalPaginas;
                    ultimaPagina.className = "paginacion-btn";
                    ultimaPagina.addEventListener("click", () => mostrarPagina(totalPaginas));
                    paginacion.appendChild(ultimaPagina);
                }

                // Botón Siguiente
                const siguiente = document.createElement("button");
                siguiente.textContent = "▶";
                siguiente.disabled = (paginaActual === totalPaginas);
                siguiente.className = "paginacion-btn flecha";
                siguiente.addEventListener("click", () => mostrarPagina(paginaActual + 1));
                paginacion.appendChild(siguiente);
            }

            mostrarPagina(1); // Inicializar
        });
        </script>
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
