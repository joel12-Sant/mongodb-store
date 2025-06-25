<?php
session_start();
require 'db.php';

// Verificación básica de sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['add_to_cart'])) {
    $_SESSION['error'] = "Datos del producto no recibidos.";
    header("Location: index.php");
    exit;
}

try {
    $usuarioId = new MongoDB\BSON\ObjectId($_SESSION['usuario_id']);
    $productoId = new MongoDB\BSON\ObjectId($_SESSION['add_to_cart']['producto_id']);
    $cantidad = (int)$_SESSION['add_to_cart']['cantidad'];
    $talla = trim($_SESSION['add_to_cart']['talla']);
    
    $producto = $bd->playeras->findOne(['_id' => $productoId]);
    if (!$producto) {
        throw new Exception("Producto no encontrado.");
    }
    
    if ($producto['cantidad'] < $cantidad) {
        throw new Exception("No hay suficiente stock. Disponible: {$producto['cantidad']}");
    }

    $fechaActual = new MongoDB\BSON\UTCDateTime();
    
    $carrito = $bd->carritos->findOne(['usuario_id' => $usuarioId]);
    
    if (!$carrito) {
        $bd->carritos->insertOne([
            'usuario_id' => $usuarioId,
            'items' => [[
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'talla' => $talla,
                'fecha_agregado' => $fechaActual
            ]],
            'fecha_actualizacion' => $fechaActual
        ]);
    } else {
        $itemExistente = false;
        
        // Buscar si ya existe el mismo producto con la misma talla
        foreach ($carrito['items'] as &$item) {
            if ((string)$item['producto_id'] === (string)$productoId && $item['talla'] === $talla) {
                $nuevaCantidad = $item['cantidad'] + $cantidad;
                
                if ($producto['cantidad'] < $nuevaCantidad) {
                    throw new Exception("No hay suficiente stock para la cantidad solicitada.");
                }
                
                $item['cantidad'] = $nuevaCantidad;
                $itemExistente = true;
                break;
            }
        }
        
        if (!$itemExistente) {
            $carrito['items'][] = [
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'talla' => $talla,
                'fecha_agregado' => $fechaActual
            ];
        }
        
        // Actualizar carrito en la base de datos
        $bd->carritos->updateOne(
            ['_id' => $carrito['_id']],
            ['$set' => [
                'items' => $carrito['items'],
                'fecha_actualizacion' => $fechaActual
            ]]
        );
    }
    
    // Actualizar inventario
    $bd->playeras->updateOne(
        ['_id' => $productoId],
        ['$inc' => ['cantidad' => -$cantidad]]
    );
    
    // Limpiar sesión y redirigir
    unset($_SESSION['add_to_cart']);
    $_SESSION['exito'] = "¡Producto agregado al carrito!";
    header("Location: carrito.php");
    exit;

} catch (Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header("Location: producto.php?id=" . $_SESSION['add_to_cart']['producto_id']);
    exit;
}