<?php
function usuarioPuedeVotar($nombreUsuario, $tituloClave,){
    try{
        //Esto puede que cause algún bug:
        include "./../servidor/datos_servidor.php";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("SELECT * FROM votos WHERE titulo_clave=:titulo_clave 
        AND nombre_usuario=:nombre_usuario");
        $stmt->execute(["titulo_clave" => $tituloClave, "nombre_usuario" => $nombreUsuario]);
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $conn = null;
            return false;
        }
    } catch(PDOException $e){
        echo "<br>" . $e->getMessage();
    }
    $conn = null;
    return true;
}

function añadirVoto($nombreUsuario, $tituloClave, $votoValor){
    try{
        //Esto puede que cause algún bug:
        include "./../servidor/datos_servidor.php";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("INSERT INTO votos (titulo_clave, nombre_usuario, voto) VALUES(
        :titulo_clave,:nombre_usuario,:voto)");
        $stmt->execute(["titulo_clave" => $tituloClave, "nombre_usuario" => $nombreUsuario, "voto" => $votoValor]);
    } catch(PDOException $e){
        echo "<br>" . $e->getMessage();
        $conn = null;
        return false;
    }
    $conn = null;
    return true;
}