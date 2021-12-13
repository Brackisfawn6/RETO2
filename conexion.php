<?php
$servername = "localhost";
$database = "pizzeriareto";
$username = "root";
$password = "";

$conexion = mysqli_connect($servername, $username, $password, $database);

if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}else{
    echo "Connected successfully <br><br>";
}

?>