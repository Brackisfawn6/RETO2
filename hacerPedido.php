<!DOCTYPE html>
<html lang="en" >
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" media="all" href="CSS/hacerPedido.css" />
    <title> King Pizza </title>
    <link rel="shortcut icon" href="Imagenes/logo2.png" />
</head>
<body>


    <form action='elegirPizza.php' method='REQUEST'> 
    
            <h2>SELECCIONE LA CANTIDAD DE PIZZAS: <h2>
            <input type='number' value='0' min='0' max='100' name='numPizzas'> <br>
                <p>Maximo 100 Pizzas</p>
            <input type='submit' value='Siguiente' name='seleccionarPizzas' />
                                            
    </form>

  

</body>
</html>