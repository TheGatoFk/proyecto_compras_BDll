<div class="top-bar">
    <!-- Logo -->
    <div class="logo">
        <h2>DataShop</h2>
    </div>
    <!-- Menú -->
    <div class="menu">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <?php
            // Iniciar sesión si no está iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Verificar si el usuario está autenticado
            if (isset($_SESSION['usuario_id'])) {
                include('conexion_portal_compras.php');

                $id_usuario = $_SESSION['usuario_id'];
                $query_orden = "SELECT id_orden FROM orden WHERE usuario_id_usuario = $id_usuario AND estado = 'pendiente'";
                $result_orden = mysqli_query($conexion, $query_orden);

                if ($result_orden && mysqli_num_rows($result_orden) > 0) {
                    $row_orden = mysqli_fetch_assoc($result_orden);
                    $id_orden = $row_orden['id_orden'];
                    echo "<li><a href='ver_carrito.php?id_orden=$id_orden'>Carrito</a></li>";
                } else {
                    echo "<li><a href='#'>Carrito (Vacío)</a></li>";
                }

                // Mostrar botón "Cerrar sesión" si la sesión está iniciada
                echo "<li>
                        <form action='salir_sesion.php' method='post' style='display:inline;'>
                            <button type='submit' style='background:none; border:none; color:white; cursor:pointer;'>Cerrar sesión</button>
                        </form>
                      </li>";
            } else {
                // Mostrar botón "Iniciar sesión" si no hay sesión iniciada
                echo "<li><a href='iniciar_sesion_usuario.php'>Iniciar sesión</a></li>";
                echo "<li><a href='iniciar_sesion_usuario.php'>Carrito</a></li>";
            }
            ?>
            <li><a href="productos.php">Productos</a></li>
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