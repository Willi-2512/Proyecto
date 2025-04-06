<?php
$conexion = new mysqli("localhost", "root", "", "grupo_hogares");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT password FROM usuarios WHERE email = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

$response = [];

if ($stmt->num_rows > 0) {
    $stmt->bind_result($hash_guardado);
    $stmt->fetch();

    if (password_verify($password, $hash_guardado)) {
        $response['success'] = true;
        $response['message'] = "Inicio de sesión exitoso.";
    } else {
        $response['success'] = false;
        $response['message'] = "Contraseña incorrecta.";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Correo no registrado.";
}

echo json_encode($response);

$stmt->close();
$conexion->close();
?>
