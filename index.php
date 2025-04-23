<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/productos.css">
    <title>Pagina Principal</title>
    <style>
        /* Estilos temporales para el buscador (luego los moverás a productos.css) */
        .buscador-container {
            margin: 20px auto;
            max-width: 500px;
            display: flex;
            gap: 10px;
        }
        #buscador {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .buscador-container button {
            padding: 10px 20px;
            background-color: #1c60b3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .buscador-container button:hover {
            background-color: #154b8a;
        }
        .mensaje-no-encontrado {
            text-align: center;
            font-size: 18px;
            color: #666;
            margin: 30px 0;
            display: none;
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
                    <li><a href="">Inicio</a></li>
                    <li><a href="iniciar_sesion_usuario.php">Iniciar sesion</a></li>
                    <li><a href="productos.php">Productos</a></li><li>
                        <a href="lista_producto.php">Carrito</a></li>
                    
                </ul>
            </div>
        </div>

        <div class="titulo">
            <h1>Bienvenido a la tienda en linea</h1>
            <h2 class="subtitulo">Gestiona tus productos</h2>
            
            <!-- BUSCADOR NUEVO -->
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
        </div>
    </div>

    <footer>
        <h3>Síguenos en nuestras redes sociales</h3>
        <div class="redes-sociales">
            <a href="https://www.facebook.com" target="_blank" title="Facebook">📘</a>
            <a href="https://www.twitter.com" target="_blank" title="Twitter">🐦</a>
            <a href="https://www.instagram.com" target="_blank" title="Instagram">📸</a>
            <a href="https://www.linkedin.com" target="_blank" title="LinkedIn">💼</a>
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
    let productosFiltrados = Array.from(items); // Copia de todos los productos
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
        
        // Ocultar todos los productos primero
        items.forEach(item => {
            item.style.display = 'none';
        });
        
        // Mostrar solo los productos de la página actual (del conjunto filtrado)
        productosFiltrados.slice(inicio, fin).forEach(item => {
            item.style.display = 'block';
        });
        
        renderizarPaginacion();
        window.scrollTo({ top: 0, behavior: "smooth" });
    }

    // Función para renderizar paginación
    function renderizarPaginacion() {
        const totalPaginas = Math.ceil(productosFiltrados.length / itemsPorPagina);
        paginacion.innerHTML = "";
        
        // Botón Anterior
        const anterior = document.createElement("button");
        anterior.textContent = "◀";
        anterior.disabled = (paginaActual === 1);
        anterior.className = "paginacion-btn";
        anterior.addEventListener("click", () => mostrarPagina(paginaActual - 1));
        paginacion.appendChild(anterior);

        // Calcular rango de botones a mostrar
        let inicioRango = Math.max(1, paginaActual - Math.floor(botonesVisibles/2));
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
        siguiente.className = "paginacion-btn";
        siguiente.addEventListener("click", () => mostrarPagina(paginaActual + 1));
        paginacion.appendChild(siguiente);
    }

    // Eventos
    buscador.addEventListener("keyup", filtrarProductos);
    mostrarPagina(1); // Inicializar
});
    </script>
</body>
</html>