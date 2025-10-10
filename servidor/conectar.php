<?php
include "./modulos/datos_servidor.php";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn = null;
} catch(PDOException $e) {
  echo "<h2>Base de datos no encontrada, creación en proceso.</h2><br>";
  require_once 'crear_base_datos.php';
  require_once 'insertar_categorias.php';
  require_once 'insertar_usuarios.php';
  require_once 'insertar_videojuegos.php';
}