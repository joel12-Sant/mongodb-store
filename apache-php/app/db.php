<?php
require 'vendor/autoload.php';

$cliente = new MongoDB\Client("mongodb://mongo:27017");
$coleccion = $cliente->tienda->playeras;
?>