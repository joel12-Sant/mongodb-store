<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require 'db.php'; 
function getNextImageName($dir = 'img/') {
    $files = scandir($dir);
    $numbers = [];

    foreach ($files as $file) {
        if (preg_match('/^(\d+)\.jpg$/', $file, $matches)) {
            $numbers[] = (int)$matches[1];
        }
    }

    $next = empty($numbers) ? 1 : max($numbers) + 1;
    return "$next.jpg";
}

function getNextId($coleccion) {
    $ultimo = $coleccion->findOne([], ['sort' => ['id' => -1]]);
    return $ultimo ? $ultimo['id'] + 1 : 1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imagenNombre = '';

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nuevoNombre = getNextImageName();
        $rutaDestino = 'img/' . $nuevoNombre;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
        $imagenNombre = $rutaDestino;
    }

    $nuevaPlayera = [
        'id' => getNextId($coleccion),
        'nombre' => $_POST['nombre'],
        'precio' => (float)$_POST['precio'],
        'cantidad' => (int)$_POST['cantidad'],
        'descripcion' => $_POST['descripcion'],
        'imagen' => $nuevoNombre
    ];

    $coleccion->insertOne($nuevaPlayera);
    header("Location: find.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Playera</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h1>Agregar Nueva Playera</h1>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Nombre</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Precio</label>
      <input type="number" step="0.01" name="precio" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Cantidad</label>
      <input type="number" name="cantidad" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea name="descripcion" class="form-control" rows="3" required></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Imagen (JPG)</label>
      <input type="file" name="imagen" accept=".jpg" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="find.php" class="btn btn-secondary">Cancelar</a>
  </form>
</body>
</html>
