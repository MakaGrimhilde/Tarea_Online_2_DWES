<?php

    $errores = [];

    $nombre = "";
    $apellidos = "";
    $email = "";
    $passwd = "";
    $cajatexto = "";

    function mensajeError($errores, $campo){

        $alert = "";

        if (isset($errores[$campo]) && !empty($campo)){

            $alert = '<div class="alert alert-danger">'.$errores[$campo].'</div>';

        }

        return $alert;

    }

    function validar($errores){

        if (isset($_POST["boton"]) && count($errores) == 0){

            return '<div class="alert alert-success">Formulario validado correctamente</div>';
        }

    }

    function filtrar($dato){

        $dato = trim($dato); 
        $dato = stripslashes($dato); 
        $dato = htmlspecialchars($dato); 
        
        return $dato;

    }

    function mostrarDatos(){

        global $nombre;
        global $apellidos;
        global $email;
        global $passwd;
        global $cajatexto;
        $imagen = $_FILES["imagen"]["tmp_name"];

        echo "<div class=\"col-sm-8\">";
            echo "<table class=\"table table-striped table-warning table-sm text-center\" border=2>";
            echo "<tr>";
                echo "<th>Nombre</th>";
                echo "<th>Apellidos</th>";
                echo "<th>Email</th>";
                echo "<th>Contraseña</th>";
                echo "<th>Biografía</th>";
                echo "<th>Imagen</th>";
            echo "</tr>";
                echo "<td>{$nombre}</td>";
                echo "<td>{$apellidos}</td>";
                echo "<td>{$email}</td>";
                echo "<td>{$passwd}</td>";
                echo "<td>{$cajatexto}</td>";
                echo "<td>{$imagen}</td>";
            echo "</table>";
        echo "</div>";
    }

    if(isset($_POST["boton"])){

        if (!empty($_POST["nombre"]) && strlen($_POST["nombre"]) <= 20 && !preg_match("/[0-9]/", $_POST["nombre"])
        && !is_numeric($_POST["nombre"])){

            $nombre = filtrar($_POST["nombre"]);
            $nombre = filter_var($nombre, FILTER_SANITIZE_STRING);
           

        } else { //de lo contrario, se mostrará el siguiente mensaje de error

            $errores["nombre"] = "El nombre solo puede estar formado por letras y tener una longitud
            máxima de 20 caracteres";

        }

        if (!empty($_POST["apellidos"]) && !preg_match("/[0-9]/", $_POST["apellidos"]) && 
        !is_numeric($_POST["apellidos"])){

            $apellidos = filtrar($_POST["apellidos"]);
            $apellidos = filter_var($apellidos, FILTER_SANITIZE_STRING);
            

        } else { //de lo contrario, se mostrará el siguiente mensaje de error

            $errores["apellidos"] = "El apellido solo puede estar formado por letras";
        }

        if (!empty($_POST["email"]) && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){

            $email = filtrar($_POST["email"]);
            $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
            

        } else { //de lo contrario, se mostrará el siguiente mensaje de error

            $errores["email"] = "El email tiene que ser válido";

        }

        if (!empty($_POST["password"]) && strlen($_POST["password"]) >= 6){

            $passwd = sha1($_POST["password"])."<br/>";

        } else { //de lo contrario, se mostrará el siguiente mensaje de error

            $errores["password"] = "La contraseña debe tener una longitud mayor que 6 caracteres";
           
        }

        if (strlen(trim($_POST["cajatexto"]))){

            $cajatexto = filtrar($_POST["cajatexto"]);
            

        } else { //de lo contrario, se mostrará el siguiente mensaje de error
             
            $errores["cajatexto"] = "Este campo no puede estar vacío";            
        }

        if (!isset($_FILES["imagen"]) || empty($_FILES["imagen"]["tmp_name"])){

            $errores["imagen"] = "Seleccione una imagen válida";

        }
    }

?>