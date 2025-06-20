<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo = [
        'id' => (int)$_POST['id'],
        'nombre' => $_POST['nombre'],
        'grupo' => $_POST['grupo'],
        'f_nac' => new MongoDB\BSON\UTCDateTime(strtotime($_POST['f_nac']) * 1000)
    ];
    $coleccion->insertOne($nuevo);
    header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar estudiante</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h1>Agregar Estudiante</h1>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">ID</label>
      <input type="number" name="id" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Nombre</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Grupo</label>
      <input type="text" name="grupo" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Fecha de nacimiento</label>
      <input type="date" name="f_nac" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
  </form>
</body>
</html>
