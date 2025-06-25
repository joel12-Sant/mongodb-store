<?php
session_start();
require 'db.php'; // Asegúrate de que define $cliente y $bd

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo']; // campo "usuario" es en realidad el correo
    $password = $_POST['password'];

    // Buscar usuario en la colección 'usuarios'
    $usuarios = $bd->usuarios;
    $usuario = $usuarios->findOne(['correo' => $correo]);

    if ($usuario && $usuario['rol'] === 'admin' && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario_id'] = (string) $usuario['_id'];
        $_SESSION['rol'] = $usuario['rol'];
        $_SESSION['nombre'] = $usuario['nombre'];

        header("Location: find.php");
        exit;
    } elseif ($usuario && $usuario['rol'] === 'cliente' && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario_id'] = (string) $usuario['_id'];
        $_SESSION['rol'] = $usuario['rol'];
        $_SESSION['nombre'] = $usuario['nombre'];

        header("Location: index.php");
        exit;
    }else{
        $error = "Usuario o contraseña incorrectos, o no tienes permisos de administrador.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FrontEnd Store</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Krub:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Staatliches&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/styles.css?v=<?php echo time(); ?>">
</head>
<body class="login-page">
    <div class="login-container">
        <h1 class="login-title">LOG IN</h1>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form class="login-form" method="POST">
            <div class="form-group">
                <label for="usuario">Email</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-button">Log in</button>

            <a href="s"></a>

            <p style="text-align: center; margin-top: 10px;">
            ¿Aun no eres usuario? <a href="sign-in.php" class="form-enlace">Registrate aqui</a>
            </p>
        </form>
    </div>
</body>
</html>