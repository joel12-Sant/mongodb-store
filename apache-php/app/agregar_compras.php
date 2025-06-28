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
    $carrito = $bd->carritos->findOne(['usuario_id' => $usuarioId]);

    if (!$carrito || empty($carrito['items'])) {
        throw new Exception("El carrito está vacío.");
    }

    $productosCompra = [];
    $total = 0;

    // ¿Compra individual o total?
    if (isset($_POST['item_id'])) {
        // Compra individual
        $itemId = $_POST['item_id'];

        foreach ($carrito['items'] as $item) {
            $actualId = isset($item['_id']) ? (string)$item['_id'] : md5((string)$item['producto_id'] . $item['talla']);

            if ($actualId === $itemId) {
                $producto = $bd->playeras->findOne(['_id' => $item['producto_id']]);
                if (!$producto) continue;

                $subtotal = $producto['precio'] * $item['cantidad'];
                $total += $subtotal;

                $productosCompra[] = [
                    'playera_id' => $producto['_id'],
                    'talla' => $item['talla'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto['precio']
                ];

                break; // solo un producto
            }
        }

    } else {
        // Compra total
        foreach ($carrito['items'] as $item) {
            $producto = $bd->playeras->findOne(['_id' => $item['producto_id']]);
            if (!$producto) continue;

            $subtotal = $producto['precio'] * $item['cantidad'];
            $total += $subtotal;

            $productosCompra[] = [
                'playera_id' => $producto['_id'],
                'talla' => $item['talla'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $producto['precio']
            ];
        }
    }

    // Guardar en la colección compras
    if (!empty($productosCompra)) {
        $bd->compras->insertOne([
            'usuario_id' => $usuarioId,
            'productos' => $productosCompra,
            'total' => $total,
            'fecha' => new MongoDB\BSON\UTCDateTime()
        ]);

        // Si fue compra total, limpiamos todo el carrito
        if (!isset($_POST['item_id'])) {
            $bd->carritos->updateOne(
                ['usuario_id' => $usuarioId],
                ['$set' => ['items' => []]]
            );
        } else {
            $carrito = $bd->carritos->findOne(['usuario_id' => $usuarioId]);

            foreach ($carrito['items'] as $item) {
                $actualId = isset($item['_id']) ? (string)$item['_id'] : md5((string)$item['producto_id'] . $item['talla']);

                if ($actualId === $_POST['item_id']) {
                    $bd->carritos->updateOne(
                        ['usuario_id' => $usuarioId],
                        ['$pull' => ['items' => $item]]
                    );
                    break;
                }
            }

        }
    }

    $_SESSION['mensaje_exito'] = "¡Compra realizada con éxito!";
    header("Location: compras.php");
    exit;

} catch (Exception $e) {
    echo "Error al procesar la compra: " . $e->getMessage();
}
