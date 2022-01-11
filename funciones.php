<?php

function Login($conexion,$dni,$password){

    $sql="SELECT * FROM Cliente";
    $registros=mysqli_query($conexion,$sql);

    $encontrar=false;

    if(empty($dni)){
        $mensaje = "Faltan datos";
    }/*elseif (validarDni($dni) == false){
        $mensaje = "El formato del DNI es incorrecto.";
    }*/
    else{
        if($dni == 'admin' &&  $password == 'admin'){
            echo "<meta http-equiv='refresh' content='0 url=index2.php'>";    
            if(!isset($_SESSION)) 
            { 
                session_start(); 
            }          
            $_SESSION["usuario"]= "administrador";
            $_SESSION["dni"]= "admin";
        }else{
            while ($datos = mysqli_fetch_assoc($registros)){         
                if($datos['DNI'] == $dni){
                    $encontrar=true;
                        if ($datos['password'] == $password){
                            echo "<meta http-equiv='refresh' content='0 url=index.php'>";    
                            if(!isset($_SESSION)) 
                            { 
                                session_start(); 
                            }          
                            $_SESSION["usuario"]= $datos['nombre'];
                            $_SESSION["dni"]= $datos['DNI'];
                        }else{
                            $mensaje= "Contraseña incorrecta";  
                        }
                }
            }
            if($encontrar == false){
                $mensaje = "Cliente no encontrado";
            }
        }  
    }
       
    return $mensaje;
    mysqli_close($conexion);
      
}   

function Registrarse($conexion,$dni,$nombre,$direccion,$poblacion,$telefono,$email,$password){

    $sql="INSERT INTO Cliente values ('$dni','$nombre','$direccion','$poblacion','$telefono','$email', now(),'$password',NULL,0)";
    
    if(empty($dni) || empty($nombre) || empty($direccion) || empty($poblacion) || empty($telefono) || empty($email) || empty($password)){
        $mensaje = "Rellene todos los campos.";
    }elseif(validarDni($dni) == false){
        $mensaje = "El formato del DNI es incorrecto.";
    }elseif(!mysqli_query($conexion, $sql)) {
        $mensaje = "Este DNI ya esta registrado.";
    }else {
        $mensaje = "Usuario registrado correctamente.";
        mysqli_query($conexion,$sql);
    }

    return $mensaje;
    mysqli_close($conexion);  

}

function ListarPizzas($conexion) {

    $sql="SELECT * FROM Pizza";
    $registros=mysqli_query($conexion,$sql);

    echo "
    <h1>CARTA</h1>  <br>      
    <div class='datagrid'><table> 
    <thead><tr>
            <th>Pizza</th>         
            <th>Ingredientes</th>
            <th>Precio</th>
    </tr></thead><tbody>";

        while($datos=mysqli_fetch_assoc($registros)){

            $sql2="select * from Contiene where nom_pizza='$datos[nom_pizza]'";  
            $registros2=mysqli_query($conexion,$sql2);

            $ingredientes="";
              
            while ($datos2=mysqli_fetch_assoc($registros2)){
                $sql3="select * from Ingrediente where nom_ingrediente='$datos2[nom_ingrediente]'";
                $registros3=mysqli_query($conexion,$sql3);
                while ($datos3=mysqli_fetch_assoc($registros3)){
                $ingredientes=$ingredientes . $datos2['nom_ingrediente'] . " (" . $datos3['unidad_medida'] . ", " . $datos3['tipo'] . ") <br>";
                }
            }

            echo"<tr>
            <td>" . utf8_decode($datos['nom_pizza']) . "</td>            
            <td>" . utf8_decode($ingredientes) . "</td> 
            <td>" . number_format($datos['precio'],2,",",".") . " € </td>
            </tr>";
        }   
     
    echo "</tbody></table></div>";       

    mysqli_close($conexion);  

}

