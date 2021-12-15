<?php
/*$servername = "10.5.12.79";
$database = "PizzeriaReto";
$username = "admin";
$password = "12345678";*/

$servername = "localhost";
$database = "PizzeriaReto";
$username = "root";
$password = "";

$conexion = mysqli_connect($servername, $username, $password, $database);

if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}else{
    echo "Connected successfully <br><br>";
}

?>