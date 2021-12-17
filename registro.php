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