function ListarPizzas2($conexion) {

    $sql="SELECT * FROM Pizza";
    $registros=mysqli_query($conexion,$sql);

    echo "
    <h1>CARTA</h1>  <br>      
    <div class='datagrid'><table> 
    <thead><tr>
            <th>Pizza</th>         
            <th>Ingredientes&nbsp&nbsp&nbsp&nbsp</th>
            <th>Tiempo preparacion (min)</th>
            <th>Cantidad de pedidos</th>
            <th>Cantidad de unidades</th>
            <th>Precio</th>
    </tr></thead><tbody>";

        while($datos=mysqli_fetch_assoc($registros)){

            $sql2="select * from Contiene where nom_pizza='$datos[nom_pizza]'";  
            $registros2=mysqli_query($conexion,$sql2);

            $ingredientes="";
              
            while ($datos2=mysqli_fetch_assoc($registros2)){
                $sql3="select * from Ingrediente where nom_ingrediente='$datos2[nom_ingrediente]'";
                $registros3=mysqli_query($conexion,$sql3);
                while ($datos3=mysqli_fetch_assoc($registros3)){
                $ingredientes=$ingredientes . $datos2['nom_ingrediente'] . " (" . $datos3['unidad_medida'] . ", " . $datos3['tipo'] . ") <br>";
                }
            }

            echo"<tr>
            <td>" . utf8_decode($datos['nom_pizza']) . "</td>            
            <td>" . utf8_decode($ingredientes) . "</td> 
            <td>$datos[tiempo_prep]</td> 
            <td>$datos[num_pedidos]</td> 
            <td>$datos[num_unidades]</td> 
            <td>" . number_format($datos['precio'],2,",",".") . " € </td>
            </tr>";
        }   
     
    echo "</tbody></table></div>";       

    mysqli_close($conexion);  

}

function elegirPizzas($conexion,$numPizzas){


        $sql="SELECT * FROM Pizza";
        $sql2="SELECT * FROM Ingrediente";
        $registros=mysqli_query($conexion,$sql);
        $registros2=mysqli_query($conexion,$sql2);
     
        while($datos=mysqli_fetch_assoc($registros)){
            $pizzas[]=$datos['nom_pizza'];
        }

        while($datos2=mysqli_fetch_assoc($registros2)){
            $ingrediente[]=$datos2['nom_ingrediente'];
        }
        
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 
        $_SESSION['cantPizzas'] = $numPizzas;

        if ($numPizzas!=0){

            echo "<fieldset><h2>Seleccione las Pizzas y ingrediente extra si desea:</h2>";

            for ($i=0;$i<$numPizzas;$i++){

                echo "
                <p> Pizza " . ($i+1) . ": </p>
                <select name='elegirPizzas" . $i . "'>
                    <option value=0>--Seleccione una Pizza--</option>";
    
                    for($x=0;$x < count($pizzas) ;$x++){
                        echo "<option value='". utf8_decode($pizzas[$x]) ."'>". utf8_decode($pizzas[$x]) . "</option>";
                    }
                 
                echo "</select>

                <p> Ingrediente extra: </p> ";

                echo "<select name='elegirIng" . $i . "'>
                <option value=0>--Seleccione un Ingrediente--</option>";

                    for($x=0;$x < count ($ingrediente) ;$x++){
                        echo "<option value='". utf8_decode($ingrediente[$x]) ."'>". utf8_decode($ingrediente[$x]) . "</option>";
                    }
             
                echo "</select>

                <br>----------------------------------------------------------------------------<br>";
      
            }

            echo "<input type='submit' value='Siguiente' name='seleccionarPizzas' /> <br><br>";   
            echo "<h2><a href='hacerPedido.php'> Volver </a></h2>";

        }else{
            echo "<h2>Seleccione al menos una pizzaaa
            <a href='hacerPedido.php'>Volver</a></h2></fieldset>";
	
        }

        mysqli_close($conexion);  
}

