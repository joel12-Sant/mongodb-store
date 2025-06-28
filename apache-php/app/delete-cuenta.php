<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

use MongoDB\BSON\ObjectId;

try {
    $usuarioId = new ObjectId($_SESSION['usuario_id']);

    // Eliminar usuario
    $bd->usuarios->deleteOne(['_id' => $usuarioId]);

    // Eliminar carrito
    $bd->carritos->deleteOne(['usuario_id' => $usuarioId]);

    // Eliminar historial de compras
    $bd->compras->deleteMany(['usuario_id' => $usuarioId]);

    // Cerrar sesión
    session_destroy();

    // Redirigir con mensaje
    session_start(); // Se puede iniciar de nuevo para mostrar mensaje si gustas
    $_SESSION['mensaje_exito'] = "Tu cuenta ha sido eliminada correctamente.";
    header("Location: index.php");
    exit;

} catch (Exception $e) {
    echo "Error al eliminar la cuenta: " . $e->getMessage();
}
