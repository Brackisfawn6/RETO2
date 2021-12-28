<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> King Pizza </title>
    <link rel="stylesheet" media="all" href="CSS/index.css" />
    <link rel="shortcut icon" href="Imagenes/logo2.png" />
</head>
<body>

    <div class="logo">
	    <img src="Imagenes/banner2.png" alt="" width="100%" height="100%">
	</div>

    <?php
      if(!isset($_SESSION)) 
      { 
            session_start(); 
      } 
      if($_SESSION["usuario"] != ""){
            echo "Session iniciada con el usuario con DNI: " . $_SESSION["usuario"];
      }
        
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
            <li><a id='pizzas' href='hacerPedido.php'>Hacer Pedido</a></li>
            <li><a id='menus' href='listarPizzas.php'>Ver La Carta</a></li>
            <li><a id='inicioSesion' href='login.php'>Login</a></li>
            <li><a id='contacto' href='contacto.php'>Contacto</a></li>
        </ul>

    </label>

    
  

 
    

</body>
</html>