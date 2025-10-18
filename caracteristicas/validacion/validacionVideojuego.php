<?php
function tituloValidacion($titulo,$nombreUsuario){
$estado = true;
    if(strlen($titulo) < 1 || strlen($titulo) > 40){
        $estado = false;
    }

    if(!preg_match('/^([a-zA-Z0-9._ ]){1,40}+$/', $titulo)){
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

function caratulaValidacion(){
    switch($_FILES['imagen']['error']){
        case UPLOAD_ERR_PARTIAL:
            throw new ErrorException("Archivo subido parcialmente");

        case UPLOAD_ERR_NO_FILE:
            throw new ErrorException('El archivo no fue subido correctamente');

        case UPLOAD_ERR_EXTENSION:
            throw new ErrorException('El archivo no fue subido, tiene una extension no admitida');
        
        case UPLOAD_ERR_FORM_SIZE:
            throw new ErrorException('El archivo excede el limite en tamaño impuesto en el formulario HTML (MAX_FILE_SIZE).');
        
        case UPLOAD_ERR_INI_SIZE:
            throw new ErrorException('El archivo excede el limite en tamaño impuesto en el archivo de configuración php.ini (upload_max_filesize).');
        case UPLOAD_ERR_NO_TMP_DIR:
            throw new ErrorException('Directorio temporal no encotrado.');
        case UPLOAD_ERR_CANT_WRITE:
            throw new ErrorException('Fallo al editar el archivo.');   
    }

    if($_FILES['imagen']['size'] > (1048576 * 3)){
        throw new ErrorException("Imagen es demasiado grande, máximo 3MB");
    }

    if( ! in_array($_FILES['imagen']['type'], ['image/gif', "image/png" , "image/jpeg"])){
        throw new ErrorException("Formato de imagen invalido: ". var_dump($_FILES['image']) );
    }

    $rutaLimpia = limpiarRuta($_FILES['imagen']);
    
    if(file_exists("./caratulas/" . $SESSION['nombre_usuario'] . basename($rutaLimpia) ) ){
        throw new ErrorException("Ya existe un archivo con este nombre.");
    }
    $_POST['caratula'] = basename($rutaLimpia);
    $_POST['url'] = "./caratulas/{$_SESSION['nombre_usuario']}_{$_POST['caratula']}";

    if( ! move_uploaded_file($_FILES['imagen']['tmp_name'], $_POST['url']  ) ){
        throw new ErrorException("Fallo al mover el archivo");
    }

    if(file_exists($rutaLimpia)){
        $_POST['url'] = $rutaLimpia;
    }

    return true;
}

function limpiarRuta($arrAsociativoImagen){
    $pathInfo = pathinfo($arrAsociativoImagen['name']);
    $nombreLimpio = preg_replace("/[^\w-]/", "_", $pathInfo['filename']);
    $rutaLimpia = "./caratulas/{$nombreLimpio}.{$pathInfo['extension']}" ;
    return $rutaLimpia;
}


function eliminarCaratula($ruta){
    if(file_exists($ruta)){
        unlink($ruta);
    }
}