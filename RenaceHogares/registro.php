<?php
session_start();
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "proyecto2025h");
    if ($conn->connect_error) {
        $mensaje = '<div style="background:#f8d7da;color:#721c24;padding:10px;">Error de conexión: ' . $conn->connect_error . '</div>';
    } else {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $cedula = $conn->real_escape_string($_POST['cedula']);
        $telefono = $conn->real_escape_string($_POST['telefono']);
        $email = $conn->real_escape_string($_POST['email']);
        $direccion = $conn->real_escape_string($_POST['direccion']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $rol = $conn->real_escape_string($_POST['rol']);

        // Bloquear registro si el rol es distinto de 'usuario'
        if ($rol !== 'usuario') {
            $mensaje = '<div style="background:#f8d7da;color:#721c24;padding:10px;">No puede registrarse como administrador. Contacte al encargado de la página.</div>';
        } else {
            // Verificar si el correo ya existe antes de intentar registrar
            $sql_check = "SELECT id FROM usuarios WHERE email='$email' LIMIT 1";
            $result_check = $conn->query($sql_check);
            if ($result_check && $result_check->num_rows > 0) {
                $mensaje = '<div style="background:#f8d7da;color:#721c24;padding:10px;">El correo ya está registrado.</div>';
            } else {
                $sql = "INSERT INTO usuarios (nombre, cedula, telefono, email, direccion, password, rol) VALUES ('$nombre', '$cedula', '$telefono', '$email', '$direccion', '$password', '$rol')";
                if ($conn->query($sql) === TRUE) {
                    $mensaje = '<div style="background:#d4edda;color:#155724;padding:10px;">Registro exitoso. Redirigiendo a inicio de sesión...</div>';
                    echo "<script>setTimeout(function(){ window.location.href = 'sesion.php'; }, 2000);</script>";
                } else {
                    $mensaje = '<div style="background:#f8d7da;color:#721c24;padding:10px;">Error al registrar: ' . $conn->error . '</div>';
                }
            }
        }
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es-mx">
<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <nav class="header_menu d-flex justify-content-center align-items-center position-relative">
            <a class="header_enlaces mx-3" href="index.php">Inicio</a>
            <a class="header_enlaces mx-3" href="solicitud.php">Solicitud</a>
            <a class="header_enlaces mx-3" href="mapa.php">Mapa Interactivo</a>
            <a class="header_enlaces mx-3" href="soporte.php">Contacto y Soporte</a>
            <a class="header_enlaces mx-3" href="sesion.php">Iniciar sesión</a>
            <a class="header_enlaces mx-3" href="condiciones.php">Términos y condiciones</a>
        </nav>
    </header>
    <main class="container">
        <h1 class="presentacion_titulo text-center">
            <strong class="titulo-resaltado">Registro</strong>
        </h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if ($mensaje) echo $mensaje; ?>
                <form id="registroForm" method="POST" action="">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="cedula" class="form-label">Cédula</label>
                        <input type="text" class="form-control" id="cedula" name="cedula" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select name="rol" id="rol" class="form-select" required>
                            <option value="usuario" selected>Usuario</option>
                            <option value="admin">Administrador</option>
                        </select>
                        <div id="rolAdvertencia" class="text-danger mt-2" style="display:none;">
                            Para solicitar el rol de administrador debe contactar con el encargado de la página.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enviar</button>
                </form>
            </div>
        </div>
    </main>
    <footer class="footer">
        <p>Desarrollado por GrupoHogares</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    document.getElementById('rol').addEventListener('change', function() {
        const advertencia = document.getElementById('rolAdvertencia');
        if (this.value !== 'usuario') {
            advertencia.style.display = 'block';
        } else {
            advertencia.style.display = 'none';
        }
    });
    document.getElementById('registroForm').addEventListener('submit', function(e) {
        const rol = document.getElementById('rol').value;
        if (rol !== 'usuario') {
            e.preventDefault();
            document.getElementById('rolAdvertencia').style.display = 'block';
            alert('No puede registrarse como administrador. Contacte al encargado de la página.');
        }
    });
    </script>
</body>
</html>