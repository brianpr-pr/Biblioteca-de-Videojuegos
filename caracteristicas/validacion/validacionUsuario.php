<?php
function nombreUsuarioValidacion($nombreUsuario){
    $estado = true;
    if(strlen($nombreUsuario) < 3 || strlen($nombreUsuario) > 35){
        $estado = false;
    }

    if(!preg_match('/^([a-zA-Z0-9._-])+$/', $nombreUsuario)){
        $estado = false;
    }

    if($estado){
        try {
            include "./caracteristicas/servidor/datos_servidor.php";
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Preparacion sentencias SQL
            $stmt = $conn->prepare("SELECT nombre_usuario FROM usuarios WHERE nombre_usuario=:nombre_usuario");
            $stmt->execute(["nombre_usuario" => $nombreUsuario]);
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


function emailValidacion($emailUsuario){
        $resultado = true;
        
        if(!filter_var($emailUsuario, FILTER_VALIDATE_EMAIL)){
            $resultado = false;
        }

        if(strlen($emailUsuario) > 40){
            $resultado = false;
        }

        if($resultado){
            include "./caracteristicas/servidor/datos_servidor.php";
            
            try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    // Preparacion sentencias SQL
                    $stmt = $conn->prepare("SELECT email FROM usuarios WHERE email=:emailArgumento");
                    $stmt->execute(['emailArgumento' => $emailUsuario]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if(!$row){
                        $conn = null;
                        return true;
                    }
                } catch(PDOException $e) {
                    echo "<br>" . $e->getMessage();
                }
                $conn = null;
        }
        return false;
}

function contraseñaValidacion($passwordUno,$passwordDos){
    $resultado = true;
    if($passwordUno !== $passwordDos){
        $resultado = false;
    }

    if(strlen($passwordUno) < 8 || strlen($passwordUno) > 20){
        $resultado = false;
    }

    if(!preg_match('/^[A-Za-z0-9]{8,}$/', $passwordUno)){
        $resultado = false;
    }

    return $resultado;
}

function inicioSesion($emailUsuario, $contraseña){
        if(filter_var($emailUsuario, FILTER_VALIDATE_EMAIL)){
            include "./caracteristicas/servidor/datos_servidor.php";
            
            try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    // Preparacion sentencias SQL
                    $stmt = $conn->prepare("SELECT nombre_usuario, email, passwrd FROM usuarios WHERE email = :emailArgumento LIMIT 1");
                    $stmt->execute(["emailArgumento" => $emailUsuario]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($row){ 
                        if(password_verify($contraseña, $row['passwrd'])){
                            $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
                            $_SESSION['email_usuario'] = $row['email'];
                            $conn = null;
                            return true;
                        }
                    }
            } catch(PDOException $e) {
                    echo "<br>" . $e->getMessage();
            }
            $conn = null;
        }
    return false;
}


















function perfilValidacion(){
    if($_FILES['imagen']['name'] == ''){
        return true;
    }


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
        throw new ErrorException("Formato de imagen invalido:");
    }

    

    $rutaLimpia = limpiarRuta($_FILES['imagen']);

    if(file_exists("./perfil/" . $_SESSION['nombre_usuario'] . basename($rutaLimpia) ) ){
        throw new ErrorException("Ya existe un archivo con este nombre.");
    }

    
    $_POST['imagen'] = "./perfil/{$_SESSION['nombre_usuario']}_" . basename($rutaLimpia);


    if( ! move_uploaded_file($_FILES['imagen']['tmp_name'], $_POST['imagen']  ) ){
        throw new ErrorException("Fallo al mover el archivo");
    }

    if(!file_exists($_POST['imagen'])){
        throw new ErrorException("Error, el archivo no se encuentra en el directorio de destino.");
    }

    return true;
}

function limpiarRuta($arrAsociativoImagen){
    $pathInfo = pathinfo($arrAsociativoImagen['name']);
    $nombreLimpio = preg_replace("/[^\w-]/", "_", $pathInfo['filename']);
    $rutaLimpia = "./perfil/{$nombreLimpio}.{$pathInfo['extension']}" ;
    return $rutaLimpia;
}

function eliminarCaratula($ruta){
    if(file_exists($ruta)){
        unlink($ruta);
    }
}



function getDatosUsuario($nombreUsuario) {
    include './caracteristicas/servidor/datos_servidor.php';
    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("SELECT nombre_usuario, email, imagen_perfil FROM usuarios WHERE nombre_usuario=:nombre_usuario");
        $stmt->execute([':nombre_usuario' => $nombreUsuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        return false;
    }
}