<?php
    session_start();
    
    require_once __DIR__ . '/../../config.php';

    if(isset($_POST['guardar_datos'])){
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $cantidad = $_POST['cantidad'];
        $precio_costo = $_POST['precio_costo'];
        $precio_venta = $_POST['precio_venta'];

        include_once('../../includes/Producto.php');
        if ($_POST['nombre'] != "" && $_POST['categoria'] != "" && $_POST['cantidad'] != "" && $_POST['precio_costo'] != "" && $_POST['precio_venta'] != "" && !empty($_FILES['imagen']['name'])){
            $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
            $producto = new Producto($nombre, $categoria, $cantidad, $precio_costo, $precio_venta, $imagen);
            $resultado = $producto->crearProducto($producto);   
            
            // Guardar mensaje en sesión para mostrar el toast
            $_SESSION['mensaje_toast'] = 'Producto creado correctamente';
            $_SESSION['tipo_toast'] = 'success';
            
            header("Location: " . BASE_URL . "/pages/panel_control/g_productos.php");
            exit();
        } else {
            $_SESSION['mensaje_toast'] = 'Por favor, completa todos los campos incluyendo la imagen';
            $_SESSION['tipo_toast'] = 'error';
        }
    }   
    
    if(isset($_POST['actualizar_datos'])){
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $cantidad = $_POST['cantidad'];
        $precio_costo = $_POST['precio_costo'];
        $precio_venta = $_POST['precio_venta'];
        
        include_once('../../includes/Producto.php');
        
        if ($_POST['nombre'] != "" && $_POST['categoria'] != "" && $_POST['cantidad'] != "" && $_POST['precio_costo'] != "" && $_POST['precio_venta'] != ""){
            
            // Si se proporciona una nueva imagen, actualizar con imagen
            if (!empty($_FILES['imagen']['name'])) {
                $imagen = file_get_contents($_FILES['imagen']['tmp_name']);
                $producto = new Producto($nombre, $categoria, $cantidad, $precio_costo, $precio_venta, $imagen);
                $producto->setId($id);
                $resultado = Producto::actualizarProducto($producto);
            } else {
                // Si no se proporciona imagen, actualizar sin cambiar la imagen
                $producto = new Producto($nombre, $categoria, $cantidad, $precio_costo, $precio_venta, '');
                $producto->setId($id);
                $resultado = Producto::actualizarProductoSinImagen($producto);
            }
            
            // Guardar mensaje en sesión para mostrar el toast
            $_SESSION['mensaje_toast'] = 'Producto actualizado correctamente';
            $_SESSION['tipo_toast'] = 'success';
            
            header("Location: " . BASE_URL . "/pages/panel_control/g_productos.php");
            exit();
        } 
    }
    
    if(isset($_POST['confirmar_eliminar'])){
        $id = $_POST['id'];
        include_once('../../includes/Producto.php');
        $resultado = Producto::eliminarProducto($id);
        
        if(strpos($resultado, 'correctamente') !== false){
            $_SESSION['mensaje_toast'] = 'Producto eliminado correctamente';
            $_SESSION['tipo_toast'] = 'success';
        } else {
            $_SESSION['mensaje_toast'] = $resultado;
            $_SESSION['tipo_toast'] = 'error';
        }
        
        header("Location: " . BASE_URL . "/pages/panel_control/g_productos.php");
        exit();
    }
    
    // Variable para almacenar el producto a editar
    $producto_a_editar = null;
    if(isset($_GET['editar_producto'])){
        $id = $_GET['id'];
        include_once('../../includes/Producto.php');
        $producto_a_editar = Producto::obtenerProductoPorId($id);
    }
    
    // Variable para almacenar el producto a eliminar
    $producto_a_eliminar = null;
    if(isset($_GET['eliminar_producto'])){
        $id = $_GET['id'];
        include_once('../../includes/Producto.php');
        $producto_a_eliminar = Producto::obtenerProductoPorId($id);
    }
    
    // Configuración de paginación
    $productos_por_pagina = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
    $pagina_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    
    // Asegurar valores válidos
    $productos_por_pagina = max(5, min(50, $productos_por_pagina)); // Entre 5 y 50
    $pagina_actual = max(1, $pagina_actual); // Mínimo 1

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ctrl Gear Panel de control</title>
    <link rel="icon" href="../assets/img/logoCeleste.png" type="image/png">

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesNavBar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesLogin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesPanel.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesModal.css">

    <!--FUENTE-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


   
