<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require 'db.php'; 
?> 
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Playeras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h1>Inventario de Playeras</h1>

  <!-- Formularios de búsqueda -->
  <div class="row mb-4">
    <div class="col-md-6">
      <form method="GET" class="d-flex">
        <input type="text" name="buscar_nombre" class="form-control me-2" placeholder="Buscar por nombre" value="<?= $_GET['buscar_nombre'] ?? '' ?>">
        <button class="btn btn-outline-primary" type="submit">Buscar</button>
      </form>
    </div>
    <div class="col-md-6">
      <form method="GET" class="d-flex">
        <input type="number" step="0.01" name="buscar_precio" class="form-control me-2" placeholder="Buscar por precio" value="<?= $_GET['buscar_precio'] ?? '' ?>">
        <button class="btn btn-outline-secondary" type="submit">Buscar</button>
      </form>
    </div>
  </div>

  <div class="botons-table-agregar">
    <a href="create.php" class="btn btn-primary mb-3">Agregar Playera</a>
    <a href="index.php" class="btn btn-primary mb-3">Ver Tienda</a>
  </div>
  <table class="table table-bordered">
    <thead>
      <tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Descripción</th><th>Acciones</th></tr>
    </thead>
    <tbody>
      <?php
        $filtro = [];

        if (!empty($_GET['buscar_nombre'])) {
          $filtro['nombre'] = ['$regex' => $_GET['buscar_nombre'], '$options' => 'i'];
        }

        if (!empty($_GET['buscar_precio'])) {
          $filtro['precio'] = (float)$_GET['buscar_precio'];
        }

        $playeras = $coleccion->find($filtro);

        foreach ($playeras as $p) {
          echo "<tr>
                  <td>{$p['id']}</td>
                  <td>{$p['nombre']}</td>
                  <td>\${$p['precio']}</td>
                  <td>{$p['descripcion']}</td>
                  <td>
                    <a href='update.php?id={$p['id']}' class='btn btn-warning btn-sm'>Editar</a>
                    <a href='delete.php?id={$p['id']}' class='btn btn-danger btn-sm'>Eliminar</a>
                  </td>
                </tr>";
        }
      ?>
    </tbody>
  </table>
  <a href="logout.php" class="btn btn-primary mb-3">Cerrar sesión</a>
</body>
</html>
