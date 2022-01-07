<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> King Pizza </title>
    <link rel="stylesheet" media="all" href="CSS/index2.css" />
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
      if (isset($_REQUEST['Cerrar'])){
        $_SESSION["usuario"] = "";
      }
      if($_SESSION["usuario"] != ""){
            echo "<fieldset><h2>Session iniciada con el usuario: " . ucwords($_SESSION["usuario"]) . "</h2>";
            echo "<h2><form action='index.php' method='post'>
            <input type='submit' value='Cerrar Sesion' name='Cerrar'/>
            </form></h2></fieldset>";  
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
            <li><a id='pizzas' href='listarClientes.php'>Ver Clientes</a></li>
            <li><a id='pizzas' href='listarPedidos.php'>Ver Pedidos</a></li>
            <li><a id='pizzas' href='anadirPizzas.php'>Añadir Pizzas</a></li>
            <li><a id='pizzas' href='borrarPizzas.php'>Borrar Pizzas</a></li>
            <li><a id='pizzas' href='anadirIngredientes.php'>Añadir Ingredientes</a></li>
            <li><a id='pizzas' href='borrarIngredientes.php'>Borrar Ingredientes</a></li>
            <li><a id='menus' href='listarPizzas.php'>Ver La Carta</a></li>
            <li><a id='inicioSesion' href='login.php'>Login</a></li>
        </ul>

    </label>

    
    <div class="footer">
        <p>Copyright © 2022 - Página Web realizada por Miguel Lopez | Contacto: miguel.lopezhe@elorrieta-errekamari.com<br></p>
    </div>

 
    

</body>
</html>