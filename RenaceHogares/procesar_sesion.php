<?php
$servername = "localhost";
$username = "root";
$password_db = "12345"; // Cambiar si tienes una contraseña configurada
$dbname = "proyecto2025h";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT nombre, password FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nombre, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            echo 'Inicio de sesión exitoso. Bienvenido, ' . htmlspecialchars($nombre) . '!';
        } else {
            die('Correo o contraseña incorrectos.');
        }
    } else {
        die('Correo o contraseña incorrectos.');
    }

    $stmt->close();
}

$conn->close();
?>
