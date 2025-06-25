<?php
session_start();
require 'db.php'; // define $bd

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $password = trim($_POST['password']);
    $direccion = trim($_POST['direccion']);

    $usuarios = $bd->usuarios;

    // Verificar si ya existe un usuario con ese correo
    $existe = $usuarios->findOne(['correo' => $correo]);

    if ($existe) {
        $error = "Ya existe un usuario registrado con ese correo.";
    } else {
        // Hashear contraseña
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $nuevoUsuario = [
            'nombre' => $nombre,
            'correo' => $correo,
            'password' => $hash,
            'direccion' => $direccion,
            'rol' => 'cliente',
            'creado_en' => new MongoDB\BSON\UTCDateTime()
        ];

        $resultado = $usuarios->insertOne($nuevoUsuario);

        // Guardar sesión
        $_SESSION['usuario_id'] = (string) $resultado->getInsertedId();
        $_SESSION['nombre'] = $nombre;
        $_SESSION['rol'] = 'cliente';

        header("Location: index.php"); 
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cuenta - FrontEnd Store</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Krub:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Staatliches&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/styles.css?v=<?php echo time(); ?>">
</head>
<body class="login-page">
    <div class="login-container">
        <h1 class="login-title">Crear Cuenta</h1>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form class="login-form" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="correo">Email</label>
                <input type="email" id="correo" name="correo" required>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="login-button">Registrarse</button>
        </form>

        <p style="text-align: center; margin-top: 10px;">
            ¿Ya tienes una cuenta? <a href="login.php" class="form-enlace">Inicia sesión</a>
        </p>
    </div>
</body>
</html>
