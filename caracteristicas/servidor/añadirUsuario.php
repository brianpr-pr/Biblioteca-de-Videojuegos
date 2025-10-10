<?php

function añadirUsuario($nombreUsuario,$emailUsuario, $contraseñaUsuario){
include "./caracteristicas/servidor/datos_servidor.php";

try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", 
        $username, 
        $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, email, passwrd)
        VALUES (:nombre_usuario, :email, :passwrd)");
        $stmt->bindParam(':nombre_usuario', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':passwrd', $passwrd);

        // insert a row
        $nombre = $nombreUsuario;
        $email = $emailUsuario;
        $passwrd = password_hash($contraseñaUsuario, PASSWORD_DEFAULT);
        $stmt->execute();
        header("Location: ./inicio_sesion.php");
    } catch(PDOException $e) {
        echo "{$e->getMessage()}<br>{$errorMensaje}";
    }
}