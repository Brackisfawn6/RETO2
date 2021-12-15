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

<div class="container">
	<div class="screen">
		<div class="screen__content">
			<form class="login">
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="text" class="login__input" placeholder="User name / Email">
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input type="password" class="login__input" placeholder="Password">
				</div>
				<button class="button login__submit">
					<span class="button__text">Log In Now</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>				
			</form>
			<div class="social-login">
				<h3>log in via</h3>
				<div class="social-icons">
					<a href="#" class="social-login__icon fab fa-instagram"></a>
					<a href="#" class="social-login__icon fab fa-facebook"></a>
					<a href="#" class="social-login__icon fab fa-twitter"></a>
				</div>
			</div>
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>