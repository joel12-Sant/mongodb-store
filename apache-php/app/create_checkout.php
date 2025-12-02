<?php
// create_checkout.php
require 'vendor/autoload.php';
require 'db.php';
session_start();

use MongoDB\BSON\ObjectId;

// Config Stripe
\Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
$appUrl = rtrim(getenv('APP_URL') ?: 'http://localhost:8080', '/');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

try {
    $usuarioId = new ObjectId($_SESSION['usuario_id']);
    $carrito = $bd->carritos->findOne(['usuario_id' => $usuarioId]);

    if (!$carrito || empty($carrito['items'])) {
        throw new Exception("El carrito está vacío.");
    }

    // Build cart snapshot (productosCompra)
    $productosCompra = [];
    $total = 0;
    foreach ($carrito['items'] as $item) {
        $producto = $bd->playeras->findOne(['_id' => $item['producto_id']]);
        if (!$producto) continue;

        $subtotal = $producto['precio'] * $item['cantidad'];
        $total += $subtotal;

        $productosCompra[] = [
            'playera_id' => $producto['_id'],
            'nombre' => (string)$producto['nombre'],
            'talla' => $item['talla'],
            'cantidad' => (int)$item['cantidad'],
            'precio_unitario' => $producto['precio']
        ];
    }

    if (empty($productosCompra)) {
        throw new Exception("No hay productos para pagar.");
    }

    // Guardar snapshot en 'pagos_pendientes'
    $insertResult = $bd->pagos_pendientes->insertOne([
        'usuario_id' => $usuarioId,
        'productos' => $productosCompra,
        'total' => $total,
        'created_at' => new MongoDB\BSON\UTCDateTime(),
        'status' => 'pending'
    ]);
    $pendingId = (string)$insertResult->getInsertedId();

    // Crear line_items para Stripe
    $line_items = [];
    foreach ($productosCompra as $p) {
        $line_items[] = [
            'price_data' => [
                'currency' => 'usd', // cambia si usas otra moneda
                'product_data' => [
                    'name' => $p['nombre']
                ],
                'unit_amount' => intval(round($p['precio_unitario'] * 100)),
            ],
            'quantity' => $p['cantidad'],
        ];
    }

    // Crear sesión de Checkout
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => $appUrl . '/checkout-success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $appUrl . '/carrito.php',
        'metadata' => [
            'usuario_id' => (string)$_SESSION['usuario_id'],
            'pending_id' => $pendingId
        ],
    ]);

    header("Location: " . $session->url);
    exit;

} catch (Exception $e) {
    echo "Error creando la sesión de pago: " . htmlspecialchars($e->getMessage());
}
