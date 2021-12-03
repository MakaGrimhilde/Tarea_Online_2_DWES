<html>
    <head>
        <meta charset="UTF-8">
        <meta	name="viewport"	content="width=device-width,	initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="row" style="text-align:center">    
            <h1>Tarea Online 2</h1>
        </div>
        <?php

        try {

            $bdHost = 'localhost';
            $bdName = 'bdusuarios';
            $bdUser = 'root';
            $bdPass = '';

            //conexión a la base de datos con PDO
            $conexion = new PDO("mysql:host=$bdHost;dbname=$bdName", $bdUser, $bdPass);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //sentencia sql para listar todos los registros de la tabla usuarios
            $sql = "SELECT * FROM usuarios;";
            $query = $conexion->prepare($sql);
            $resultadoquery = $conexion->query($sql);


        } catch (PDOException $ex){

            echo '<div class="mx-auto col-sm-4 alert alert-danger row justify-content-center">'.
            "No se han podido listar los usuarios :(".'</div>';

        }

        ?>
        <!--Html para mostrar la tabla que recoge los registros de usuarios en el PDF-->
        <br/><br/>
            <div class="tabla justify-content-center">
                <div class="col-sm-8">
                    <table class="table table-striped text-center" style="text-center">
                        <tr>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Email</th>
                            <th>Imagen</th>
                        </tr>
                        <?php while($fila = $resultadoquery->fetch()){ { ?> 

                        <tr>
                            <td><?=$fila["nombre"]?></td>
                            <td><?=$fila["apellidos"]?></td>
                            <td><?=$fila["email"]?></td>
                            <td>
                                <?php
                                    if ($fila["imagen"] != null){

                                        echo $fila["imagen"];

                                    }
                                ?>
                            </td>
                        </tr>

                        <?php } } ?>
                    </table>
                </div>
            </div>
    </body>
</html>

<!--hoja de estilos interna para la tabla que se mostrará en el PDF-->
<style type="text/css">

    .row {

        background-color: orange;
        height: 8%;
        color: wheat; 
    }

    .table {

        justify-content: center;
        align: center;
        text-align: center;
        padding-left: 85px;
    }

    th, td {

        padding: 10px;
    }

    th {

        background-color: #f2f2f2;
    }

</style>