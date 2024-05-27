<?php
$_servidor = 'localhost';
$_usuario = 'root';
$_contrasena = 'password';
$_base_de_datos = 'db_compositores';
$_puerto = 3306;

$conexion = new Mysqli($_servidor, $_usuario, $_contrasena, $_base_de_datos, $_puerto)
    or die("Error de conexion");