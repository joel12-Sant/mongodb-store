<?php
// webhook.php
require 'vendor/autoload.php';
require 'db.php';

use MongoDB\BSON\ObjectId;

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
$endpoint_secret = getenv('STRIPE_WEBHOOK_SECRET');

if (!$endpoint_secret) {
    http_response_code(500);
    echo "STRIPE_WEBHOOK_SECRET no configurado";
    exit;
}

try {
    $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
} catch(\UnexpectedValueException $e) {
    http_response_code(400); exit;
} catch(\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400); exit;
}

if ($event->type === 'checkout.session.completed') {
    $session = $event->data->object;

    $pendingId = $session->metadata->pending_id ?? null;
    $usuarioIdStr = $session->metadata->usuario_id ?? null;

    if ($pendingId && $usuarioIdStr) {
        try {
            $pendingObjId = new ObjectId($pendingId);
            $pending = $bd->pagos_pendientes->findOne(['_id' => $pendingObjId]);

            if ($pending && ($pending['status'] ?? '') === 'pending') {
                // Insertar en compras usando la snapshot
                $bd->compras->insertOne([
                    'usuario_id' => new ObjectId($usuarioIdStr),
                    'productos' => $pending['productos'],
                    'total' => $pending['total'],
                    'fecha' => new MongoDB\BSON\UTCDateTime(),
                    'stripe_payment_intent' => $session->payment_intent ?? null,
                    'stripe_amount_total' => isset($session->amount_total) ? ($session->amount_total / 100) : null,
                    'stripe_currency' => $session->currency ?? null,
                    'stripe_session_id' => $session->id
                ]);

                // Marcar pending como pagado
                $bd->pagos_pendientes->updateOne(
                    ['_id' => $pendingObjId],
                    ['$set' => ['status' => 'paid', 'paid_at' => new MongoDB\BSON\UTCDateTime()]]
                );

                // Limpiar carrito del usuario
                $bd->carritos->updateOne(['usuario_id' => new ObjectId($usuarioIdStr)], ['$set' => ['items' => []]]);
            }
        } catch (Exception $e) {
            // Logging opcional
        }
    }
}

// Responder 200 OK
http_response_code(200);
echo 'ok';
