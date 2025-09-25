<?php
    session_start();
    
    require_once __DIR__ . '/../../config.php';

    if(isset($_POST['guardar_datos'])){
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $cantidad = $_POST['cantidad'];
        $precio_costo = $_POST['precio_costo'];
        $precio_venta = $_POST['precio_venta'];

        $imagen = $_POST['imagen'];
        include_once('../includes/Producto.php');
        if ($_POST['nombre'] != "" && $_POST['categoria'] != "" && $_POST['cantidad'] != "" && $_POST['precio_costo'] != "" && $_POST['precio_venta'] != "" && $_POST['imagen'] != ""){
            $producto = new Producto($nombre, $categoria, $cantidad, $precio_costo, $precio_venta, $imagen);
            $producto->crearProducto($producto);   
        } 
    }   
    if(isset($_GET['editar_producto'])){
        $id = $_GET['id'];
        #ME QUEDE ACA
    }

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
            <a href="" class="letraTitulos px-3 py-3">SOPORTE</a>
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
                            $productos = Producto::obtenerProductos();
                            foreach($productos as $producto){
                        ?>
                        <tr>
                            <td><?= $producto['id'] ?></td>
                            <td><?= $producto['nombre'] ?></td>
                            <td><?= $producto['categoria'] ?></td>
                            <td><?= $producto['cantidad'] ?></td>
                            <td><?= $producto['precio_costo'] ?></td>
                            <td><?= $producto['precio_venta'] ?></td>
                            <td>

                                <form action="" method="GET">
                                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                    <button type="submit" style="border:none; background:none; cursor:pointer;" name="editar_producto">
                                        <img src="<?= BASE_URL ?>/assets/img/edit.png" alt="Editar">
                                    </button>
    
                                </form>
                                <form action="" method="GET">
                                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                    <button type="submit" style="border:none; background:none; cursor:pointer;" name="eliminar_producto">
                                        <img src="<?= BASE_URL ?>/assets/img/delete.png" alt="Eliminar">
                                    </button>

                                </form>
                                
                            </td>
                        </tr>

                        <?php
                        } 
                        ?>
                            
                       
                    </tbody>

                </table>
                <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item"><a href="#" class="page-link">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active">
                        <a class="page-link" href="#" aria-current="page">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
                </nav>
            </div>
        </div>

        <!-- me quede aca, tengo que hacer un codigo para reutilizar los modals-->
        <?php if(isset($_POST['crear_producto'])):?>
            <div id="modal" class="modal">
                <div class="modal-content">
                    <h2>Completa los datos del producto</h2>
                    <form method="POST" id="form-perfil">
                        <input type="text" name="nombre" placeholder="Nombre producto" requiered><br><br>
                        <input type="text" name="categoria" placeholder="Categoria" requiered><br><br>
                        <input type="number" name="cantidad" placeholder="Cantidad en stock" required><br><br>
                        <input type="number" name="precio_costo" placeholder="Precio costo" requiered><br><br>
                        <input type="number" name="precio_venta" placeholder="Precio venta" requiered><br><br>
                        <input type="file" name="imagen" placeholder="Imagen producto" class="form-archivos" requiered><br><br>
                        <div class="botones-modal">
                            <button type="submit" name="guardar_datos" class="boton-cargar">Cargar producto</button>
                            <button type="submit" id="volver" class="boton-volver">Volver</button>
                        </div>
                        
                    </form>
                </div>
            </div>
            <script>
                window.addEventListener('DOMContentLoaded', function () {
                    const modal = document.getElementById('modal');
                    if (modal) modal.style.display = 'flex';
                    const volverBtn = document.getElementById("volver");
                        if(volverBtn) {
                            volverBtn.addEventListener("click", function(){
                                const modal = document.getElementById('modal');
                                if(modal) modal.style.display = 'none';
                            }); 
                        }
                })
       
            </script>
        <?php endif ;?> 
    </div>
    <script src="__ROOT__/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>