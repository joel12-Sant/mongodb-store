<?php
session_start();
if (!isset($_SESSION['usuario'])) {
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
