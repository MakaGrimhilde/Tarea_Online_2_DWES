<?php 

$id = $_GET["id"];

if (isset($_GET["id"]) and is_numeric($_GET["id"])){

    try{

        //definición de las variables necesarias para la conexión a la base de datos
        $bdHost = 'localhost';
        $bdName = 'bdusuarios';
        $bdUser = 'root';
        $bdPass = '';
        
        //conexión a la base de datos con PDO
        $conexion = new PDO("mysql:host=$bdHost;dbname=$bdName", $bdUser, $bdPass);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //instrucción sql para eliminar registros de la tabla de la base de datos
        $sql = "DELETE FROM usuarios WHERE id = :id;";
        $query = $conexion->prepare($sql);
        $query->execute(['id' => $id]);

        if ($query){

            echo '<div class="alert alert-success">'."El usuario se eliminó correctamente :)".'</div>';
            header("Location:tablalistar.php");

        }

    } catch (PDOException $ex){

        echo '<div class="alert alert-danger">'."El usuario no pudo eliminarse! :(".'</div>';
    }

}

?>