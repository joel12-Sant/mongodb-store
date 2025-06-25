<?php
session_start();
require 'db.php'; 

if (!isset($_GET['id'])) {
    die("Producto no especificado.");
}

try {
    $id = new MongoDB\BSON\ObjectId($_GET['id']);
    $playera = $coleccion->findOne(['_id' => $id]);

    if (!$playera) {
        die("Producto no encontrado.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_SESSION['usuario_id'])) {
            $_SESSION['redirect_to'] = 'producto.php?id=' . $_GET['id'];
            header("Location: login.php");
            exit;
        }

        $talla = $_POST['talla'] ?? '';
        $cantidad = intval($_POST['cantidad'] ?? 1);

        if (empty($talla)) {
            $error = "Debes seleccionar una talla";
        } elseif ($cantidad < 1 || $cantidad > $playera['cantidad']) {
            $error = "Sin stock";
        } else {
            // Preparar datos para add-carrito.php
            $_SESSION['add_to_cart'] = [
                'producto_id' => (string)$_GET['id'],
                'talla' => $talla,
                'cantidad' => $cantidad
            ];
            header("Location: add-carrito.php");
            exit;
        }
    }
} catch (Exception $e) {
    die("Error al procesar el producto: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<!-- ... (Mantén todo el HTML visual igual) ... -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FrontEnd Store</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Krub:wght@300;700&family=Staatliches&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <header class="header">
        <a href="index.php">
            <img class="header__logo" src="img/logo.png" alt="Logotipo" />
        </a>
    </header>

    <nav class="navegacion">
        <a class="navegacion__enlace" href="index.php">Tienda</a>
        <a class="navegacion__enlace" href="nosotros.php">Nosotros</a>
    </nav>

    <main class="contenedor"> 
        <h1><?= htmlspecialchars($playera['nombre']) ?></h1>
        
        <?php if (isset($error)): ?>
            <div class="error-mensaje"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <div class="camisa">
            <img class="camisa__imagen" src="img/<?= htmlspecialchars($playera['imagen']) ?>" alt="imagen del producto" />
            <div class="camisa__contenido">
                <p class="camisa__texto">
                    <?= htmlspecialchars($playera['descripcion']) ?>
                </p>
                
                <form class="formulario" method="POST">
                    <select class="formulario__campo" name="talla" id="talla" required>
                        <option value="" selected disabled>--Seleccionar talla--</option>
                        <option value="Chica">Chica</option>
                        <option value="Mediana">Mediana</option>
                        <option value="Grande">Grande</option>
                    </select>
                    <input class="formulario__campo" type="number" name="cantidad" placeholder="Cantidad" max="<?= $playera['cantidad'] ?>">
                    <input class="formulario__submit" type="submit" value="Agregar al carrito">
                </form>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p class="footer__texto">FrontEnd Store - Todos los derechos reservado 2024.</p>
    </footer>
</body>
</html>