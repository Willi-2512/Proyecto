<?php
session_start();
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $usuario = "root";
    $clave = "";
    $bd = "proyecto2025h";

    $conn = new mysqli($host, $usuario, $clave, $bd);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, nombre, password, rol FROM usuarios WHERE email='$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario_nombre'] = $row['nombre'];
            $_SESSION['usuario_rol'] = $row['rol'];
            header("Location: index.php");
            exit();
        } else {
            $mensaje = "Contraseña incorrecta. Por favor, intenta de nuevo.";
        }
    } else {
        $mensaje = "Te debes registrar.";
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es-mx">
<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <nav class="header_menu d-flex justify-content-center align-items-center position-relative">
            <a class="header_enlaces mx-3" href="index.php">Inicio</a>
            <?php if (isset($_SESSION['usuario_nombre'])): ?>
                <a class="header_enlaces mx-3" href="solicitud.php">Solicitud</a>
            <?php endif; ?>
            <a class="header_enlaces mx-3" href="mapa.php">Mapa Interactivo</a>
            <a class="header_enlaces mx-3" href="soporte.php">Contacto y Soporte</a>
            <?php if (isset($_SESSION['usuario_nombre'])): ?>
                <a class="header_enlaces mx-3" href="informacion.php">Información</a>
                <a class="header_enlaces mx-3" href="logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a class="header_enlaces mx-3" href="sesion.php">Iniciar sesión</a>
            <?php endif; ?>
            <a class="header_enlaces mx-3" href="condiciones.php">Términos y condiciones</a>
            <?php if (isset($_SESSION['usuario_nombre'])): ?>
                <span class="fw-bold text-primary position-absolute end-0 me-4">
                    <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
                </span>
            <?php endif; ?>
        </nav>
    </header>

    <main class="container">
        <h1 class="presentacion_titulo text-center">
            <strong class="titulo-resaltado">Iniciar sesión</strong>
        </h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="loginForm" method="POST" action="sesion.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="botones_estilo w-100">Iniciar sesión</button>
                </form>
                <div class="mt-3">
                    <a class="botones_estilo w-100" href="registro.php">¿No te has registrado?</a> 
                </div>
                <?php if ($mensaje): ?>
                    <div class="alert alert-danger mt-3"><?php echo $mensaje; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>Desarrollado por GrupoHogares</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    // Mostrar el modal si hay mensaje
    <?php if ($mensaje): ?>
        window.onload = function() {
            var myModal = new bootstrap.Modal(document.getElementById('mensajeModal'));
            myModal.show();
        };
    <?php endif; ?>
    </script>
</body>
</html>
