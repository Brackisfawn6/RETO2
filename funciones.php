<?php

function Login($conexion,$dni){

    $sql="SELECT * FROM cliente";
    $registros=mysqli_query($conexion,$sql);

    while ($datos = mysqli_fetch_assoc($registros)){

        if ($datos['DNI'] == $dni){
            echo "Cliente encontrado";
        }
        else{
            echo "Cliente no encontrado";
        }

    }

}

function Registrarse($conexion,$dni){

    $sql="SELECT * FROM cliente";
    $registros=mysqli_query($conexion,$sql);

    while ($datos = mysqli_fetch_assoc($registros)){

        if ($datos['DNI'] == $dni){
            echo "Cliente encontrado";
        }
        else{
            echo "Cliente no encontrado";
        }

    }

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