function consultarPedido($conexion){
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }    

    $error=false;

    for($x=0;$x < $_SESSION["cantPizzas"] ;$x++){

        $selectPizza="elegirPizzas".$x;
        $nomPizza=$_REQUEST[$selectPizza];

        if($nomPizza != 0){
            $pizzas[]=$nomPizza;
        }else{
            $error=true;
        }
              
    }

    for($x=0;$x < $_SESSION["cantPizzas"] ;$x++){

        $selectIng="elegirIng".$x;
        $nomIng=$_REQUEST[$selectIng];

        if($nomIng != 0){
            $ingredientes[]=$nomIng; 
        }else{
            $ingredientes[]="Ninguno"; 
        }

    }

    if ($error != true){

        echo "
        <h1>Comprueba su compra:</h1>  <br>      
        <div class='datagrid'><table> 
        <thead><tr>
                <th>Pizza</th>         
                <th>Ingrediente extra</th>
                <th>Precio</th>
        </tr></thead><tbody>";
        $total=0;
        for ($i=0; $i < count($pizzas); $i++) { 

            $sql="SELECT * FROM PizzeriaReto.Pizza where nom_pizza='" . $pizzas[$i] . "'";
            $registros=mysqli_query($conexion,$sql);
            
            while($datos=mysqli_fetch_assoc($registros)){
                $precio[]=$datos['precio'];
            }
    
            echo"<tr>
            <td>" . utf8_decode($pizzas[$i]) . "</td>            
            <td>" . utf8_decode($ingredientes[$i]) . "</td> 
            <td>" . number_format($precio[$i],2,",",".") . " € </td>
            </tr>";

            $total=$total+$precio[$i];

        } 

        $_SESSION['importe'] = $total;
        $_SESSION['pizzas'] = $pizzas;
        $_SESSION['ingredientes'] = $ingredientes;

        echo "<tr>
                    <td colspan='2'><font color=#ec0b0b>TOTAL</td>
                    <td><font color=#ec0b0b>" . number_format($total,2,",",".") . " € </td>
              </tr>
        </tbody></table></div> <br><br>"; 


        echo "<form action='registrarPedido.php' method='post'>  
        <div class='confirmar'>
            <input type='submit' value='Confirmar Pedido' name='confirmarPedido' />
        </div>
        </form>";
    }else{
        echo "<fieldset><h2>Error: Seleccione las Pizzas.<br><br>
        <a href='hacerPedido.php'>Volver</a></h2></fieldset> ";
    }

    mysqli_close($conexion);  
          
}

function anadirPedido($conexion){

    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }    

    $dni=$_SESSION["dni"];
    $importe=$_SESSION["importe"];

    $sql="INSERT INTO Pedido (fechahora, dni_cliente, importe) VALUES (now(), '$dni' , '$importe')";

    if (mysqli_query($conexion, $sql)) {
        echo "<fieldset>
        <h2>Pedido realizado correctamente.<h2>
        
        <form action='hacerPedido.php' method='post'>
        <input type='submit' value='Realizar otro Pedido'/>
        </form>
        <form action='index.php' method='post'>
        <input type='submit' value='Volver al Inicio'/>
        </form>

        </fieldset>";
    }else{
        echo mysqli_connect_error();
    }

    $sql2="SELECT * FROM pedido ORDER BY num_pedido DESC LIMIT 1";
    $registros2=mysqli_query($conexion,$sql2);
    while ($datos = mysqli_fetch_assoc($registros2)){
        $num_pedido=$datos['num_pedido'];
    }

    $_SESSION["num_pedido"]=$num_pedido;

    $pizzas=$_SESSION["pizzas"];
    $contar=array_count_values($pizzas);

    for ($i=0; $i < count($pizzas); $i++) { 
        $nom_pizza=$pizzas[$i];
        $unidades=$contar[$pizzas[$i]];
        $sql="INSERT INTO LineaPedido values ('$num_pedido','$nom_pizza',$unidades,null,0)";
        mysqli_query($conexion,$sql);
    }

    mysqli_close($conexion);  

}

function validarDni($dni){

    $letra = substr($dni, -1);
    $numeros = substr($dni, 0, -1);
    $valido;
    if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letra && strlen($letra) == 1 && strlen ($numeros) == 8 ){
      return true;
    }else{
      return false;
    }
}

