<!DOCTYPE html>
<html lang="en" >
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" media="all" href="CSS/listarpizzas.css" />
    <title> King Pizza </title>
    <link rel="shortcut icon" href="Imagenes/logo2.png" />
</head>
<body>

    <?php 
    
    include "conexion.php";
    include "funciones.php";

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

        echo "<tr>
                    <td colspan='2'><font color=#ec0b0b>TOTAL</td>
                    <td><font color=#ec0b0b>" . number_format($total,2,",",".") . " € </td>
              </tr>
        </tbody></table></div>"; 
    }else{
        echo "Error: Seleccione las Pizzas.";
    }
    
    /* 
    for($x=0;$x <  $_SESSION["cantPizzas"] ;$x++){

        $nameRadio="radio".$x;

        if (isset($_REQUEST[$nameRadio])){
            $ing=$_REQUEST[$nameRadio];
        }else{
            $ing="";
        }
        
        echo "$ing <br>";
    }
    */
          




    ?>

 	
</body>
</html>
