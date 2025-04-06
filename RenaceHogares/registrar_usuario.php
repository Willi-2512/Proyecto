<?php
$conexion = new mysqli("localhost", "root", "", "grupo_hogares");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'];
$cedula = $_POST['cedula'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // encriptar

$sql = "INSERT INTO usuarios (nombre, cedula, telefono, email, direccion, password)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssssss", $nombre, $cedula, $telefono, $email, $direccion, $password);

$response = [];

if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = "Registro exitoso.";
} else {
    $response['success'] = false;
    $response['message'] = "Error: " . $stmt->error;
}

echo json_encode($response);

$stmt->close();
$conexion->close();
?>