function listarClientes($conexion){

    error_reporting(0);
  
    $DNI1=$_REQUEST['dni'];

    if($DNI1 == ""){
        $sql="SELECT * FROM Cliente";
    }else{
        $sql="SELECT * FROM Cliente where DNI='$DNI1'";
    }
    $registros=mysqli_query($conexion,$sql);

    echo "
    <h1>CLIENTES</h1>  <br>  
    
    <fieldset><form action='listarClientes.php' method='post'>
    <input type='text' placeholder='DNI' name='dni'/>
    <input type='submit' value='Buscar' name='Buscar'/>
    </form><br><h2><a href='index2.php'>Volver</a></h2></fieldset> <br>

    <div class='datagrid'><table>
    <thead><tr>
            <th>DNI</th>         
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Poblacion</th>
            <th>Telefono</th>
            <th>Email</th>
            <th>Fecha&nbsp&nbspAlta</th>
            <th>Contraseña</th>
            <th>Ultimo&nbsp&nbspPedido</th>
            <th>Cantidad de Pedidos</th>
    </tr></thead><tbody>";

        while($datos=mysqli_fetch_assoc($registros)){

            echo"<tr>
            <td>$datos[DNI]</td>    
            <td>$datos[nombre]</td>  
            <td>$datos[direccion]</td>  
            <td>$datos[poblacion]</td>  
            <td>$datos[telefono]</td>          
            <td>$datos[email]</td>  
            <td>$datos[fecha_alta]</td>  
            <td>$datos[password]</td>  
            <td>$datos[ultimo_pedido]</td>  
            <td>$datos[num_pedidos]</td>  
            </tr>";
        }   
     
    echo "</tbody></table></div>";       

    mysqli_close($conexion);  
    
}

function listarPedidos($conexion){

    error_reporting(0);
  
    $numPedido=$_REQUEST['pedido'];

    if($numPedido == ""){
        $sql="SELECT dni_cliente, p.num_pedido, nom_pizza, unidades, ing_adicional, unidades_ing_adicional, fechahora, importe FROM Pedido p, LineaPedido l order by dni_cliente, p.num_pedido asc";
    }else{
        $sql="SELECT dni_cliente, p.num_pedido, nom_pizza, unidades, ing_adicional, unidades_ing_adicional, fechahora, importe FROM Pedido p, LineaPedido l where p.num_pedido='$numPedido' order by dni_cliente, p.num_pedido asc";
    }
   
    $registros=mysqli_query($conexion,$sql);

    echo "
    <h1>Pedidos</h1><br>  

    <fieldset><form action='listarPedidos.php' method='post'>
    <input type='number' placeholder='ID pedido' name='pedido'/>
    <input type='submit' value='Buscar' name='Buscar'/>
    </form><br><h2><a href='index2.php'>Volver</a></h2></fieldset> <br>

    <div class='datagrid'><table>
    <thead><tr>
            <th>DNI</th>         
            <th>ID Pedido</th>
            <th>Pizza</th>
            <th>Unidades</th>
            <th>Ingrediente adicional</th>
            <th>Unidades ingrediente adicional</th>
            <th>Fecha&nbsp&nbsp&nbsp</th>
            <th>Importe</th>
    </tr></thead><tbody>";

        while($datos=mysqli_fetch_assoc($registros)){

            echo"<tr>
            <td>$datos[dni_cliente]</td>    
            <td>$datos[num_pedido]</td>  
            <td>$datos[nom_pizza]</td>  
            <td>$datos[unidades]</td>  
            <td>$datos[ing_adicional]</td>          
            <td>$datos[unidades_ing_adicional]</td>  
            <td>$datos[fechahora]</td>  
            <td>$datos[importe]</td>  
            </tr>";
        }   
     
    echo "</tbody></table></div>";       

    mysqli_close($conexion);  
    
}

