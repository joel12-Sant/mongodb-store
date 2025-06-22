<?php
require 'db.php';

$id = (int)$_GET['id'];
$playera = $coleccion->findOne(['id' => $id]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $coleccion->updateOne(
        ['id' => $id],
        ['$set' => [
            'nombre' => $_POST['nombre'],
            'precio' => (float)$_POST['precio'],
            'descripcion' => $_POST['descripcion'],
            'cantidad' => (int)$_POST['cantidad']
        ]]
    );
    header("Location: find.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Playera</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h1>Editar Playera</h1>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Nombre</label>
      <input type="text" name="nombre" class="form-control" value="<?= $playera['nombre'] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Precio</label>
      <input type="number" step="0.01" name="precio" class="form-control" value="<?= $playera['precio'] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Descripción</label>
      <textarea name="descripcion" class="form-control" rows="3" required><?= $playera['descripcion'] ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Cantidad</label>
      <input type="number" name="cantidad" class="form-control" value="<?= $playera['cantidad'] ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
  </form>
</body>
</html>
