<!DOCTYPE html>
<html lang="en" >
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" media="all" href="CSS/listarpizzas.css" />
    <title>Pizzeria</title>
</head>
<body>

    <?php

    include "conexion.php";
    include "funciones.php";
    
    if (isset($_REQUEST['seleccionarPizzas'])){

    echo "Seleccione las Pizzas <br> <br>";
    $numPizzas=$_REQUEST['numPizzas'];
    elegirPizzas($conexion, $numPizzas);

    }else{

        echo "<form action='hacerPedido.php' method='REQUEST'> 

		<h2>Seleccione el numero de Pizzas que desees:<h2>
        <input type='number' value='0' min='0' name='numPizzas'> <br><br>

        <input type='submit' value='Login' name='seleccionarPizzas' />
										
	    </form>";

    }
 

    ?> 

 

</body>
</html>