<?php
session_start();
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos (ajusta los datos de conexión)
    $host = "localhost";
    $usuario = "root";
    $clave = "";
    $bd = "proyecto2025h"; // Cambia aquí el nombre de la base de datos

    $conn = new mysqli($host, $usuario, $clave, $bd);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Verificar si el usuario existe
    $sql = "SELECT id, nombre, password FROM usuarios WHERE email='$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario_nombre'] = $row['nombre'];
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
        <nav class="header_menu d-flex justify-content-center">
            <a class="header_enlaces mx-3" href="index.html">Inicio</a>
            <a class="header_enlaces mx-3" href="solicitud.html">Solicitud</a>
            <a class="header_enlaces mx-3" href="mapa.html">Mapa Interactivo</a>
            <a class="header_enlaces mx-3" href="soporte.html">Contacto y Soporte</a>
            <a class="header_enlaces mx-3" href="sesion.php">Iniciar sesión</a>
            <a class="header_enlaces mx-3" href="condiciones.html">Terminos y condiciones</a>
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
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>Desarrollado por GrupoHogares</p>
    </footer>

    <!-- Modal de mensaje -->
    <div class="modal fade" id="mensajeModal" tabindex="-1" aria-labelledby="mensajeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="mensajeModalLabel">Aviso</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <?php if ($mensaje) echo $mensaje; ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
          </div>
        </div>
      </div>
    </div>

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
