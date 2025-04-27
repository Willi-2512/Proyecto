<?php
$servername = "localhost";
$username = "root";
$password_db = "12345"; 
$dbname = "proyecto2025h";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
    echo "Conexión exitosa a la base de datos '$dbname'.";
}

$conn->close();
?>