function anadirPizzas($conexion){

    if (isset($_REQUEST['Añadir'])){
        $sql="INSERT INTO Pizza values ('". ucwords($_REQUEST['nombre']) . "','" . $_REQUEST['tiempo'] . "','" . $_REQUEST['precio'] . "','0','0')";
        if(empty($_REQUEST['nombre']) || empty($_REQUEST['tiempo']) || empty($_REQUEST['precio'])){
            echo "<fieldset><h2>Error: Rellene todos los campos.<br><br>
            <a href='anadirPizzas.php'>Volver</a></h2></fieldset>";
        }else{
            if(mysqli_query($conexion,$sql)){
                echo "<fieldset><h2>Pizza añadida correctamente.<br><br>
                <a href='anadirPizzas.php'>Añadir otra pizza</a> &nbsp &nbsp <a href='index2.php'>Volver</a></h2></fieldset>";
            }else{
                echo "<fieldset><h2>Esta pizza ya esta añadida.<br><br>
                <a href='index2.php'>Volver</a></h2></fieldset>";
            }
        }      
        mysqli_close($conexion);  
    }else{
        echo "<fieldset><h2>Añade un pizza a la base de datos.</h2>
        <form action='anadirPizzas.php' method='post'>
        <input type='text' placeholder='nombre' name='nombre'/>
        <input type='number' placeholder='tiempo preparacion' name='tiempo'/>
        <input type='number' step='0.01' placeholder='precio' name='precio'/>
        <input type='submit' value='Añadir' name='Añadir'/>
        </form><br><h2><a href='index2.php'>Volver</a></h2></fieldset>";
    }

}

function borrarPizzas($conexion){
    
    if (isset($_REQUEST['Borrar'])){
        $sql="DELETE FROM Pizza WHERE nom_pizza='". $_REQUEST['borrarSelect'] . "'";
        if($_REQUEST['borrarSelect'] == 0){
            echo "<fieldset><h2>Error: Seleccione una pizza.<br><br>
            <a href='borrarPizzas.php'>Volver</a></h2></fieldset>";
        }else{
            mysqli_query($conexion,$sql);
            echo "<fieldset><h2>Pizza eliminada correctamente.<br><br>
            <a href='borrarPizzas.php'>Eliminar otra pizza</a> &nbsp &nbsp <a href='index2.php'>Volver</a></h2></fieldset>";
        }
        mysqli_close($conexion);  
    }else{
        $sql2="SELECT * from pizza";
        $registros=mysqli_query($conexion,$sql2);


        echo "<fieldset><h2>Borre un pizza de la base de datos.</h2>
        <form action='borrarPizzas.php' method='post'>

        <select name='borrarSelect'>
        <option value=0>--Seleccione una Pizza--</option>";

        while($datos=mysqli_fetch_assoc($registros)){
            echo "<option value='".  utf8_decode($datos['nom_pizza']) ."'>".  utf8_decode($datos['nom_pizza']) . "</option>";
        }
     
        echo "</select>
        <input type='submit' value='Borrar' name='Borrar'/>
        </form><br><h2><a href='index2.php'>Volver</a></h2></fieldset>";
    }

}

function anadirIngredientes($conexion){

    if (isset($_REQUEST['Añadir'])){
        $sql="INSERT INTO Ingrediente values ('". ucwords($_REQUEST['nombre']) . "','" . $_REQUEST['unidad'] . "','" . $_REQUEST['tipo'] . "','0')";
        if(empty($_REQUEST['nombre']) || $_REQUEST['unidad'] == 0 || $_REQUEST['tipo'] == 0){
            echo "<fieldset><h2>Error: Rellene todos los campos.<br><br>
            <a href='anadirIngredientes.php'>Volver</a></h2></fieldset>";
        }else{
            if(mysqli_query($conexion,$sql)){
                echo "<fieldset><h2>Ingrediente añadida correctamente.<br><br>
                <a href='anadirIngredientes.php'>Añadir otro ingrediente</a> &nbsp &nbsp <a href='index2.php'>Volver</a></h2></fieldset>";
            }else{
                echo "<fieldset><h2>Este ingrediente ya esta añadida.<br><br>
                <a href='index2.php'>Volver</a></h2></fieldset>";
            }
        }      
        mysqli_close($conexion);  
    }else{
        echo "<fieldset><h2>Añade un ingrediente a la base de datos.</h2>
        <form action='anadirIngredientes.php' method='post'>
        <input type='text' placeholder='nombre' name='nombre'/>

        <select name='unidad'>
        <option value=0>--Seleccione la unidad--</option>
        <option value='gr'>gr</option>
        <option value='ml'>ml</option>     
        </select>
        
        <select name='tipo'>
        <option value=0>--Seleccione el tipo--</option>
        <option value='V'>V</option>
        <option value='C'>C</option>  
        <option value='L'>L</option>    
        </select>

        <input type='submit' value='Añadir' name='Añadir'/>
        </form><br><h2><a href='index2.php'>Volver</a></h2></fieldset>";
    }
}

