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

        Registrarse($conexion,$dni,$nombre,$direccion,$poblacion,$telefono,$email,$password);
        echo "Usuario Resgitrado correctamente";
    

    }else{

        echo "
            <div class='container'>
                <div class='screen'>
                    <div class='screen__content'>
                        <form class='login' action='registro.php' method='REQUEST'>
                            <h1> REGISTRO <h1>
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
                                <input type='password' class='login__input' name='contraseña' placeholder='Contraseña'>
                            </div>
                            <div class='login__field'>
                                <i class='login__icon fas fa-lock'></i>
                                <input type='password' class='login__input' name='' placeholder='Repetir contraseña'>
                            </div>
                            <button class='button login__submit' type='submit' value='Login' name='Login'>
                                <span class='button__text'>INICIAR SESION</span>
                                <i class='button__icon fas fa-chevron-right'></i>
                            </button>				
                        </form>
                        <div class='social-login'>
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

        echo "
        <form action='registro.php' method='get'>
            DNI: <br>
            <input type='text' name='dni'> <br>
            Nombre: <br>
            <input type='text' name='nombre'> <br>
            Direccion: <br>
            <input type='text' name='direccion'> <br>
            Poblacion: <br>
            <input type='text' name='poblacion'> <br>
            Telefono: <br>
            <input type='text' name='telefono'> <br>
            Email: <br>
            <input type='text' name='email'> <br>
            Contraseña: <br>
            <input type='password' name='password'> <br>
            Repetir Contraseña: <br>
            <input type='password' name=''> <br> <br>
        <input type='submit' value='Registro' name='Registro'>
        </form>";	
    }

    ?> 
    
</body>
</html>