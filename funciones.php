<?php

function Login($conexion,$dni,$password){

    $sql="SELECT * FROM Cliente";
    $registros=mysqli_query($conexion,$sql);
    
    while ($datos = mysqli_fetch_assoc($registros)){

        if(validar_dni($dni)==false){
            $mensaje = "Formato DNI es incorrecto";
        }else{
            if ($datos['DNI'] == $dni){
                if ($datos['password'] == $password){
                    echo "<meta http-equiv='refresh' content='0 url=index.php'>";
                }else{
                    $mensaje= "ACCESO DENEGADO: contraseña incorrecta";
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

function pagina_login() {
    echo "
	<div class='container'>
		<div class='screen'>
			<div class='screen__content'>
				<form class='login' action='login.php' method='REQUEST'>
					<div class='login__field'>
						<i class='login__icon fas fa-user'></i>
						<input type='text' class='login__input'  name='dni' placeholder='DNI'>
					</div>
					<div class='login__field'>
						<i class='login__icon fas fa-lock'></i>
						<input type='password' class='login__input' name='password' placeholder='Contraseña'>
					</div>
					<button class='button login__submit' type='submit' value='Login' name='Login'>
						<span class='button__text'>INICIAR SESION</span>
						<i class='button__icon fas fa-chevron-right'></i>
					</button>				
				</form>
				<div class='social-login'>
					<a href='registro.php'>Registrarse</a>
				</div>
			</div>
			<div class='screen__background'>
				<span class='screen__background__shape screen__background__shape4'></span>
				<span class='screen__background__shape screen__background__shape3'></span>		
				<span class='screen__background__shape screen__background__shape2'></span>
				<span class='creen__background__shape screen__background__shape1'></span>
			</div>		
		</div>
	</div>";
} 


?>