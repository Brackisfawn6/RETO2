<?php

function Login($conexion,$dni,$password){

    $sql="SELECT * FROM Cliente";
    $registros=mysqli_query($conexion,$sql);
    
    while ($datos = mysqli_fetch_assoc($registros)){

        if ($datos['DNI'] == $dni){
            if ($datos['password'] == $password){
                echo "ACCESO PERMITIDO";
            }else{
                echo "ACCESO DENEGADO: contraseña incorrecta";
            }
        }
        else{
            echo "Cliente no encontrado";
        }

    }

    mysqli_close($conexion);

}

function Registrarse($conexion,$dni,$nombre,$direccion,$poblacion,$telefono,$email,$password){

    $sql="INSERT INTO Cliente values ('$dni','$nombre','$direccion','$poblacion','$telefono','$email',current_date(),'$password')";
    $registros=mysqli_query($conexion,$sql);
    echo "$sql";

    if (mysqli_query($conexion, $sql)) {
        echo "User created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }

    mysqli_close($conexion);  

}

function validar_dni ($dni) {

    $letra = substr($dni, -1);
    $numeros = substr($dni, 0, -1);
    $valido;
    if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1) == $letra && strlen($letra) == 1 && strlen ($numeros) == 8 ){
      $valido=true;
    }else{
      $valido=false;
    }   
    return $valido;
}

?>