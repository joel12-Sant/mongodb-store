<?php
require 'vendor/autoload.php';

$mongoUri = getenv('MONGO_URI') ?: 'mongodb://mongo:27017';

$cliente = new MongoDB\Client($mongoUri);
$coleccion = $cliente->tienda->playeras;
$bd = $cliente->tienda;
?>