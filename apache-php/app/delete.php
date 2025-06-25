<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require 'db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $imagenRuta = __DIR__ . "/img/{$id}.jpg";
    if (file_exists($imagenRuta)) {
        unlink($imagenRuta);
    }

    $coleccion->deleteOne(['id' => $id]);
}

header("Location: find.php");
exit();
?>
