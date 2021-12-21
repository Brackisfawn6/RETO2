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

    <?php 
    
    include "conexion.php";
    include "funciones.php";

    session_start();
    
    for($x=0;$x <  $_SESSION["cantPizzas"] ;$x++){

        $selectPizza="elegirPizzas".$x;
        $nomPizza=$_REQUEST[$selectPizza];
        echo "$nomPizza <br>";

    }

    for($x=0;$x <  $_SESSION["cantPizzas"] ;$x++){

        $selectIng="elegirIng".$x;
        $nomIng=$_REQUEST[$selectIng];
        echo "$nomIng <br>";

    }
    
    /* 
    for($x=0;$x <  $_SESSION["cantPizzas"] ;$x++){

        $nameRadio="radio".$x;

        if (isset($_REQUEST[$nameRadio])){
            $ing=$_REQUEST[$nameRadio];
        }else{
            $ing="";
        }
        
        echo "$ing <br>";
    }
    */
          




    ?>

 	
</body>
</html>
