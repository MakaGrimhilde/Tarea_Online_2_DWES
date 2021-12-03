<?php

//si se ha pulsado el botón de enviar y no existen errores en los campos del formulario
if(isset($_POST["boton"]) and count($errores) == 0){

        try { 

            //definición de las variables necesarias para la conexión a la base de datos
            $bdHost = 'localhost';
            $bdName = 'bdusuarios';
            $bdUser = 'root';
            $bdPass = '';
            
            //conexión a la base de datos con PDO
            $conexion = new PDO("mysql:host=$bdHost;dbname=$bdName", $bdUser, $bdPass);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //variables que almacenan los valores recogidos de los campos del formulario
            $nombre = $_POST["nombre"];
            $apellidos = $_POST["apellidos"];
            $email = $_POST["email"];
            $passwd = sha1($_POST["password"]);
            $cajatexto = $_POST["cajatexto"];
            $imagen = $_FILES["imagen"]["tmp_name"];

            //si existe un archivo tipo imagen y no está vacío el campo
            if (isset($_FILES["imagen"]) and (!empty($_FILES["imagen"]["tmp_name"]))){

                if (!is_dir("fotos")){ //si no existe un directorio llamado 'fotos', lo creará

                    $carpeta = mkdir("fotos", 0777, true);

                } else {

                    $carpeta = true;
                }

                if ($carpeta){ //si está el directorio fotos, la imagen se moverá a dicho directorio

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

            //inserción en las columnas de la tabla usuarios de los datos de usuario recogidos en el formulario
            $sql = "INSERT INTO usuarios VALUES(NULL, :nombre, :apellidos, :email, :password, :bio, :imagen);";
            $query = $conexion->prepare($sql);
            $query->execute(['nombre' => $nombre,'apellidos' => $apellidos,'email' => $email,'password' => $passwd,
                               'bio' => $cajatexto,'imagen' => $imagen]);

            /**
             * si el insert se ha realizado correctamente mostrará el siguiente mensaje y se ejecutará la sentencia 
             * sql de inserción en la tabla logs
             */
            if ($query){

                echo '<div class="mx-auto col-sm-4 alert alert-success row justify-content-center">'.
                "El usuario se registró correctamente :)".'</div>';

                //variables para el tipo de operación y fecha de la operación para insertar sus valores en la tabla 'logs'
                $operacion = "Insertar usuario";
                $fecha = date('Y-m-d H:i:s');
                
                //sentencia sql para la inserción de los datos en la tabla logs
                $sql = "INSERT INTO logs VALUES(NULL, :operacion, :fecha);";
                $query = $conexion->prepare($sql);
                $query->execute(['operacion' => $operacion,'fecha' => $fecha]);


            }

        }catch (PDOException $ex){ //en caso de error en la inserción se mostraría el siguiente mensaje

            echo '<div class="mx-auto col-sm-4 alert alert-danger row justify-content-center">'.
            "El usuario no pudo registrarse :(".'</div>';

        }
    
}

?>