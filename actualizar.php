<html lang="es">
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
        <title>Actualizar Usuario</title>
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
    <br/>
        <?php
        
            $valorNombre = "";
            $valorApellidos = "";
            $valorEmail = "";
            $valorImagen = "";
            
            if (isset($_POST["boton"])){
            
                $id = $_POST["id"];
            
                $nombreNuevo = $_POST["nombre"];
                $apellidosNuevo = $_POST["apellidos"];
                $emailNuevo = $_POST["email"];
                $imagenNueva = "";

                $imagen = NULL;

                if (isset($_FILES["imagen"]) and (!empty($_FILES["imagen"]["tmp_name"]))){

                    if (!is_dir("fotos")){
    
                        $carpeta = mkdir("fotos", 0777, true);
    
                    } else {
    
                        $carpeta = true;
                    }
    
                    if ($carpeta){
    
                        $nombreImagen= time()."-".$_FILES["imagen"]["name"];
    
                        $moverImagen = move_uploaded_file($_FILES["imagen"]["tmp_name"], "fotos/".$nombreImagen);
    
                        $imagen = $nombreImagen;
    
                        if ($moverImagen){
    
                            $imgCargada = true;
    
                        } else {
    
                            $imgCargada = false;
    
                            $errores["imagen"] = "Error: La imagen no se cargó correctamente :(";
                        }
    
                    }
                }

                $imagenNueva = $imagen;
            
                try { 
            
                    //definición de las variables necesarias para la conexión a la base de datos
                    $bdHost = 'localhost';
                    $bdName = 'bdusuarios';
                    $bdUser = 'root';
                    $bdPass = '';
                    
                    //conexión a la base de datos con PDO
                    $conexion = new PDO("mysql:host=$bdHost;dbname=$bdName", $bdUser, $bdPass);
                    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                    //instrucción sql para actualizar usuarios
                    $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, imagen = :imagen WHERE id= :id;";
                    $query = $conexion->prepare($sql);
                    $query->execute(['id' => $id, 'nombre' => $nombreNuevo, 'apellidos' => $apellidosNuevo, 'email' => $emailNuevo, 
                    'imagen' => $imagenNueva]);
            
                    if ($query){
            
                        echo '<div class="mx-auto col-sm-4 alert alert-success row justify-content-center">'.
                        "El usuario se actualizó correctamente :)".'</div>';
                    }
                
                
                }catch (PDOException $ex){ //en caso de error en la inserción se mostraría el siguiente mensaje
                
                    echo '<div class="alert alert-danger">'."El usuario no pudo actualizarse! :(".'</div>';
                
                }
            
                $valorNombre = $nombreNuevo;
                $valorApellidos = $apellidosNuevo;
                $valorEmail = $emailNuevo;
                $valorImagen = $imagenNueva;
            
            } 
            
            if(isset($_GET["id"]) && (is_numeric($_GET["id"]))){ 

                $id= $_GET["id"];
                
                try{ 
            
                    //definición de las variables necesarias para la conexión a la base de datos
                    $bdHost = 'localhost';
                    $bdName = 'bdusuarios';
                    $bdUser = 'root';
                    $bdPass = '';
                    
                    //conexión a la base de datos con PDO
                    $conexion = new PDO("mysql:host=$bdHost;dbname=$bdName", $bdUser, $bdPass);
                    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
                    $sql= "SELECT * FROM usuarios WHERE id=:id;";
                    $query= $conexion->prepare($sql);
                    $query->execute(['id'=> $id]);

                    //Si se ejecuta la consulta correctamente
                    if ($query){
                        echo '<div class="mx-auto col-sm-4 alert alert-success row justify-content-center">'. 
                        "Los datos del usuario se obtuvieron correctamente! :)".'</div>';
                        $fila= $query->fetch(PDO::FETCH_ASSOC);
                        // Obtenemos los valores para mostrarlos en los campos del formulario
                        $valorNombre = $fila["nombre"];
                        $valorApellidos = $fila["apellidos"];
                        $valorEmail = $fila["email"];
                        $valorImagen = $fila["imagen"];
                        
                    }

                }catch(PDOException $ex){
                    
                    echo '<div class="alert alert-success">'. 
                    "No se pudieron obtener los datos de usuario :(".'</div>';
                    
                } 
            } 
            
        ?>

    <div class="row justify-content-center">
            <!--Comienzo de la estructura del formulario. Los datos recogidos por el método POST serán recibidos en ejer_26.php-->    
            <form class="form-horizontal" method="POST" action="actualizar.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm">
                        <!--cuadro de texto para recoger el nombre-->
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $valorNombre;?>"/>  
                    </div>
                    <div class="col-sm">
                        <!--cuadro de texto para recoger los apellidos-->
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $valorApellidos;?>"/>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm">
                        <!--cuadro de texto para recoger la dirección email-->
                        <label for="email">Email</label>
                        <input type="text" class="form-control" placeholder="Ej: elmotivao@gmail.com" id="email" name="email"
                        value="<?php echo $valorEmail;?>"/>
                    </div>
                </div>
                <br/>
                    <?php 
                    
                    if ($valorImagen != null){ ?>
                    <img src="fotos/<?php echo $valorImagen; ?>" width="60"/></br>
                    <?php } 
                    
                    ?>
                <br/>
                <div class="form-group">
                    <!--cuadro de tipo archivo para recoger la imagen que seleccione el usuario-->
                    <input type="file" class="form-control-file" id="imagen" name="imagen"/>
                </div>
                <br/>
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <!--botones para enviar los datos recogidos en el formulario y para limpiar los campos-->
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-primary" name="boton">Actualizar</button>
                    <button type="reset" class="btn btn-primary">Limpiar</button>
                </div>
            </form> <!--Fin del formulario-->
        </div>
    </body>
</html> 