<?php

    $errores = []; //array que recogerá los errores que puedan darse en la recogida de datos del formulario

    //variables para los campos del formulario
    $nombre = "";
    $apellidos = "";
    $email = "";
    $passwd = "";
    $cajatexto = "";

    /**
     * función que muestra un mensaje de error en función de si el array errores recoge algún error
     * en alguno de los campos
     *
     * @param string $errores
     * @param string $campo
     * @return string $alert que mostrará el error en cuestión
     */
    function mensajeError($errores, $campo){

        $alert = "";

        if (isset($errores[$campo]) && !empty($campo)){

            $alert = '<div class="alert alert-danger">'.$errores[$campo].'</div>';

        }

        return $alert;

    }

    /**
     * función que muestra un mensaje informando de que el formulario se ha validado correctamente si el array
     * errores está vacío
     *
     * @param string $errores
     * @return string 
     */
    function validar($errores){

        if (isset($_POST["boton"]) && count($errores) == 0){

            return '<div class="alert alert-success">Formulario validado correctamente</div>';
        }

    }

    /**
     * función que filtra los valores introducidos en los campos del formulario
     *
     * @param string $dato
     * @return string $dato 
     */
    function filtrar($dato){

        $dato = trim($dato); 
        $dato = stripslashes($dato); 
        $dato = htmlspecialchars($dato); 
        
        return $dato;

    }


    if(isset($_POST["boton"])){ //si existe el botón 

        //si el campo no está vacío y cumple los criterios de validación para el formulario
        if (!empty($_POST["nombre"]) && strlen($_POST["nombre"]) <= 20 && !preg_match("/[0-9]/", $_POST["nombre"])
        && !is_numeric($_POST["nombre"])){

            //se filtran y sanitizan los valores introducidos
            $nombre = filtrar($_POST["nombre"]);
            $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
           

        } else { //de lo contrario, se mostrará el siguiente mensaje de error

            $errores["nombre"] = "El nombre solo puede estar formado por letras y tener una longitud
            máxima de 20 caracteres";

        }

        //si el campo no está vacío y cumple los criterios de validación para el formulario
        if (!empty($_POST["apellidos"]) && !preg_match("/[0-9]/", $_POST["apellidos"]) && 
        !is_numeric($_POST["apellidos"])){

             //se filtran y sanitizan los valores introducidos
            $apellidos = filtrar($_POST["apellidos"]);
            $apellidos = filter_var($apellidos, FILTER_SANITIZE_STRING);
            

        } else { //de lo contrario, se mostrará el siguiente mensaje de error

            $errores["apellidos"] = "El apellido solo puede estar formado por letras";
        }

        //si el campo no está vacío y cumple los criterios de validación para el formulario
        if (!empty($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){

             //se filtran y sanitizan los valores introducidos
            $email = filtrar($_POST["email"]);
            $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
            

        } else { //de lo contrario, se mostrará el siguiente mensaje de error

            $errores["email"] = "El email tiene que ser válido";

        }

        //si el campo no está vacío y cumple los criterios de validación para el formulario
        if (!empty($_POST["password"]) && strlen($_POST["password"]) >= 6){

            $passwd = sha1($_POST["password"])."<br/>";

        } else { //de lo contrario, se mostrará el siguiente mensaje de error

            $errores["password"] = "La contraseña debe tener una longitud mayor que 6 caracteres";
           
        }

        //si el campo no está vacío y cumple los criterios de validación para el formulario
        if (strlen(trim($_POST["cajatexto"]))){

             //se filtran los valores introducidos
            $cajatexto = filtrar($_POST["cajatexto"]);
            

        } else { //de lo contrario, se mostrará el siguiente mensaje de error
             
            $errores["cajatexto"] = "Este campo no puede estar vacío";            
        }

        //si el campo no está vacío y cumple los criterios de validación para el formulario
        if (!isset($_FILES["imagen"]) || empty($_FILES["imagen"]["tmp_name"])){

            $errores["imagen"] = "Seleccione una imagen válida";

        }
    }

?>