function borrarIngredientes($conexion){
	if (isset($_REQUEST['Borrar'])){
          $sql="DELETE FROM Ingrediente WHERE nom_ingrediente='". $_REQUEST['borrarSelect'] . "'";
          if($_REQUEST['borrarSelect'] == 0){
              echo "<fieldset><h2>Error: Seleccione un ingrediente.<br><br>
              <a href='borrarIngredientes.php'>Volver</a></h2></fieldset>";
          }else{
              mysqli_query($conexion,$sql);
              echo "<fieldset><h2>Ingrediente eliminado correctamente.<br><br>
              <a href='borrarIngredientes.php'>Eliminar otro ingrediente</a> &nbsp &nbsp <a href='index2.php'>Volver</a></h2></fieldset>";
          }
          mysqli_close($conexion);  
        }else{
          $sql2="SELECT * from ingrediente";
          $registros=mysqli_query($conexion,$sql2);
  
          
          echo "<fieldset><h2>Borre un ingrediente de la base de datos.</h2>
          <form action='borrarIngredientes.php' method='post'>
  
          <select name='borrarSelect'>
          <option value=0>--Seleccione un ingrediente--</option>";
          
          while($datos=mysqli_fetch_assoc($registros)){
              echo "<option value='".  utf8_decode($datos['nom_ingrediente']) ."'>".  utf8_decode($datos['nom_ingrediente']) . "</option>";
          }
          
          echo "</select>
          <input type='submit' value='Borrar' name='Borrar'/>
          </form><br><h2><a href='index2.php'>Volver</a></h2></fieldset>";
      }

}

function anadirContiene($conexion){
	if (isset($_REQUEST['Añadir'])){
          $sql="INSERT INTO Contiene values ('".$_REQUEST['anadirContiene1'] . "','" . $_REQUEST['anadirContiene2'] . "','" . $_REQUEST['cantidad'] . "')";
          if($_REQUEST['anadirContiene1'] == 0 || $_REQUEST['anadirContiene2'] == 0 || empty($_REQUEST['cantidad'])){
              echo "<fieldset><h2>Error: Rellene todos los campos.<br><br>
              <a href='anadirContiene.php'>Volver</a></h2></fieldset>";
          }else{
              if(mysqli_query($conexion,$sql)){
                  echo "<fieldset><h2>Ingredientes añadidos correctamente a la pizza.<br><br>
                  <a href='anadirContiene.php'>Añadir otro ingrediente a la pizza</a> &nbsp &nbsp <a href='index2.php'>Volver</a></h2></fieldset>";
              }else{
                  echo "<fieldset><h2>Este ingrediente ya esta añadido.<br><br>
                  <a href='index2.php'>Volver</a></h2></fieldset>";
              }
          }      
          mysqli_close($conexion);  
	}else{
	    $sql2="SELECT * from Pizza";       
        $sql3="SELECT * from Ingrediente";    
        $registros1=mysqli_query($conexion,$sql2);
        $registros2=mysqli_query($conexion,$sql3);

        echo "<fieldset><h2>Añade un ingrediente a la pizza.</h2>
        <form action='anadirContiene.php' method='post'>
  
        <select name='anadirContiene1'>
	    <option value=0>--Seleccione una pizza--</option>";
	              
            while($datos=mysqli_fetch_assoc($registros1)){
                echo "<option value='".  utf8_decode($datos['nom_pizza'])."'>". utf8_decode($datos['nom_pizza']) . "</option>";
            }
            
	    echo "</select>


	    <select name='anadirContiene2'>                     
        <option value=0>--Seleccione un ingrediente--</option>";
                                                                                                 
            while($datos=mysqli_fetch_assoc($registros2)){
                 echo "<option value='".  utf8_decode($datos['nom_ingrediente']) ."'>".  utf8_decode($datos['nom_ingrediente']) . "</option>";
            }                                   
                                                  
        echo "</select>     
	    <input type='number' placeholder='cantidad' name='cantidad' min='0'>
  
        <input type='submit' value='Añadir' name='Añadir'/>
        </form><br><h2><a href='index2.php'>Volver</a></h2></fieldset>";
	}

}

