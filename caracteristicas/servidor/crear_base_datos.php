<?php
try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE biblioteca_videojuegos
    CHARACTER SET utf8
    COLLATE utf8_unicode_ci";
    $conn->exec($sql);

    // sentencias sql para crear base de datos y tablas
    $sentenciaUno = "USE biblioteca_videojuegos";

    $sentenciaDos = "CREATE TABLE usuarios (
    nombre_usuario varchar(35) PRIMARY KEY,
    email varchar(40) UNIQUE NOT NULL, 
    passwrd varchar(100) NOT NULL)";

    $sentenciaTres = "CREATE TABLE categorias (
    categoria_clave varchar(30) PRIMARY KEY,
    numero_juegos_per_categoria int DEFAULT 0)";

    $sentenciaCuatro = "CREATE TABLE videojuegos (
    titulo_clave varchar(75) PRIMARY KEY, 
    titulo varchar(40) NOT NULL, 
    descripcion varchar (100) NOT NULL, 
    autor varchar(35) NOT NULL,
    caratula varchar(85) NULL,
    categoria_clave varchar(30) NOT NULL,
    url varchar(125) NOT NULL,
    fecha date NOT NULL, 
    nombre_usuario varchar(35),
    FOREIGN KEY (categoria_clave) REFERENCES categorias(categoria_clave),
    FOREIGN KEY (nombre_usuario) REFERENCES usuarios(nombre_usuario))";

    $conn->exec($sentenciaUno);
    $conn->exec($sentenciaDos);
    $conn->exec($sentenciaTres);
    $conn->exec($sentenciaCuatro);
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;