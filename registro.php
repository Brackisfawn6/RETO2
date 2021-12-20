<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="all" href="CSS/registro.css" />
    <title>Pizzeria</title>
</head>
<body>

    <?php

    include "conexion.php";
    include "funciones.php";

    if (isset($_REQUEST['Registro'])){

        $dni=$_REQUEST['dni'];
        $nombre=$_REQUEST['nombre'];
        $direccion=$_REQUEST['direccion'];
        $poblacion=$_REQUEST['poblacion'];
        $telefono=$_REQUEST['telefono'];
        $email=$_REQUEST['email'];
        $password=$_REQUEST['password'];

        echo "
        <div class='container'>
            <div class='screen'>
                <div class='screen__content'>
                    <form class='login' action='registro.php' method='REQUEST'>
                        <h1> REGISTRO </h1>
                        <h2>" . Registrarse($conexion,$dni,$nombre,$direccion,$poblacion,$telefono,$email,$password) . "</h2>
                        <div class='login__field'>
                            <i class='login__icon fas fa-user'></i>
                            <input type='text' class='login__input' name='dni' placeholder='DNI'>
                        </div>
                        <div class='login__field'>
                            <i class='login__icon fas fa-lock'></i>
                            <input type='text' class='login__input' name='nombre' placeholder='Nombre'>
                        </div>
                        <div class='login__field'>
                            <i class='login__icon fas fa-lock'></i>
                            <input type='text' class='login__input' name='direccion' placeholder='Direccion'>
                        </div>
                        <div class='login__field'>
                            <i class='login__icon fas fa-lock'></i>
                            <input type='text' class='login__input' name='poblacion' placeholder='Poblacion'>
                        </div>
                        <div class='login__field'>
                            <i class='login__icon fas fa-lock'></i>
                            <input type='text' class='login__input' name='telefono' placeholder='Telefono'>
                        </div>
                        <div class='login__field'>
                            <i class='login__icon fas fa-lock'></i>
                            <input type='text' class='login__input' name='email' placeholder='Email'>
                        </div>
                        <div class='login__field'>
                            <i class='login__icon fas fa-lock'></i>
                            <input type='password' class='login__input' name='password' placeholder='Contraseña'>
                        </div>
                        <button class='button login__submit' type='submit' value='Registro' name='Registro'>
                            <span class='button__text'>REGISTRARSE</span>
                            <i class='button__icon fas fa-chevron-right'></i>
                        </button>				
                    </form>
                    <div class='social-login'>
                    <br><br><br><br><br>
                    <a href='login.php'>Login</a>
                    </div>
                </div>
                <div class='screen__background'>
                    <span class='screen__background__shape screen__background__shape4'></span>
                    <span class='screen__background__shape screen__background__shape3'></span>		
                    <span class='screen__background__shape screen__background__shape2'></span>
                    <span class='creen__background__shape screen__background__shape1'></span>
                </div>		
            </div>
        </div>";    

    }else{

        echo "
        <div class='container'>
            <div class='screen'>
                <div class='screen__content'>
                    <form class='login' action='registro.php' method='REQUEST'>
                        <h1> REGISTRO </h1>
                        <div class='login__field'>
                            <i class='login__icon fas fa-user'></i>
                            <input type='text' class='login__input' name='dni' placeholder='DNI'>
                        </div>
                        <div class='login__field'>
                            <i class='login__icon fas fa-lock'></i>
                            <input type='text' class='login__input' name='nombre' placeholder='Nombre'>
                        </div>
                        <div class='login__field'>
                            <i class='login__icon fas fa-lock'></i>
                            <input type='text' class='login__input' name='direccion' placeholder='Direccion'>
                        </div>
                        <div class='login__field'>
                            <i class='login__icon fas fa-lock'></i>
                            <input type='text' class='login__input' name='poblacion' placeholder='Poblacion'>
                        </div>
                        <div class='login__field'>
                            <i class='login__icon fas fa-lock'></i>
                            <input type='text' class='login__input' name='telefono' placeholder='Telefono'>
                        </div>
                        <div class='login__field'>
                            <i class='login__icon fas fa-lock'></i>
                            <input type='text' class='login__input' name='email' placeholder='Email'>
                        </div>
                        <div class='login__field'>
                            <i class='login__icon fas fa-lock'></i>
                            <input type='password' class='login__input' name='password' placeholder='Contraseña'>
                        </div>
                        <button class='button login__submit' type='submit' value='Registro' name='Registro'>
                            <span class='button__text'>REGISTRARSE</span>
                            <i class='button__icon fas fa-chevron-right'></i>
                        </button>				
                    </form>
                    <div class='social-login'>
                    <br><br><br><br><br>
                    <a href='login.php'>Login</a>
                    </div>
                </div>
                <div class='screen__background'>
                    <span class='screen__background__shape screen__background__shape4'></span>
                    <span class='screen__background__shape screen__background__shape3'></span>		
                    <span class='screen__background__shape screen__background__shape2'></span>
                    <span class='creen__background__shape screen__background__shape1'></span>
                </div>		
            </div>
        </div>";  
    }

    ?> 
    
</body>
</html>