<?php 

$id = $_GET["id"];

if (isset($_GET["id"]) and is_numeric($_GET["id"])){ //si existe un id y es numérico

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

            //variables para el tipo de operación y fecha de la operación para insertar sus valores en la tabla 'logs'
            $operacion = "Eliminar usuario";
            $fecha = date('Y-m-d H:i:s');
            
            //sentencia sql para la inserción de los datos en la tabla logs
            $sql = "INSERT INTO logs VALUES(NULL, :operacion, :fecha);";
            $query = $conexion->prepare($sql);
            $query->execute(['operacion' => $operacion,'fecha' => $fecha]);

            header("Location:tablalistar.php");

        }

    } catch (PDOException $ex){

        echo '<div class="alert alert-danger">'."El usuario no pudo eliminarse! :(".'</div>';
    }

}

?>