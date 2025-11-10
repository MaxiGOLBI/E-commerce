<?php
    session_start();
    require_once __DIR__ . '/config.php';
   
    if(isset($_POST['guardar_datos'])){
        include_once 'includes/bd.php';
        $direccion = $_POST['direccion'];
        $celular = $_POST['celular'];
        $contraseña = $_POST['contraseña'];
        $contraseña = password_hash($contraseña, PASSWORD_BCRYPT);
        if($direccion != '' && $celular != '' && $contraseña != ''){
            $resultado = cargar_datos_GSI($direccion, $celular, $contraseña);
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        }
    }
      
 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ctrl Gear</title>
    <link rel="icon" href="<?= BASE_URL ?>/assets/img/logoCeleste.png" type="image/png">
    
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesNavBar.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesCategorias.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesPanel.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesModal.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesNotifications.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesCarousel.css">
    
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesProducts.css"> 

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <?php
    include ROOT_PATH . '/pages/layouts/nav.php';
    ?>
    
   <div class="menu-wrapper d-flex justify-content-between align-items-center">
        <button class="boton-categorias" id="btnCategorias">
            Categorías <span style="font-size: 14px;">▼</span>
        </button>
        <ul class="lista-categorias" id="listaCategorias">
            <li><a href="#" data-category="mouses">MOUSES</a></li>
            <li><a href="#" data-category="teclados">TECLADOS</a></li>
            <li><a href="#" data-category="auriculares">AURICULARES</a></li>
            <li><a href="#" data-category="Pads">PADS</a></li>
        </ul>
        <?php
            include_once 'includes/bd.php';
            verificar_admin();
            if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){  
            
        ?>
            <a href="<?= BASE_URL ?>/pages/panel_control/panel_de_control.php" class="etiquetasA poppins-semibold boton-panel-control">Panel de control</a>
        <?php
            }
        ?>
    </div>

    <div id="mainCarousel" class="carousel slide mt-3 shadow-lg rounded-3 overflow-hidden" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
      </div>

      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="assets/img/banner1.jpg" class="d-block w-100" alt="Oferta 1" style="height: 400px; object-fit: cover;" 
               onerror="this.src='https://images.unsplash.com/photo-1587202372775-e229f172b9d7?w=1200&h=400&fit=crop'">
          <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-75 rounded-3 p-3">
            <h5 class="fw-bold">🎮 Grandes Ofertas</h5>
            <p>Descuentos increíbles en periféricos gaming</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="assets/img/banner2.jpg" class="d-block w-100" alt="Oferta 2" style="height: 400px; object-fit: cover;"
               onerror="this.src='https://images.unsplash.com/photo-1616588589676-62b3bd4ff6d2?w=1200&h=400&fit=crop'">
          <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-75 rounded-3 p-3">
            <h5 class="fw-bold">✨ Nuevas Llegadas</h5>
            <p>Los mejores productos gaming de la temporada</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="assets/img/banner3.jpg" class="d-block w-100" alt="Oferta 3" style="height: 400px; object-fit: cover;"
               onerror="this.src='https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=1200&h=400&fit=crop'">
          <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-75 rounded-3 p-3">
            <h5 class="fw-bold">🚀 Compra Fácil</h5>
            <p>Entrega rápida y segura a todo el país</p>
          </div>
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
    
    <main class="container my-4">
        <section id="area-visualizacion-productos">
            <h2 class="mb-4">Productos</h2>
            <div id="productos" class="product-grid">
                </div>
        </section>
    </main>
    
    <script>
        const boton = document.getElementById('btnCategorias');
        const lista = document.getElementById('listaCategorias');
        
        // Muestra u oculta la lista de categorías al hacer clic en el botón
        boton.addEventListener('click', (e) => {
            e.stopPropagation(); // Evita que el evento click se propague y cierre la lista inmediatamente
            lista.style.display = lista.style.display === 'block' ? 'none' : 'block';
        });
        
        // Oculta la lista si se hace clic fuera del botón o la lista
        window.addEventListener('click', (e) => {
            if (!boton.contains(e.target) && !lista.contains(e.target)){
                lista.style.display = 'none';
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const categoryLinks = document.querySelectorAll('#listaCategorias a');
            const productDisplayArea = document.getElementById('productos'); // ID del contenedor de productos
            const searchInput = document.getElementById('searchInput');
            const searchBtn = document.getElementById('searchBtn');

            function loadProducts(categoria, search = '') {
                let url = `products.php?categoria=${categoria}`;
                if (search) {
                    url += `&search=${encodeURIComponent(search)}`;
                }
                
                // Mostrar animación de carga
                productDisplayArea.style.opacity = '0.5';
                productDisplayArea.innerHTML = '<div style="text-align: center; padding: 60px;"><i class="fas fa-spinner fa-spin" style="font-size: 3em; color: #667eea;"></i><p style="margin-top: 20px; color: #64748b;">Cargando productos...</p></div>';
                
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        productDisplayArea.innerHTML = html;
                        productDisplayArea.style.opacity = '1';
                        attachCartListeners(); // Adjuntar eventos al carrito después de cargar productos
                        
                        // Animación de entrada para productos
                        const products = productDisplayArea.querySelectorAll('.product-item');
                        products.forEach((product, index) => {
                            product.style.opacity = '0';
                            product.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                product.style.transition = 'all 0.5s ease';
                                product.style.opacity = '1';
                                product.style.transform = 'translateY(0)';
                            }, index * 100);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        productDisplayArea.innerHTML = '<div class="no-products-message"><i class="fas fa-exclamation-circle"></i><p>Error al cargar los productos. Por favor intenta nuevamente.</p></div>';
                        productDisplayArea.style.opacity = '1';
                    });
            }

            // Funcionalidad de búsqueda
            function performSearch() {
                const searchTerm = searchInput.value.trim();
                loadProducts('', searchTerm);
            }

            if (searchBtn) {
                searchBtn.addEventListener('click', performSearch);
            }

            if (searchInput) {
                searchInput.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        performSearch();
                    }
                });
            }

            categoryLinks.forEach(link => {
                link.addEventListener('click', (event) => {
                    event.preventDefault();
                    const categoria = event.target.dataset.category;
                    searchInput.value = ''; // Limpiar búsqueda al seleccionar categoría
                    loadProducts(categoria);
                    lista.style.display = 'none'; // Cierra el menú después de seleccionar
                });
            });

            // Función para agregar al carrito
            function attachCartListeners() {
                const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
                addToCartButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.dataset.productId;
                        const productName = this.dataset.productName;
                        const productPrice = this.dataset.productPrice;
                        
                        addToCart(productId, productName, productPrice);
                    });
                });
            }

            function addToCart(productId, productName, productPrice) {
                fetch('add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `product_id=${productId}&cantidad=1`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        notify.success(`${productName} agregado al carrito exitosamente`, '¡Producto agregado!');
                        // Opcionalmente actualizar el contador del carrito en la navbar
                    } else {
                        notify.error('Error al agregar al carrito: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    notify.error('Error al agregar al carrito. Por favor intenta nuevamente.');
                });
            }

            // Carga todos los productos por defecto al cargar la página
            loadProducts('');
        });
    </script>
    

    <!-- CREAMOS EL MODAL PARA SOLICITARLE LOS DEMAS DATOS AL USUARIO LUEGO DE QUE SE REGISTRA CON EL GSI-->
    <?php if(isset($_SESSION['tipo_login']) && $_SESSION['tipo_login'] == "Usuario creado con gsi por primera vez"): ?>
        
        <div id="modal" class="modal">
            <div class="modal-content">
                <h2>Completa los datos de tu perfil</h2>
                <form method="POST" id="form-perfil">
                    <input type="text" name="direccion" placeholder="Dirección" requiered><br><br>
                    <input type="number" name="celular" placeholder="Telefono" requiered><br><br>
                    <input type="password" name="contraseña" placeholder="Nueva contraseña" required><br><br>
                    <button type="submit" name="guardar_datos" class="boton-guardar">Guardar datos</button>
                </form>
            </div>
        </div>

        <script>
            window.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('modal');
            if (modal) modal.style.display = 'flex'; // o block, según tu diseño
            });
        </script>
        
    <?php endif ;?>    

    <script src="assets/js/notifications.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>