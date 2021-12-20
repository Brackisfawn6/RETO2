<?php

function Login($conexion,$dni,$password){

    $sql="SELECT * FROM Cliente";
    $registros=mysqli_query($conexion,$sql);
    
    while ($datos = mysqli_fetch_assoc($registros)){

        if(empty($dni)){
            $mensaje = "Faltan datos";
        }else{
            if($datos['DNI'] == $dni){
                    if ($datos['password'] == $password){
                        echo "<meta http-equiv='refresh' content='0 url=index.php'>";
                    }elseif(empty($password)){
                        $mensaje= "Faltan datos";
                    }else{
                        $mensaje= "Contraseña incorrecta";
                    }
                }
                else{
                    $mensaje = "Cliente no encontrado";
                }
            }
        }

        return $mensaje;
        mysqli_close($conexion);

}

function Registrarse($conexion,$dni,$nombre,$direccion,$poblacion,$telefono,$email,$password){

    $sql="INSERT INTO Cliente values ('$dni','$nombre','$direccion','$poblacion','$telefono','$email',current_date(),'$password')";
    
    
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

   /* setlocale(LC_ALL, "es_ES.utf8");
    setlocale(LC_TIME, 'es_ES.UTF-8'); 

    $sql= "select * from Pizza";
    $registros=mysqli_query($conexion, $sql);
    
    echo "<table> 
    <tr> <th>Pizzas</th> <th>Precio</th> <tr>";
    while ($datos = mysqli_fetch_assoc($registros)) {
       echo"
        <tr>
            <td>$datos[nom_pizza]</td>
            <td>$datos[precio] €</td>
        </tr>";      
    }

    echo  "</table>";*/


    //Consulta  
    $sql="SELECT * FROM PizzeriaReto.Pizza";
    $registros=mysqli_query($conexion,$sql);

    echo "
    <h2>Nuestras Pizzas</h2>        
    <table> 
    <tr>
            <td>Pizza</td>         
            <td>Ingredientes</td>
            <td>Precio</td>
    </tr>";

        while($datos=mysqli_fetch_assoc($registros)){

            $sql2="select * from PizzeriaReto.Contiene where nom_pizza='$datos[nom_pizza]'";  

            $registros2=mysqli_query($conexion,$sql2);

            $ingredientes="";
              
            while ($datos2=mysqli_fetch_assoc($registros2)){
               $ingredientes=$ingredientes . $datos2['nom_ingrediente'] . "<br>";
            }

            echo"<tr>
            <td>$datos[nom_pizza]</td>            
            <td>$ingredientes</td> 
            <td>$datos[precio] € </td>
            </tr>";
        }   
     
    echo "</table>";       
}


?>