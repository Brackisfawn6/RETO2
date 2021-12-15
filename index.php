<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzeria</title>
    <link rel="stylesheet" media="all" href="estilos.css" />
</head>
<body>

    <?php

    include "conexion.php";
    include "funciones.php";
    
    ?> 

    <form action='login.php' method='get'>
        <fieldset>
            <input type='submit' value='Login'>  
        </fieldset>

    </form>  

    <input type='checkbox' id='mmeennuu'>
    <label class='menu' for='mmeennuu'>

        <div class='barry'>
	     <span class='bar'></span>
	     <span class='bar'></span>
	     <span class='bar'></span>
	     <span class='bar'></span>
        </div>
	
<ul>
	<li><a id='home' href='#home'>Home</a></li>
	<li><a id='about' href='#about'>About</a></li>
	<li><a id='contact' href='#contact'>Contact</a></li>
	<li><a id='link' href='#link'>Other</a></li>
</ul>

</label>

</body>
</html>