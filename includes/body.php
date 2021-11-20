<div class="row justify-content-center">
    <?php include 'insertar.php'?>
</div>
<div class="row justify-content-center">
            <!--Comienzo de la estructura del formulario. Los datos recogidos por el método POST serán recibidos en ejer_26.php-->    
            <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm">
                        <!--cuadro de texto para recoger el nombre-->
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            
                            <?php
                            
                                if(isset($_POST["nombre"])){
                                    echo "value='{$_POST["nombre"]}'";
                                }

                            ?>
                        />
                        <?php  echo mensajeError($errores, "nombre");?>    
                    </div>
                    <div class="col-sm">
                        <!--cuadro de texto para recoger los apellidos-->
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos"

                            <?php
                                if(isset($_POST["apellidos"])){
                                    echo "value='{$_POST["apellidos"]}'";
                                }
                            ?>   
                        />
                        <?php  echo mensajeError($errores, "apellidos");?>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm">
                        <!--cuadro de texto para recoger la dirección email-->
                        <label for="email">Email</label>
                        <input type="text" class="form-control" placeholder="Ej: elmotivao@gmail.com" id="email" name="email"
                              
                            <?php
                                if(isset($_POST["email"])){
                                    echo "value='{$_POST["email"]}'";
                                }
                            ?>          
                        />
                        <?php  echo mensajeError($errores, "email");?>
                    </div>
                    <div class="col-sm">
                        <!--cuadro de texto para recoger la contraseña-->
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password"

                            <?php
                                if(isset($_POST["password"])){
                                    echo "value='{$_POST["password"]}'";
                                }
                            ?>  
                        />
                        <?php  echo mensajeError($errores, "password");?>  
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <!--caja de texto para recoger la biografía del usuario-->
                    <label for="cajatexto">Biografía</label>
                    <textarea class="form-control" id="cajatexto" name="cajatexto">

                        <?php
                            if(isset($_POST["cajatexto"])){
                                echo $_POST["cajatexto"];
                            }
                        ?>              

                    </textarea>
                    <?php  echo mensajeError($errores, "cajatexto");?>
                </div>
                <br/>
                <div class="form-group">
                    <!--cuadro de tipo archivo para recoger la imagen que seleccione el usuario-->
                    <input type="file" class="form-control-file" id="imagen" name="imagen"/>
                    <?php  echo mensajeError($errores, "imagen");?>      
                </div>
                <br/>
                <!--botones para enviar los datos recogidos en el formulario y para limpiar los campos-->
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-primary" name="boton">Enviar</button>
                    <button type="reset" class="btn btn-primary">Limpiar</button>
                </div>
            </form> <!--Fin del formulario-->
        </div>