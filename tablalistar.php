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
        <li class="nav-item">
            <a class="nav-link" href="pdf/print_pdf.php">Generar PDF</a>
        </li>
    </ul>
    <br/>
    <?php

        try {

            //definición de las variables necesarias para la conexión a la base de datos
            $bdHost = 'localhost';
            $bdName = 'bdusuarios';
            $bdUser = 'root';
            $bdPass = '';

            //conexión a la base de datos con PDO
            $conexion = new PDO("mysql:host=$bdHost;dbname=$bdName", $bdUser, $bdPass);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            /**
             * variables para definir el parámetro pagina pasado por GET, las filas de la tabla que aparecerán en cada página
             * y el inicio de página
             */ 
            $pagina = isset($_GET["pagina"]) ? (int) $_GET["pagina"] : 1;
            $filaporpag = 3;
            $inicio = ($pagina > 1) ? ($pagina * $filaporpag - $filaporpag) : 0;

            //sentencia sql para listar las filas existentes en la tabla usuarios y el número de filas por pág que mostrará
            $sql = "SELECT SQL_CALC_FOUND_ROWS id, nombre, apellidos, email, imagen FROM usuarios LIMIT $inicio, $filaporpag;";

            //preparación y ejecución de la sentencia sql previamente definida
            $query = $conexion->prepare($sql);
            $query->setFetchMode(PDO::FETCH_ASSOC); 
            $query->execute();
            $resultado = $query->fetchAll();

            if (!$resultado){ 

                header('Location:tablalistar.php');
            }

            //variable que recoge el número total de elementos de la tabla usuarios
            $totalFilas = $conexion->query('SELECT FOUND_ROWS() as total;');
            $totalFilas = $totalFilas->fetch()['total'];

            //variable para el número de páginas según el nº de elementos de la tabla y el número de filas por página
            $numPagina = ceil($totalFilas / $filaporpag); 

            if ($query){

                echo '<div class="mx-auto col-sm-4 alert alert-success row justify-content-center">'.
                "Se han listado los usuarios correctamente :)".'</div>';
            }

        } catch (PDOException $ex){

            echo '<div class="mx-auto col-sm-4 alert alert-danger row justify-content-center">'.
            "No se han podido listar los usuarios :(".'</div>';

        }

    ?>
    <br/><br/>
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <table class="table table-striped text-center">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Imagen</th>
                        <th>Operaciones</th>
                    </tr>
                    <!--bucle foreach que recorre toda la tabla y recoge los elementos que se encuentren en nombre, 
                    apellidos, email e imagen-->
                    <?php foreach($resultado as $re){ { ?> 

                    <tr>
                        <td><?=$re["nombre"]?></td>
                        <td><?=$re["apellidos"]?></td>
                        <td><?=$re["email"]?></td>
                        <td>
                            <?php
                                if ($re["imagen"] != null){

                                    echo '<img src="fotos/'.$re["imagen"].'" width="40"/>'.$re["imagen"];

                                }
                            ?>
                        </td>
                        <td><a href="./actualizar.php?id=<?=$re["id"]?>">Editar</a>&nbsp;&nbsp;
                        <a href="./eliminar.php?id=<?=$re["id"]?>">Eliminar</a>&nbsp;&nbsp;
                        <a href="./tabladetalle.php?id=<?=$re["id"]?>">Detalle</a>
                        </td>
                    </tr>

                    <?php } } ?>
                </table>
            </div>
        </div>
        <?php include 'paginacion.php';?>
    </body>
</html>