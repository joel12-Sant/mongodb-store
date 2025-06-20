<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Estudiantes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h1>Estudiantes</h1>
  <a href="create.php" class="btn btn-primary mb-3">Agregar estudiante</a>
  <table class="table table-bordered">
    <thead><tr><th>ID</th><th>Nombre</th><th>Grupo</th><th>Fecha Nac</th><th>Acciones</th></tr></thead>
    <tbody>
      <?php
        $estudiantes = $coleccion->find();
        foreach ($estudiantes as $e) {
          echo "<tr>
                  <td>{$e['id']}</td>
                  <td>{$e['nombre']}</td>
                  <td>{$e['grupo']}</td>
                  <td>" . date('Y-m-d', $e['f_nac']->toDateTime()->getTimestamp()) . "</td>
                  <td>
                    <a href='update.php?id={$e['id']}' class='btn btn-warning btn-sm'>Editar</a>
                    <a href='delete.php?id={$e['id']}' class='btn btn-danger btn-sm'>Eliminar</a>
                  </td>
                </tr>";
        }
      ?>
    </tbody>
  </table>
</body>
</html>