function borrarContiene($conexion){
    if (isset($_REQUEST['Borrar'])){
	    $sql="delete from Contiene where nom_pizza = '".$_REQUEST['anadirContiene1'] . "' and nom_ingrediente = '". $_REQUEST['anadirContiene2']."'";
            if($_REQUEST['anadirContiene1'] == 0 || $_REQUEST['anadirContiene2'] == 0){
                echo "<fieldset><h2>Error: Rellene todos los campos.<br><br>
                <a href='borrarContiene.php'>Volver</a></h2></fieldset>";
            }else{
                if(mysqli_query($conexion,$sql)){
                    echo "<fieldset><h2>Ingrediente borrado correctamente de la pizza.<br><br>
                    <a href='borrarContiene.php'>Borrar otro ingrediente de la pizza</a> &nbsp &nbsp <a href='index2.php'>Volver</a></h2></fieldset>";
                }else{
                    echo "<fieldset><h2>Este ingrediente ya esta borrado.<br><br>
                    <a href='index2.php'>Volver</a></h2></fieldset>";
                }
            }
            mysqli_close($conexion);
          }else{
              $sql2="SELECT * from Pizza";
          $sql3="SELECT * from Ingrediente";
          $registros1=mysqli_query($conexion,$sql2);
          $registros2=mysqli_query($conexion,$sql3);
  
          echo "<fieldset><h2>Borra un ingrediente de la pizza.</h2>
          <form action='borrarContiene.php' method='post'>
    
          <select name='anadirContiene1'>
              <option value=0>--Seleccione una pizza--</option>";
  
              while($datos=mysqli_fetch_assoc($registros1)){
                  echo "<option value='".  utf8_decode($datos['nom_pizza'])."'>".  utf8_decode($datos['nom_pizza']) . "</option>";
              }
  
              echo "</select>
  
  
              <select name='anadirContiene2'>                     
          <option value=0>--Seleccione un ingrediente--</option>";
  
              while($datos=mysqli_fetch_assoc($registros2)){
                   echo "<option value='". utf8_decode($datos['nom_ingrediente']) ."'>". utf8_decode($datos['nom_ingrediente']) . "</option>";
              }
  
          echo "</select>     
    
          <input type='submit' value='Borrar' name='Borrar'/>
          </form><br><h2><a href='index2.php'>Volver</a></h2></fieldset>";
          }

}

function listarIngredientes($conexion){

    $sql="SELECT * FROM Ingrediente";
    $registros=mysqli_query($conexion,$sql);

    echo "
    <h1>INGREDIENTES</h1>  <br>  
    <div class='datagrid'><table>
    <thead><tr>
            <th>Ingrediente</th>         
            <th>Unidad</th>
            <th>Tipo</th>
            <th>Veces pedido</th>
    </tr></thead><tbody>";

        while($datos=mysqli_fetch_assoc($registros)){

            echo"<tr>
            <td>" . utf8_decode($datos['nom_ingrediente']) . "</td>    
            <td>$datos[unidad_medida]</td>  
            <td>$datos[tipo]</td>  
            <td>$datos[num_veces]</td>  
            </tr>";
        }   
     
    echo "</tbody></table></div>";       

    mysqli_close($conexion);  
}


?>
