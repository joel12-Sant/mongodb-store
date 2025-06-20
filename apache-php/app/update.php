<?php
require 'db.php';

$id = (int)$_GET['id'];
$estudiante = $coleccion->findOne(['id' => $id]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $coleccion->updateOne(
        ['id' => $id],
        ['$set' => [
            'nombre' => $_POST['nombre'],
            'grupo' => $_POST['grupo'],
            'f_nac' => new MongoDB\BSON\UTCDateTime(strtotime($_POST['f_nac']) * 1000)
        ]]
    );
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar estudiante</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h1>Editar Estudiante</h1>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Nombre</label>
      <input type="text" name="nombre" class="form-control" value="<?= $estudiante['nombre'] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Grupo</label>
      <input type="text" name="grupo" class="form-control" value="<?= $estudiante['grupo'] ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Fecha de nacimiento</label>
      <input type="date" name="f_nac" class="form-control" value="<?= date('Y-m-d', $estudiante['f_nac']->toDateTime()->getTimestamp()) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
  </form>
</body>
</html>
