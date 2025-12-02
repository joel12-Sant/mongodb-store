<?php
require 'vendor/autoload.php';
require 'db.php';
session_start();

$session_id = $_GET['session_id'] ?? null;
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Pago exitoso</title></head>
<body>
<h1>Gracias — Pago completado</h1>
<p>Tu pago fue procesado. Si no ves tu compra en el historial, espera unos segundos (el webhook procesa la confirmación).</p>
<p><a href="compras.php">Ver historial de compras</a></p>
</body>
</html>
