<?php

//si existe el parámetro id por el método GET y es numérico
if (isset($_GET["id"]) and is_numeric($_GET["id"])){

    $id = $_GET["id"];

    try {

        //definición de las variables necesarias para la conexión a la base de datos
        $bdHost = 'localhost';
        $bdName = 'bdusuarios';
        $bdUser = 'root';
        $bdPass = '';

        //conexión a la base de datos con PDO
        $conexion = new PDO("mysql:host=$bdHost;dbname=$bdName", $bdUser, $bdPass);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //sentencia sql que listo todo del usuario según la id en cuestión que tenga
        $sql = "SELECT * FROM usuarios WHERE id = :id;";
        $query = $conexion->prepare($sql);
        $query->execute(['id' => $id]);


    } catch (PDOException $ex){

        echo '<div class="mx-auto col-sm-4 alert alert-danger row justify-content-center">'.
        "No se han podido listar los usuarios :(".'</div>';

    }

}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta	name="viewport"	content="width=device-width,	initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="includes/estilos.css">
        <title>Listado de usuarios</title>
    </head>
    <body>
    <div class="row justify-content-center" id="cabecera">    
    <h1><img class="img" src="img/logo.png">  Tarea Online 2</h1>
    </div>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Inicio</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="tablalistar.php">Listar</a>
        </li>
    </ul>
    <br/><br/>
        <div class="row justify-content-center">
            <div class="col-sm">
                <table class="table table-striped text-center">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Contraseña</th>
                        <th>Biografía</th>
                        <th>Imagen</th>
                        <th>Operaciones</th>
                    </tr>
                    <!--bucle while que recorre toda la tabla usuarios y recoge todos los elementos contenidos en nombre,
                    apellidos, email, contrasena, biografia e imagen-->
                    <?php while($fila = $query->fetch()){ { ?> 

                    <tr>
                        <td><?=$fila["nombre"]?></td>
                        <td><?=$fila["apellidos"]?></td>
                        <td><?=$fila["email"]?></td>
                        <td><?=$fila["contrasena"]?></td>
                        <td><?=$fila["biografia"]?></td>
                        <td>

                            <?php

                                if ($fila["imagen"] != null){

                                    echo '<img src="fotos/'.$fila["imagen"].'" width="40"/>'.$fila["imagen"];

                                }
                            ?>
                        
                        </td>
                        <td><a href="./actualizar.php?id=<?=$fila["id"]?>">Editar</a>&nbsp;&nbsp;
                        <a href="./eliminar.php?id=<?=$fila["id"]?>">Eliminar</a></td>
                    </tr>

                    <?php } } ?>
                </table>
            </div>
        </div>
    </body>
</html>