</head>
<body>
    <?php
    include ROOT_PATH . '/pages/layouts/nav.php';
    ?>


    <div class="layout">
        <div class="sidebar">
           <a href="<?= BASE_URL ?>/pages/panel_control/panel_de_control.php" class="letraTitulos px-3 py-3">DASHBOARD</a>
            <a href="<?= BASE_URL ?>/pages/panel_control/g_productos.php" class="letraTitulos px-3 py-3">GESTIÓN DE PRODUCTOS</a>
            <a href="pedidos.php" class="letraTitulos px-3 py-3">PEDIDOS</a>
            <a href="ventas.php" class="letraTitulos px-3 py-3">VENTAS</a>
        </div>
        <div class="content">
            <div class="container-fluid">
                <h2 class="title">Gestión productos</h2>
                <form method="POST">
                    <button name="crear_producto" class="button-crear-producto" type="submit"> Crear producto </button>
                </form>
                
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Categoria</th>
                            <th>Cantidad</th>
                            <th>Precio costo</th>
                            <th>Precio venta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include_once('../../includes/Producto.php');
                            $productos = Producto::obtenerProductosPaginados($pagina_actual, $productos_por_pagina);
                            $total_paginas = Producto::contarTotalPaginas($productos_por_pagina);
                            $total_productos = Producto::contarTotalProductos();
                            
                            // Calcular información de paginación
                            $inicio = ($pagina_actual - 1) * $productos_por_pagina + 1;
                            $fin = min($pagina_actual * $productos_por_pagina, $total_productos);
                            
                            if($productos && mysqli_num_rows($productos) > 0):
                                while($producto = mysqli_fetch_assoc($productos)):
                        ?>
                        <tr>
                            <td><?= $producto['id'] ?></td>
                            <td><?= $producto['nombre'] ?></td>
                            <td><?= $producto['categoria'] ?></td>
                            <td><?= $producto['cantidad'] ?></td>
                            <td>$<?= number_format($producto['precio_costo'], 0, ',', '.') ?></td>
                            <td>$<?= number_format($producto['precio_venta'], 0, ',', '.') ?></td>
                            <td>

                                <form action="" method="GET" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                    <input type="hidden" name="page" value="<?= $pagina_actual ?>">
                                    <input type="hidden" name="per_page" value="<?= $productos_por_pagina ?>">
                                    <button type="submit" style="border:none; background:none; cursor:pointer; margin-right: 5px;" name="editar_producto" title="Editar producto">
                                        <img src="<?= BASE_URL ?>/assets/img/edit.png" alt="Editar" style="width: 20px; height: 20px;">
                                    </button>
                                </form>
                                
                                <form action="" method="GET" style="display: inline;">
                                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                    <input type="hidden" name="page" value="<?= $pagina_actual ?>">
                                    <input type="hidden" name="per_page" value="<?= $productos_por_pagina ?>">
                                    <button type="submit" style="border:none; background:none; cursor:pointer;" name="eliminar_producto" title="Eliminar producto">
                                        <img src="<?= BASE_URL ?>/assets/img/delete.png" alt="Eliminar" style="width: 20px; height: 20px;">
                                    </button>
                                </form>
                                
                            </td>
                        </tr>
                        <?php 
                                endwhile;
                            else:
                        ?>
                        <tr>
                            <td colspan="7" class="text-center" style="padding: 40px;">
                                <div style="color: #666; font-style: italic;">
                                    <i class="fas fa-box-open" style="font-size: 3rem; opacity: 0.3; margin-bottom: 15px;"></i><br>
                                    No hay productos registrados
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
                
                <?php if($total_productos > 0): ?>
                <div class="pagination-container">
                    <!-- Información de paginación -->
                    <div class="pagination-info">
                        Mostrando <?= $inicio ?> - <?= $fin ?> de <?= $total_productos ?> productos
                    </div>
                    
                    <!-- Navegación de páginas -->
                    <nav aria-label="Navegación de productos">
                        <ul class="pagination">
                            <!-- Botón Anterior -->
                            <li class="page-item <?= $pagina_actual <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link prev-next" 
                                   href="<?= $pagina_actual > 1 ? '?page=' . ($pagina_actual - 1) . '&per_page=' . $productos_por_pagina : '#' ?>"
                                   <?= $pagina_actual <= 1 ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                                    <i class="fas fa-chevron-left"></i> Anterior
                                </a>
                            </li>
                            
                            <?php
                            // Calcular rango de páginas a mostrar
                            $rango = 2; // Páginas a cada lado de la actual
                            $inicio_rango = max(1, $pagina_actual - $rango);
                            $fin_rango = min($total_paginas, $pagina_actual + $rango);
                            
                            // Primera página si no está en el rango
                            if($inicio_rango > 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=1&per_page=' . $productos_por_pagina . '">1</a></li>';
                                if($inicio_rango > 2) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                            }
                            
                            // Páginas en el rango
                            for($i = $inicio_rango; $i <= $fin_rango; $i++):
                            ?>
                                <li class="page-item <?= $i == $pagina_actual ? 'active' : '' ?>">
                                    <a class="page-link" 
                                       href="?page=<?= $i ?>&per_page=<?= $productos_por_pagina ?>"
                                       <?= $i == $pagina_actual ? 'aria-current="page"' : '' ?>>
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor;
                            
                            // Última página si no está en el rango
                            if($fin_rango < $total_paginas) {
                                if($fin_rango < $total_paginas - 1) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $total_paginas . '&per_page=' . $productos_por_pagina . '">' . $total_paginas . '</a></li>';
                            }
                            ?>
                            
                            <!-- Botón Siguiente -->
                            <li class="page-item <?= $pagina_actual >= $total_paginas ? 'disabled' : '' ?>">
                                <a class="page-link prev-next" 
                                   href="<?= $pagina_actual < $total_paginas ? '?page=' . ($pagina_actual + 1) . '&per_page=' . $productos_por_pagina : '#' ?>"
                                   <?= $pagina_actual >= $total_paginas ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                                    Siguiente <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    
                    <!-- Selector de productos por página -->
                    <div class="pagination-nav">
                        <label class="pagination-label" for="per-page">Mostrar:</label>
                        <select class="pagination-select" id="per-page" onchange="changePagination()">
                            <option value="5" <?= $productos_por_pagina == 5 ? 'selected' : '' ?>>5 por página</option>
                            <option value="10" <?= $productos_por_pagina == 10 ? 'selected' : '' ?>>10 por página</option>
                            <option value="20" <?= $productos_por_pagina == 20 ? 'selected' : '' ?>>20 por página</option>
                            <option value="50" <?= $productos_por_pagina == 50 ? 'selected' : '' ?>>50 por página</option>
                        </select>
                    </div>
                </div>
                
                <script>
                function changePagination() {
                    const perPage = document.getElementById('per-page').value;
                    window.location.href = '?page=1&per_page=' + perPage;
                }
                </script>
                <?php endif; ?>
            </div>
        </div>
        
        
        
        <?php if(isset($_POST['crear_producto'])):?>
            <div id="modal" class="modal">
                <div class="modal-content">
                    <button type="button" class="modal-close" onclick="closeModal()">&times;</button>
                    <h2>Crear Nuevo Producto</h2>
                    <form method="POST" id="form-perfil" enctype="multipart/form-data">
                        <input type="text" name="nombre" placeholder="Nombre del producto" required><br><br>
                        <input type="text" name="categoria" placeholder="Categoría" required><br><br>
                        <input type="number" name="cantidad" placeholder="Cantidad en stock" required><br><br>
                        <input type="number" name="precio_costo" placeholder="Precio de costo" required><br><br>
                        <input type="number" name="precio_venta" placeholder="Precio de venta" required><br><br>
                        <input type="file" name="imagen" class="form-archivos" accept="image/*" required><br><br>
                        <div class="botones-modal">
                            <button type="submit" name="guardar_datos" class="boton-cargar">
                                <i class="fas fa-save"></i> Crear Producto
                            </button>
                            <button type="button" onclick="closeModal()" class="boton-volver">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                function closeModal() {
                    const modal = document.getElementById('modal');
                    if (modal) {
                        modal.style.opacity = '0';
                        setTimeout(() => {
                            modal.style.display = 'none';
                            modal.style.opacity = '1';
                        }, 300);
                    }
                }
                
                // Mostrar modal con animación
                window.addEventListener('DOMContentLoaded', function () {
                    const modal = document.getElementById('modal');
                    if (modal) {
                        modal.style.display = 'flex';
                        modal.style.opacity = '0';
                        setTimeout(() => {
                            modal.style.opacity = '1';
                        }, 10);
                    }
                });
            </script>
        <?php endif ;?> 
        
        <?php if(isset($_GET['editar_producto']) && $producto_a_editar):?>
            <div id="modal-editar" class="modal">
                <div class="modal-content">
                    <button type="button" class="modal-close" onclick="closeEditModal()">&times;</button>
                    <h2>Editar Producto</h2>
                    <form method="POST" id="form-editar" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                        <input type="text" name="nombre" placeholder="Nombre del producto" value="<?= $producto_a_editar->getNombre() ?>" required><br><br>
                        <input type="text" name="categoria" placeholder="Categoría" value="<?= $producto_a_editar->getCategoria() ?>" required><br><br>
                        <input type="number" name="cantidad" placeholder="Cantidad en stock" value="<?= $producto_a_editar->getCantidad() ?>" required><br><br>
                        <input type="number" name="precio_costo" placeholder="Precio de costo" value="<?= $producto_a_editar->getPrecioCosto() ?>" required><br><br>
                        <input type="number" name="precio_venta" placeholder="Precio de venta" value="<?= $producto_a_editar->getPrecioVenta() ?>" required><br><br>
                        <input type="file" name="imagen" class="form-archivos" accept="image/*">
                        <small>Deja vacío si no quieres cambiar la imagen actual</small><br><br>
                        <div class="botones-modal">
                            <button type="submit" name="actualizar_datos" class="boton-cargar">
                                <i class="fas fa-save"></i> Actualizar
                            </button>
                            <button type="button" onclick="closeEditModal()" class="boton-volver">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                function closeEditModal() {
                    window.location.href = '<?= BASE_URL ?>/pages/panel_control/g_productos.php';
                }
                
                // Mostrar modal con animación
                window.addEventListener('DOMContentLoaded', function () {
                    const modal = document.getElementById('modal-editar');
                    if (modal) {
                        modal.style.display = 'flex';
                        modal.style.opacity = '0';
                        setTimeout(() => {
                            modal.style.opacity = '1';
                        }, 10);
                    }
                });
            </script>
        <?php endif ;?>
        
        <?php if(isset($_GET['eliminar_producto']) && $producto_a_eliminar):?>
            <div id="modal-eliminar" class="modal">
                <div class="modal-content modal-delete">
                    <button type="button" class="modal-close" onclick="closeDeleteModal()">&times;</button>
                    <h2>Confirmar Eliminación</h2>
                    
                    <div class="delete-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    
                    <div class="delete-warning">
                        <strong>¡Atención!</strong> Esta acción no se puede deshacer.
                    </div>
                    
                    <p style="text-align: center; margin: 20px 0; font-size: 1.1rem;">
                        ¿Estás seguro de que deseas eliminar este producto?
                    </p>
                    
                    <div class="product-info">
                        <p><strong>Producto:</strong> <?= $producto_a_eliminar->getNombre() ?></p>
                        <p><strong>Categoría:</strong> <?= $producto_a_eliminar->getCategoria() ?></p>
                        <p><strong>Cantidad:</strong> <?= $producto_a_eliminar->getCantidad() ?> unidades</p>
                        <p><strong>Precio:</strong> $<?= number_format($producto_a_eliminar->getPrecioVenta(), 0, ',', '.') ?></p>
                    </div>
                    
                    <form method="POST" style="margin: 0;">
                        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                        <div class="botones-modal">
                            <button type="submit" name="confirmar_eliminar" class="boton-eliminar">
                                <i class="fas fa-trash"></i> Sí, Eliminar
                            </button>
                            <button type="button" onclick="closeDeleteModal()" class="boton-volver">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
                function closeDeleteModal() {
                    window.location.href = '<?= BASE_URL ?>/pages/panel_control/g_productos.php';
                }
                
                // Mostrar modal con animación
                window.addEventListener('DOMContentLoaded', function () {
                    const modal = document.getElementById('modal-eliminar');
                    if (modal) {
                        modal.style.display = 'flex';
                        modal.style.opacity = '0';
                        setTimeout(() => {
                            modal.style.opacity = '1';
                        }, 10);
                    }
                });
                
                // Cerrar con ESC
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape') {
                        closeDeleteModal();
                    }
                });
            </script>
        <?php endif ;?>
        
    </div>
    
    <!-- Toast para mensajes -->
    <div id="toast" class="toast"></div>
    
    <script>
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = 'toast ' + type;
            
            // Mostrar el toast
            setTimeout(() => {
                toast.classList.add('show');
            }, 300);
            
            // Ocultar el toast después de 5 segundos
            setTimeout(() => {
                toast.classList.remove('show');
            }, 5000);
        }
        
        // Verificar si hay mensajes de toast al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            <?php if(isset($_SESSION['mensaje_toast'])): ?>
                showToast('<?= addslashes($_SESSION['mensaje_toast']) ?>', '<?= $_SESSION['tipo_toast'] ?>');
                <?php 
                    unset($_SESSION['mensaje_toast']); 
                    unset($_SESSION['tipo_toast']); 
                ?>
            <?php endif; ?>
        });
    </script>
    
    <script src="__ROOT__/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>