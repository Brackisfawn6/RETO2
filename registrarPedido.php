<!DOCTYPE html>
<html lang="en" >
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" media="all" href="CSS/registrarPedido.css" />
    <title> King Pizza </title>
    <link rel="shortcut icon" href="Imagenes/logo2.png" />
    
</head>
<body>

    <?php

    include "conexion.php";
    include "funciones.php";

    session_start();
 
    $dni=$_SESSION["usuario"];
    $importe=$_SESSION["importe"];

    anadirPedido($conexion,$dni,$importe);
    //anadirLineaPedido();

    ?> 

</body>
</html>