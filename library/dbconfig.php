<?php
$host = "localhost";
$username = "root";       
$password = "1234";  
$database = "larubia_db";


$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>