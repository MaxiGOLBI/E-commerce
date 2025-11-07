<?php
    session_start();
    include_once __DIR__ . '/../../config.php';
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
    
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/stylesProducts.css"> 

    <script src="<?= BASE_URL ?>/assets/js/scripts.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<?php
        include ROOT_PATH . '/pages/layouts/nav.php';
    ?>
    
    <div class="profile-container">
        <!-- Header del Perfil -->
        <div class="profile-header">
            <div class="profile-avatar">
                <i class="fas fa-user"></i>
            </div>
            <h1 class="profile-name"><?= $_SESSION['nombre'] ?? 'Usuario' ?></h1>
            <p class="profile-email"><?= $_SESSION['email'] ?? 'email@example.com' ?></p>
        </div>
        
        <!-- Contenido del Perfil -->
        <div class="profile-content">
            <!-- Información Personal -->
            <div class="profile-card">
                <h3 class="card-title">
                    <i class="fas fa-user-circle"></i>
                    Información Personal
                </h3>
                
                <div class="info-item">
                    <span class="info-label">
                        <i class="fas fa-user"></i>
                        Nombre Completo
                    </span>
                    <span class="info-value"><?= $_SESSION['nombre'] ?? 'No disponible' ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">
                        <i class="fas fa-envelope"></i>
                        Email
                    </span>
                    <span class="info-value"><?= $_SESSION['email'] ?? 'No disponible' ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">
                        <i class="fas fa-id-card"></i>
                        DNI
                    </span>
                    <span class="info-value"><?= $_SESSION['dni'] ?? 'No disponible' ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">
                        <i class="fas fa-phone"></i>
                        Teléfono
                    </span>
                    <span class="info-value"><?= $_SESSION['cel'] ?? 'No disponible' ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">
                        <i class="fas fa-map-marker-alt"></i>
                        Dirección
                    </span>
                    <span class="info-value"><?= $_SESSION['direccion'] ?? 'No especificada' ?></span>
                </div>
                
                <button class="edit-profile-btn" onclick="openEditModal()">
                    <i class="fas fa-edit"></i>
                    Editar Perfil
                </button>
            </div>
            
            <!-- Historial de Pedidos -->
            <div class="profile-card">
                <h3 class="card-title">
                    <i class="fas fa-shopping-bag"></i>
                    Mis Pedidos
                </h3>
                
                <div class="orders-list">
                    <?php
                    // Aquí puedes agregar la lógica para obtener los pedidos del usuario
                    // Por ahora mostramos un array vacío para simular que no tiene pedidos
                    $pedidos_ejemplo = [
                        // Array vacío para mostrar el mensaje de "no hay pedidos"
                    ];
                    
                    if(count($pedidos_ejemplo) > 0):
                        foreach($pedidos_ejemplo as $pedido):
                            $status_class = 'status-' . $pedido['estado'];
                            $status_text = $pedido['estado'] == 'completed' ? 'Completado' : 
                                         ($pedido['estado'] == 'pending' ? 'Pendiente' : 'Cancelado');
                    ?>
                        <div class="order-item">
                            <div>
                                <div class="order-id">Pedido <?= $pedido['id'] ?></div>
                                <div class="order-date"><?= date('d/m/Y', strtotime($pedido['fecha'])) ?></div>
                            </div>
                            <div>
                                <div style="text-align: right; margin-bottom: 5px;">
                                    <strong><?= $pedido['total'] ?></strong>
                                </div>
                                <span class="order-status <?= $status_class ?>">
                                    <?= $status_text ?>
                                </span>
                            </div>
                        </div>
                    <?php 
                        endforeach;
                    else: 
                    ?>
                        <div class="no-orders">
                            <i class="fas fa-shopping-cart" style="font-size: 48px; opacity: 0.3; margin-bottom: 15px;"></i>
                            <h4 style="margin-bottom: 10px; color: #666;">Todavía no hay pedidos realizados</h4>
                            <p style="margin-bottom: 20px; color: #888;">¡Empieza a explorar nuestros productos y realiza tu primer pedido!</p>
                            <a href="<?= BASE_URL ?>/index.php" style="color: #22b4ee; text-decoration: none; font-weight: 600; padding: 10px 20px; border: 2px solid #22b4ee; border-radius: 5px; transition: all 0.3s ease;">
                                <i class="fas fa-shopping-bag" style="margin-right: 8px;"></i>
                                Explorar Productos
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Sección de Estadísticas del Usuario -->
        <div class="profile-card" style="margin-top: 30px;">
            <h3 class="card-title">
                <i class="fas fa-chart-bar"></i>
                Resumen de Actividad
            </h3>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                    <div style="font-size: 2rem; font-weight: bold; color: #22b4ee;">0</div>
                    <div style="color: #666;">Pedidos Realizados</div>
                </div>
                
                <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                    <div style="font-size: 2rem; font-weight: bold; color: #28a745;">$0</div>
                    <div style="color: #666;">Total Gastado</div>
                </div>
                
                <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 10px;">
                    <div style="font-size: 2rem; font-weight: bold; color: #ffc107;">0</div>
                    <div style="color: #666;">Pedidos Pendientes</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Perfil -->
    <div id="editProfileModal" class="modal" style="display: none;">
        <div class="modal-content">
            <button type="button" class="modal-close" onclick="closeEditModal()">&times;</button>
            <h2>Editar Mi Perfil</h2>
            <form method="POST" id="editProfileForm" enctype="multipart/form-data">
                <input type="text" name="nombre" placeholder="Nombre Completo" value="<?= $_SESSION['nombre'] ?? '' ?>" required><br><br>
                <input type="email" name="email" placeholder="Correo Electrónico" value="<?= $_SESSION['email'] ?? '' ?>" required><br><br>
                <input type="text" name="dni" placeholder="Número de DNI" value="<?= $_SESSION['dni'] ?? '' ?>" required><br><br>
                <input type="tel" name="cel" placeholder="Número de Teléfono" value="<?= $_SESSION['cel'] ?? '' ?>" required><br><br>
                <input type="text" name="direccion" placeholder="Dirección Completa" value="<?= $_SESSION['direccion'] ?? '' ?>"><br><br>
                
                <div class="botones-modal">
                    <button type="submit" name="actualizar_perfil" class="boton-cargar">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <button type="button" onclick="closeEditModal()" class="boton-volver">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal() {
            const modal = document.getElementById('editProfileModal');
            modal.style.display = 'flex';
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.style.opacity = '1';
            }, 10);
        }
        
        function closeEditModal() {
            const modal = document.getElementById('editProfileModal');
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.style.display = 'none';
                modal.style.opacity = '1';
            }, 300);
        }
        
        // Cerrar modal al hacer clic fuera
        window.onclick = function(event) {
            const modal = document.getElementById('editProfileModal');
            if (event.target == modal) {
                closeEditModal();
            }
        }
        
        // Cerrar modal con ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeEditModal();
            }
        });
    </script>
    <script src="<?= BASE_URL ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>