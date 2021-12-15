<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzeria</title>
    <link rel="stylesheet" media="all" href="CSS/login.css" />
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
        }else{
            Login($conexion,$dni,$password);
        }

    }else{

	echo "
	<div class='container'>
		<div class='screen'>
			<div class='screen__content'>
				<form class='login' action='login.php' method='REQUEST'>
					<div class='login__field'>
						<i class='login__icon fas fa-user'></i>
						<input type='text' class='login__input'  name='dni' placeholder='DNI'>
					</div>
					<div class='login__field'>
						<i class='login__icon fas fa-lock'></i>
						<input type='password' class='login__input' name='password' placeholder='Contraseña'>
					</div>
					<button class='button login__submit' type='submit' value='Login' name='Login'>
						<span class='button__text'>INICIAR SESION</span>
						<i class='button__icon fas fa-chevron-right'></i>
					</button>				
				</form>
				<div class='social-login'>
					<a href='registro.php'>Registrarse</a>
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
