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
            <td>$datos[nom_pizza]</td>            
            <td>$ingredientes</td> 
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
                        echo "<option value='".$pizzas[$x]."'>". $pizzas[$x] . "</option>";
                    }
                 
                echo "</select>

                <p> Ingrediente extra: </p> ";

                echo "<select name='elegirIng" . $i . "'>
                <option value=0>--Seleccione un Ingrediente--</option>";

                    for($x=0;$x < count ($ingrediente) ;$x++){
                        echo "<option value='".$ingrediente[$x]."'>". $ingrediente[$x] . "</option>";
                    }
             
                echo "</select>

                <br>----------------------------------------------------------------------------<br>";
      
            }

            echo "<input type='submit' value='Siguiente' name='seleccionarPizzas' /> <br><br>";   
            echo "<a href='hacerPedido.php'> Volver </a>";

        }else{
            echo "<h2>Seleccione al menos una pizza</h2>
            <a href='hacerPedido.php'>Volver</a></fieldset>";
	
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
            <td>" . $pizzas[$i] . "</td>            
            <td>" . $ingredientes[$i] . "</td> 
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
        echo "<fieldset><h2>Error: Seleccione las Pizzas.<br>
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
    </form></fieldset> <br>

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
        $sql="SELECT dni_cliente, p.num_pedido, nom_pizza, unidades, ing_adicional, unidades_ing_adicional, fechahora, importe FROM pedido p, lineapedido l order by dni_cliente, p.num_pedido asc";
    }else{
        $sql="SELECT dni_cliente, p.num_pedido, nom_pizza, unidades, ing_adicional, unidades_ing_adicional, fechahora, importe FROM pedido p, lineapedido l where p.num_pedido='$numPedido' order by dni_cliente, p.num_pedido asc";
    }
   
    $registros=mysqli_query($conexion,$sql);

    echo "
    <h1>Pedidos</h1><br>  

    <fieldset><form action='listarPedidos.php' method='post'>
    <input type='number' placeholder='ID pedido' name='pedido'/>
    <input type='submit' value='Buscar' name='Buscar'/>
    </form></fieldset> <br>

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
        $sql="INSERT INTO Pizza values ('". $_REQUEST['nombre'] . "','" . $_REQUEST['tiempo'] . "','" . $_REQUEST['precio'] . "','0','0')";
        if(mysqli_query($conexion,$sql)){
            echo "<fieldset><h2>Pizza añadida correctamente.<br><br>
            <a href='index2.php'>Volver</a></h2></fieldset>";
        }else{
            echo "<fieldset><h2>Esta pizza ya esta añadida.<br><br>
            <a href='index2.php'>Volver</a></h2></fieldset>";
        }
        mysqli_close($conexion);  
    }else{
        echo "<fieldset><h2>Añade un pizza a la base de datos.</h2>
        <form action='anadirPizzas.php' method='post'>
        <input type='text' placeholder='nombre' name='nombre'/>
        <input type='number' placeholder='tiempo preparacion' name='tiempo'/>
        <input type='number' placeholder='precio' name='precio'/>
        <input type='submit' value='Añadir' name='Añadir'/>
        </form></fieldset>";
    }

}

function borrarPizzas($conexion){
    
    if (isset($_REQUEST['Borrar'])){
        $sql="DELETE FROM Pizza WHERE nom_pizza='". $_REQUEST['nombre'] . "'";
        echo "<fieldset><h2>Pizza eliminada correctamente.<br><br>
        <a href='index2.php'>Volver</a></h2></fieldset>";
        mysqli_close($conexion);  
    }else{
        echo "<fieldset><h2>Borre un pizza de la base de datos.</h2>
        <form action='borrarPizzas.php' method='post'>
        <input type='text' placeholder='nombre' name='nombre'/>
        <input type='submit' value='Borrar' name='Borrar'/>
        </form></fieldset>";
    }

}

function anadirIngredientes($conexion){
   
}

function borrarIngredientes($conexion){
    
}


?>