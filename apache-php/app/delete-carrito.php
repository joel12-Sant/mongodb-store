<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['item_id'], $_POST['producto_id'], $_POST['cantidad'])) {
    $_SESSION['error'] = "Solicitud inválida";
    header("Location: carrito.php");
    exit;
}
try {
    $usuarioId = new MongoDB\BSON\ObjectId($_SESSION['usuario_id']);
    $productoId = new MongoDB\BSON\ObjectId($_POST['producto_id']);
    $cantidad = (int)$_POST['cantidad'];
    $itemId = $_POST['item_id'];

    $carrito = $bd->carritos->findOne(['usuario_id' => $usuarioId]);
    
    if (!$carrito) {
        throw new Exception("Carrito no encontrado");
    }

    $itemsArray = iterator_to_array($carrito['items']);

    $itemsActualizados = array_filter($itemsArray, function($item) use ($itemId, $productoId) {
        $currentItemId = isset($item['_id']) ? (string)$item['_id'] : md5((string)$item['producto_id'] . $item['talla']);
        return !($currentItemId === $itemId && (string)$item['producto_id'] === (string)$productoId);
    });

    $updateResult = $bd->carritos->updateOne(
        ['_id' => $carrito['_id']],
        ['$set' => [
            'items' => array_values($itemsActualizados),
            'fecha_actualizacion' => new MongoDB\BSON\UTCDateTime()
        ]]
    );

    $updateProducto = $bd->playeras->updateOne(
        ['_id' => $productoId],
        ['$inc' => ['cantidad' => $cantidad]]
    );

    $_SESSION['exito'] = "Producto eliminado del carrito";
} catch (Exception $e) {
    $_SESSION['error'] = "Error al eliminar: " . $e->getMessage();
}

header("Location: carrito.php");
exit;
?>