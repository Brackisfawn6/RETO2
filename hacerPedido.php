<!DOCTYPE html>
<html lang="en" >
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" media="all" href="CSS/hacerPedido.css?ts=<?=time()?>" />
    <title> King Pizza </title>
    <link rel="shortcut icon" href="Imagenes/logo2.png" />
    
</head>
<body>

    <?php
        include "conexion.php";
        include "funciones.php";

        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 

        if ($_SESSION["usuario"] == ""){
            echo "<fieldset><h2>Tienes que iniciar sesion para realizar un pedido. <br><br>
            <a href='login.php'> Iniciar Sesion </a>  &nbsp; &nbsp; &nbsp;
            <a href='index.php'>Volver</a> </h2></fieldset>";
        }else{

            if (isset($_REQUEST['seleccionarPizzas'])){
                $numPizzas=$_REQUEST['numPizzas'];

                if ($numPizzas == 0){
                    echo "
                    <fieldset><form action='#' method='REQUEST'>  
                            <h2>SELECCIONE LA CANTIDAD DE PIZZAS (Max 100): <h2>
                            <h3>Seleccione al menos una pizza</h3>
                            <input type='number' value='0' min='0' max='100' name='numPizzas'> <br><br>
                            <input type='submit' value='Siguiente' name='seleccionarPizzas' /> <br><br>
                            <a href='index.php'>Volver</a> 
                    </form></fieldset>";

                }else{
                    
                    echo "<form action='consultarPedido.php' method='REQUEST'>";
                        elegirPizzas($conexion, $numPizzas);
                    echo "</form>";
                }


            } else {
                echo "
                <fieldset><form action='#' method='REQUEST'>  
                        <h2>SELECCIONE LA CANTIDAD DE PIZZAS (Max 100): <h2>
                        <h3></h3>
                        <input type='number' value='0' min='0' max='100' name='numPizzas'> <br><br>
                        <input type='submit' value='Siguiente' name='seleccionarPizzas' /> <br><br>
                        <a href='index.php'>Volver</a> 
                </form></fieldset>";

            }
      
        }
  
    ?>

</body>
</html>