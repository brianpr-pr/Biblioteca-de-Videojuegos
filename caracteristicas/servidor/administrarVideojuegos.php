<?php
function mostrarVideojuegos(){
    try{
        $result = "";
        require "./caracteristicas/servidor/datos_servidor.php";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("SELECT titulo_clave, titulo, fecha, url FROM videojuegos");
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $result = "{$result}
            <tr>
                <td><a href='vista_detalles_videojuego.php?titulo_clave={$row['titulo_clave']}'><img style='width:125px;height:125px;' src='{$row['url']}'></a></td>
                <td><a href='vista_detalles_videojuego.php?titulo_clave={$row['titulo_clave']}'>{$row['titulo']}</a></td>
                <td><a href='vista_detalles_videojuego.php?titulo_clave={$row['titulo_clave']}'>{$row['fecha']}</a></td>
            </tr>";
        }
        $conn = null;
        return $result;

    } catch(PDOException $e){
        echo "<br>" . $e->getMessage();
    }
    $conn = null;
}

function mostrarVideojuegosBuscador($titulo){
    try{
        $result = "";
        include "./caracteristicas/servidor/datos_servidor.php";
        include "./../servidor/datos_servidor.php";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("SELECT titulo_clave, titulo, fecha, url FROM videojuegos 
        WHERE titulo LIKE :titulo");
        $stmt->execute(["titulo" => "$titulo%"]);
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $result = "{$result}
            <tr>
                <td><a href='vista_detalles_videojuego.php?titulo_clave={$row['titulo_clave']}'><img style='width:125px;height:125px;' src='{$row['url']}'></a></td>
                <td><a href='vista_detalles_videojuego.php?titulo_clave={$row['titulo_clave']}'>{$row['titulo']}</a></td>
                <td><a href='vista_detalles_videojuego.php?titulo_clave={$row['titulo_clave']}'>{$row['fecha']}</a></td>
            </tr>";
        }
        $conn = null;
        return $result;

    } catch(PDOException $e){
        echo "<br>" . $e->getMessage();
    }
    $conn = null;
}


function mostrarDetallesVideojuego($tituloClave){
    $resultado = "";
    if($datos = videojuegoDatos($tituloClave)){
        $resultado = 
        "<div>
            <div>
                <img src='{$datos['url']}'>
            </div>
            <div>
                <h2>{$datos['titulo']}</h2>
                <div>
                    <ul>
                        <li>Año: {$datos['fecha']}</li>
                        <li>Autor: {$datos['autor']}</li>
                        <li>Categoría: {$datos['categoria_clave']}</li>
                        <li>Subido por: {$datos['nombre_usuario']}</li>
                    </ul>
                </div>
                <h4>{$datos['descripcion']}</h4>
            </div>
        </div>";
        
        if($datos['nombre_usuario'] === $_SESSION['nombre_usuario']){
            $resultado = "{$resultado}
            <div>
                <form method='POST'>
                    <button name='eliminar' value='true'>Eliminar</button>
                </form>
                <br><br>
                <form method='GET' action='./editar_videojuego.php'>
                    <button name='titulo_clave' value='{$datos['titulo_clave']}'>Editar</button>
                </form>
                <br><br>
            </div>";
        }

        return $resultado;
    }
    return false;
}

function videojuegoDatos($tituloClave){
    try{
        //Esto puede que cause algún bug:
        include "./caracteristicas/servidor/datos_servidor.php";
        include "./../servidor/datos_servidor.php";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("SELECT * FROM videojuegos WHERE titulo_clave=:tituloClave");
        $stmt->execute(["tituloClave" => $tituloClave]);
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $conn = null;
            return $row;
        }
    } catch(PDOException $e){
        echo "<br>" . $e->getMessage();
    }
    $conn = null;
    return null;
}

function eliminarVideojuego($tituloClave){
    try{
        require "./caracteristicas/servidor/datos_servidor.php";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("delete FROM videojuegos WHERE titulo_clave=:tituloClave");
        $stmt->execute(["tituloClave" => $tituloClave]);
    } catch(PDOException $e){
        echo "<br>" . $e->getMessage();
    }
    $conn = null;
}


