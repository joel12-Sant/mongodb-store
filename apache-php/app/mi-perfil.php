<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

use MongoDB\BSON\ObjectId;

try {
    $usuarioId = new ObjectId($_SESSION['usuario_id']);
    $usuario = $bd->usuarios->findOne(['_id' => $usuarioId]);
    
    if (!$usuario) {
        throw new Exception("Usuario no encontrado.");
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Krub:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Staatliches&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/styles.css?v=<?php echo time(); ?>">
    <script src="js/index.js"> </script>
</head>
<body>
    <header class="header">
        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
            <div class="left-buttons">
                <a href='find.php' class="admin-button">Administrar Productos</a>
            </div>
        <?php endif; ?>
        
        <a href="index.php" style="display: block; text-align: center;">
            <img class="header__logo" src="img/logo.png" alt="Logotipo" />
        </a>
        
        <div class="right-buttons">
            <?php if(isset($_SESSION['usuario_id'])): ?>
                <a href="logout.php" class="auth-button">Cerrar Sesión</a>
            <?php else: ?>
                <a href="login.php" class="auth-button">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </header>

    <nav class="navegacion">
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <a class="navegacion__enlace navegacion__enlace--activo" href="mi-perfil.php">Mi Perfil</a>
        <?php endif; ?>
        <a class="navegacion__enlace" href="index.php">Tienda</a>
        <a class="navegacion__enlace" href="carrito.php">Carrito</a>
        <a class="navegacion__enlace" href="nosotros.php">Nosotros</a>
    </nav>
    <main>
        <div class="profile-container">
            <div class="profile-header">
                <h1>Mi Perfil</h1>
                <p>Rol: <?php echo htmlspecialchars(ucfirst($usuario['rol'] ?? 'cliente')); ?></p>
            </div>
            
            <div class="profile-info">
                <div class="info-row">
                    <div class="info-label">Nombre:</div>
                    <div class="info-value"><?php echo htmlspecialchars($usuario['nombre'] ?? 'No especificado'); ?></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Correo:</div>
                    <div class="info-value"><?php echo htmlspecialchars($usuario['correo'] ?? 'No especificado'); ?></div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Dirección:</div>
                    <div class="info-value"><?php echo htmlspecialchars($usuario['direccion'] ?? 'No especificado'); ?></div>
                </div>
            </div>
            
            <div class="member-since">
                <?php 
                if (isset($usuario['creado_en'])) {
                    $fechaCreacion = $usuario['creado_en']->toDateTime();
                    echo 'Miembro desde: ' . $fechaCreacion->format('d/m/Y');
                }
                ?>
            </div>
            
            <div class="button-group">
                <a href="compras.php" class="carrito-boton-compra">Mis Compras</a>
                <button onclick="confirmarEliminacion()" class="carrito-boton-compra">Eliminar Cuenta</button>
            </div>
        </div>
    </main>
    
    <footer class="footer">
        <p class="footer__texto">FrontEnd Store - Todos los derechos reservado 2024.</p>
    </footer>
    <form id="formEliminarCuenta" action="delete-cuenta.php" method="post" style="display: none;"></form>
</body>
</html>