<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzeria</title>
</head>
<body>

    <?php

    include "conexion.php";
    include "funciones.php";

    if (isset($_REQUEST['Login'])){

        $dni=$_REQUEST['dni'];
        $password=$_REQUEST['password'];

        if (validar_dni($dni)==false){
            echo "Formato DNI es incorrecto";
        }
        Login($conexion,$dni,$password);

        

    }else{

        echo "
        <form action='login.php' method='get'>
            DNI: <br>
            <input type='text' name='dni'> <br>
            Contraseña: <br>
            <input type='text' name='password'> <br> <br>
        <input type='submit' value='Login' name='Login'>
        </form>";	
    }

    ?> 
    
</body>
</html>