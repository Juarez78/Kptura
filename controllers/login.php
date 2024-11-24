<?php
include '../models/conexion.php';
include '../models/funciones.php';
include '../controllers/funciones.php';

$user = $_POST['user'];
$passw = $_POST['passw'];
AccesoLogin($user, $passw, 'usuarios');
