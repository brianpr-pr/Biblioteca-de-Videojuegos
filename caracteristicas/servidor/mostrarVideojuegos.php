<?php
function mostrarVideojuegos(){
    try{
        $result = "";
        include "/Applications/XAMPP/xamppfiles/htdocs/aphp/biblioteca/caracteristicas/servidor/datos_servidor.php";
        $conn = new PDO("mysql:host=127.0.0.1;dbname=biblioteca_videojuegos", "root", "");
        $stmt = $conn->prepare("SELECT titulo FROM videojuegos");
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $result = 
            "<tr>
                a
            </tr>";
        }
        return $result;

    } catch(PDOException $e){
        echo "<br>" . $e->getMessage();
    }
    $conn = null;
}

echo mostrarVideojuegos();