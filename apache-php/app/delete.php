<?php
require 'db.php';

$id = (int)$_GET['id'];
$coleccion->deleteOne(['id' => $id]);
header("Location: index.php");
exit();
