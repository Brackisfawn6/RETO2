<?php

function Login($conexion,$dni,$password){

    $sql="SELECT * FROM Cliente";
    $registros=mysqli_query($conexion,$sql);

    $encontrar=false;

    if(empty($dni)){
        $mensaje = "Faltan datos";
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
                        $_SESSION["usuario"]= $datos['DNI'];
                    }else{
                        $mensaje= "Contraseña incorrecta";  
                    }
            }
        }
        if($encontrar == false){
            $mensaje = "Cliente no encontrado";
        }
    }  

    return $mensaje;
    mysqli_close($conexion);
      
}   

function Registrarse($conexion,$dni,$nombre,$direccion,$poblacion,$telefono,$email,$password){

    $sql="INSERT INTO Cliente values ('$dni','$nombre','$direccion','$poblacion','$telefono','$email', now(),'$password',NULL,0)";
    
    if(empty($dni) || empty($nombre) || empty($direccion) || empty($poblacion) || empty($telefono) || empty($email) || empty($password)){
        $mensaje = "Rellene todos los campos.";
    }elseif (!mysqli_query($conexion, $sql)) {
        $mensaje = "Este DNI ya esta registrado";
    } else {
        $mensaje = "Usuario registrado correctamente.";
        $registros=mysqli_query($conexion,$sql);
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
    session_start();

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

        echo "<tr>
                    <td colspan='2'><font color=#ec0b0b>TOTAL</td>
                    <td><font color=#ec0b0b>" . number_format($total,2,",",".") . " € </td>
              </tr>
        </tbody></table></div> <br><br>"; 


        echo "<form action='registrarPedido.php' method='REQUEST'>  
        <div class='confirmar'>
            <input type='submit' value='Confirmar Pedido' name='confirmarPedido' />
        </div>
        </form>";
    }else{
        echo "<fieldset><h2>Error: Seleccione las Pizzas.</h2></fieldset> ";
    }

    mysqli_close($conexion);  
          
}

function anadirPedido($conexion,$dni,$importe){

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

    mysqli_close($conexion);  

}

function anadirLineaPedido($conexion){

}
?>