function mostrarCategorias(){
    try{
        require "./caracteristicas/servidor/datos_servidor.php";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("SELECT categoria_clave FROM categorias");
        $stmt->execute();
        $resultado = '';

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $resultado = "{$resultado}<option>{$row['categoria_clave']}</option>";
        }
        $conn = null;
        return $resultado;
    } catch(PDOException $e){
        echo "<br>" . $e->getMessage();
    }
    $conn = null;
}

function modificarVideojuego(){
    try{
        require "./caracteristicas/servidor/datos_servidor.php";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        
        $stmt = $conn->prepare("
            UPDATE videojuegos SET
            titulo_clave=:titulo_clave, 
            titulo=:titulo,
            descripcion=:descripcion,
            autor=:autor,
            caratula=:caratula,
            categoria_clave=:categoria_clave,
            url=:url,
            fecha=:fecha
            WHERE titulo_clave = :titulo_clave
            AND nombre_usuario=:nombre_usuario
        ");

        $tituloClave = $_SESSION['nombre_usuario'] . "_" . $_POST['titulo'];
        
        $stmt->execute([
            "titulo_clave" => $tituloClave,
            "titulo" => $_POST['titulo'],
            "descripcion" => $_POST['descripcion'],
            "autor" => $_POST['autor'],
            "caratula" => $_POST['caratula'],
            "categoria_clave" => $_POST['categoria'],
            "url" => $_POST['url'],
            "fecha" => $_POST['fecha'],
            "titulo_clave" => $_POST['titulo_modificar'],
            "nombre_usuario" => $_SESSION['nombre_usuario']
        ]);

        $conn = null;
    } catch(PDOException $e){
        echo "<Mensaje de error:>" . $e->getMessage();
    }
    $conn = null;
    return false;
}





function añadirVideojuego(){
try{
        require "./caracteristicas/servidor/datos_servidor.php";

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        
/*
$stmt = $conn->prepare("
            INSERT INTO videojuegos VALUES
            (titulo_clave=:titulo_clave,
            titulo=:titulo,
            descripcion=:descripcion,
            autor=:autor,
            caratula=:caratula,
            categoria_clave=:categoria_clave,
            url=:url,
            fecha=:fecha
        )");
*/


        $stmt = $conn->prepare("
            INSERT INTO videojuegos (
            titulo_clave, titulo, descripcion, autor, caratula,
            categoria_clave, url, fecha, nombre_usuario
            )
            VALUES
            (:titulo_clave,
            :titulo,
            :descripcion,
            :autor,
            :caratula,
            :categoria_clave,
            :url,
            :fecha,
            :nombre_usuario
        )");

        $tituloClave = $_SESSION['nombre_usuario'] . "_" . $_POST['titulo'];
        
        $stmt->execute([
            "titulo_clave" => $tituloClave,
            "titulo" => $_POST['titulo'],
            "descripcion" => $_POST['descripcion'],
            "autor" => $_POST['autor'],
            "caratula" => $_POST['caratula'],
            "categoria_clave" => $_POST['categoria'],
            "url" => $_POST['url'],
            "fecha" => $_POST['fecha'],
            "nombre_usuario" => $_SESSION['nombre_usuario']
        ]);

        $conn = null;
    } catch(PDOException $e){
        echo "<Mensaje de error:>" . $e->getMessage();
    }
    $conn = null;
    return false;


}



function sumarVisitas($tituloClave){
    try{
        include "./caracteristicas/servidor/datos_servidor.php";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("
            UPDATE videojuegos SET
            numero_visitas = numero_visitas + 1
            WHERE titulo_clave=:titulo_clave
        ");
        
        $stmt->execute([
            "titulo_clave" => $tituloClave]);
        $conn = null;
    } catch(PDOException $e){
        echo "<Mensaje de error:>" . $e->getMessage();
    }
    $conn = null;
    return false;
}

function mostrarNumeroVisitas($tituloClave){
    try{
        include "./caracteristicas/servidor/datos_servidor.php";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("
            select numero_visitas from videojuegos
            WHERE titulo_clave=:titulo_clave
        ");
        
        $stmt->execute(["titulo_clave" => $tituloClave]);
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            return $row['numero_visitas'];
        }
        $conn = null;
        return 0;
    } catch(PDOException $e){
        echo "<Mensaje de error:>" . $e->getMessage();
    }
    $conn = null;
    return false;
}