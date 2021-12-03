<?php

 //definición de las variables necesarias para la conexión a la base de datos
 $dbHost = 'localhost';
 $dbName = 'bdusuarios';
 $dbUser = 'root';
 $dbPass = '';

 // Conexión a la base de datos con PDO
 try {
    
    $conexion = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo '<div class="mx-auto col-sm-4 alert alert-success row justify-content-center">'."Conectado a la Base de Datos de usuarios :)".'</div>';

 } catch (PDOException$ex){

    echo'<div class="mx-auto col-sm-4 alert alert-danger row justify-content-center">'."No se pudo conectar a la BD de usuarios :( <br/>"
    .$ex->getMessage().'</div>'; 

 }

?>