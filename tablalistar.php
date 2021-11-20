

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
    <br/>
    <?php

        try {

            $bdHost = 'localhost';
            $bdName = 'bdusuarios';
            $bdUser = 'root';
            $bdPass = '';

            //conexión a la base de datos con PDO
            $conexion = new PDO("mysql:host=$bdHost;dbname=$bdName", $bdUser, $bdPass);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM usuarios;";
            $query = $conexion->prepare($sql);
            $resultadoquery = $conexion->query($sql);

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
            <div class="col-sm-6">
                <table class="table table-striped text-center">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Operaciones</th>
                    </tr>
                    <?php while($fila = $resultadoquery->fetch()){ { ?> 

                    <tr>
                        <td><?=$fila["nombre"]?></td>
                        <td><?=$fila["apellidos"]?></td>
                        <td><?=$fila["email"]?></td>
                        <td><a href="./actualizar.php?id=<?=$fila["id"]?>">Editar</a>&nbsp;&nbsp;
                        <a href="./eliminar.php?id=<?=$fila["id"]?>">Eliminar</a>&nbsp;&nbsp;
                        <a href="./tabladetalle.php?id=<?=$fila["id"]?>">Detalle</a>
                        </td>
                    </tr>

                    <?php } } ?>
                </table>
            </div>
        </div>
        <div class="row justify-content-center">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                    <a class="page-link" href="#!" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#!">1</a></li>
                    <li class="page-item"><a class="page-link" href="#!">2</a></li>
                    <li class="page-item"><a class="page-link" href="#!">3</a></li>
                    <li class="page-item">
                    <a class="page-link" href="#!" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                    </li>
                </ul>
            </nav>
        </div>
    </body>
</html>