<?php
$servername = "localhost";
$username = "root";
$password_db = "12345"; // Cambiar si tienes una contraseña configurada
$dbname = "proyecto2025h";

$conn = new mysqli($servername, $username, $password_db, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Error de conexión: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $cedula = $_POST['cedula'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($nombre) || empty($cedula) || empty($telefono) || empty($email) || empty($direccion) || empty($password)) {
        die(json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']));
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, cedula, telefono, email, direccion, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $cedula, $telefono, $email, $direccion, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registro exitoso.']);
    } else {
        if ($conn->errno === 1062) {
            echo json_encode(['success' => false, 'message' => 'El correo ya está registrado.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar: ' . $conn->error]);
        }
    }

    $stmt->close();
}

$conn->close();
?>
