<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzeria</title>
    <link rel="stylesheet" media="all" href="CSS/index.css" />
</head>
<body>

    <?php

    include "conexion.php";
    include "funciones.php";
    
    ?> 

    <input type='checkbox' id='mmeennuu'>

    <label class='menu' for='mmeennuu'>

        <div class='barry'>
            <span class='bar'></span>
            <span class='bar'></span>
            <span class='bar'></span>
            <span class='bar'></span>
        </div>
        
        <ul>
            <li><a id='pizzas' href='#home'>Elige tu pizza</a></li>
            <li><a id='menus' href='listarPizzas.php'>Ver Nuestras Pizzas</a></li>
            <li><a id='promociones' href='#promociones'>Promociones</a></li>
            <li><a id='inicioSesion' href='login.php'>Login</a></li>
            <li><a id='contacto' href='#link'>Contacto</a></li>
        </ul>

    </label>

</body>
</html>