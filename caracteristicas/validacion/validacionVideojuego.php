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

function autorValidacion($autor){
$estado = true;
    if(strlen($autor) < 1 || strlen($autor) > 35){
        $estado = false;
    }

    if(!preg_match('/^([a-zA-Z0-9]){1,35}+$/', $autor)){
        $estado = false;
    }

    return $estado;
}


function descripcionValidacion($descripcion){
$estado = true;
if(strlen($descripcion) < 3 || strlen($descripcion) > 100){
    $estado = false;
}

if(!preg_match('/^([a-zA-Z0-9._ ]){3,100}+$/', $descripcion)){
    $estado = false;
}
return $estado;
}

function categoriaValidacion($categoria){
    try {
        include "./caracteristicas/servidor/datos_servidor.php";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Preparacion sentencias SQL
        $stmt = $conn->prepare("SELECT categoria_clave FROM categorias WHERE categoria_clave=:categoria");
        $stmt->execute(["categoria" => $categoria]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            $conn = null;
            return true;
        }
    } catch(PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
    
    $conn = null;
    return false;
}

function fechaValidacion($fecha){
    if ($fecha) {
        $d = DateTime::createFromFormat('Y-m-d', $fecha);
        if($d){
            return $d->format('Y-m-d') === $fecha;
        }
    }
    return false;
}



function caratulaValidacion($caratula){
$estado = true;
    if(strlen($caratula) > 45){
        $estado = false;
    }

    if(!preg_match('/^([a-zA-Z0-9._ ]){0,45}+$/', $caratula)){
        $estado = false;
    }

    return $estado;
}