<?php
// test-mongo.php  -- ELIMÍNALO cuando termines las pruebas

header('Content-Type: text/plain; charset=utf-8');

echo "=== PHP / Entorno ===\n";
echo "PHP version: " . phpversion() . "\n";
echo "Mongo extension loaded: " . (extension_loaded('mongodb') ? "YES" : "NO") . "\n";
echo "OpenSSL version (PHP constant): " . (defined('OPENSSL_VERSION_TEXT') ? OPENSSL_VERSION_TEXT : 'N/A') . "\n";
echo "OpenSSL extension loaded: " . (extension_loaded('openssl') ? "YES" : "NO") . "\n\n";

echo "=== CA certificates ===\n";
$ca_paths = [
    '/etc/ssl/certs/ca-certificates.crt',
    '/etc/ssl/certs',
    '/etc/pki/tls/certs/ca-bundle.crt',
    '/etc/ssl/cert.pem'
];
foreach ($ca_paths as $p) {
    echo $p . " : " . (file_exists($p) ? "EXISTS" : "MISSING") . "\n";
}
echo "\n";

// Mostrar fecha/hora del contenedor (útil para problemas de validez de certificados)
echo "Server date: " . date('c') . "\n\n";

echo "=== Probar conexión al MongoDB Atlas (URI desde MONGO_URI env) ===\n";
$uri = getenv('MONGO_URI') ?: '';
if (!$uri) {
    echo "MONGO_URI no está definido en el entorno.\n";
    exit;
}
echo "Usando MONGO_URI (oculto): startsWith 'mongodb'?: " . (strpos($uri, 'mongodb') === 0 ? "SI" : "NO") . "\n\n";

require 'vendor/autoload.php';

function tryConnect($uri) {
    try {
        $client = new MongoDB\Client($uri);
        $dbs = $client->listDatabases();
        echo "Conexión OK. Bases encontradas:\n";
        foreach ($dbs as $db) {
            echo " - " . $db['name'] . "\n";
        }
    } catch (Exception $e) {
        echo "ERROR al conectar: " . get_class($e) . " : " . $e->getMessage() . "\n";
    }
}

// Intento 1: conexión normal (la que usas)
echo "--- Intento A: conexión normal ---\n";
tryConnect($uri);
echo "\n";

// Intento 2: forzar ignorar verificación TLS (solo para diagnóstico!)
echo "--- Intento B: conexión con tlsAllowInvalidCertificates=true (SOLO DIAGNÓSTICO) ---\n";
if (strpos($uri, '?') !== false) {
    $uri2 = $uri . '&tlsAllowInvalidCertificates=true';
} else {
    $uri2 = $uri . '?tlsAllowInvalidCertificates=true';
}
tryConnect($uri2);
echo "\n";

echo "=== FIN ===\n";