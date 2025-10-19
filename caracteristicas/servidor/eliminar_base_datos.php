<?php

function eliminarBaseDatos(){
    try {
        include "./caracteristicas/servidor/datos_servidor.php";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", 
        $username, 
        $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("DROP DATABASE IF EXISTS biblioteca_videojuegos");
        $stmt->execute();
    } catch(PDOException $e) {
        echo "{$e->getMessage()}<br>{$errorMensaje}";
    }
}