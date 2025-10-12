<?php
function tituloValidacion($titulo,$nombreUsuario){
$estado = true;
    if(strlen($titulo) < 1 || strlen($titulo) > 40){
        $estado = false;
    }

    if(!preg_match('/^([a-zA-Z0-9._]){1,40}+$/', $titulo)){
        $estado = false;
    }

    if($estado){
        try {
            include "./caracteristicas/servidor/datos_servidor.php";
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Preparacion sentencias SQL
            $stmt = $conn->prepare("SELECT titulo_clave FROM videojuegos WHERE titulo_clave=:titulo_clave");
            $stmt->execute(["titulo_clave" => $nombreUsuario . $titulo]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                $conn = null;
                return true;
            }
        } catch(PDOException $e) {
            echo "<br>" . $e->getMessage();
        }
    }
    $conn = null;
    return false;
}