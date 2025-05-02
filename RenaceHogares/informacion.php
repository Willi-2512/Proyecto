<?php
session_start();
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: sesion.php");
    exit();
}
$usuario_nombre = $_SESSION['usuario_nombre'];
$usuario_id = $_SESSION['usuario_id'];
$mensaje = "";

// Actualizar datos solo si se envió el formulario completo (no AJAX por campo)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_todos'])) {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $cedula = trim($_POST['cedula']);
    $direccion = trim($_POST['direccion']);

    $conn = new mysqli("localhost", "root", "", "proyecto2025h");
    if ($conn->connect_error) {
        $mensaje = '<div class="alert alert-danger">Error de conexión: ' . $conn->connect_error . '</div>';
    } else {
        $nombre = $conn->real_escape_string($nombre);
        $email = $conn->real_escape_string($email);
        $telefono = $conn->real_escape_string($telefono);
        $cedula = $conn->real_escape_string($cedula);
        $direccion = $conn->real_escape_string($direccion);

        $sql = "UPDATE usuarios SET nombre='$nombre', email='$email', telefono='$telefono', cedula='$cedula', direccion='$direccion' WHERE id=$usuario_id";
        if ($conn->query($sql) === TRUE) {
            $mensaje = '<div class="alert alert-success">Datos actualizados correctamente.</div>';
            $_SESSION['usuario_nombre'] = $nombre;
            $usuario_nombre = $nombre;
        } else if ($conn->errno == 1062) {
            $mensaje = '<div class="alert alert-danger">El correo ya está registrado por otro usuario.</div>';
        } else {
            $mensaje = '<div class="alert alert-danger">Error al actualizar: ' . $conn->error . '</div>';
        }
        $conn->close();
    }
}

// Obtener datos completos del usuario desde la base de datos
$conn = new mysqli("localhost", "root", "", "proyecto2025h");
$usuario = [];
if (!$conn->connect_error) {
    $sql = "SELECT nombre, email, telefono, cedula, direccion FROM usuarios WHERE id = $usuario_id LIMIT 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es-mx">
<head>
    <meta charset="UTF-8">
    <title>Información de usuario</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .info-card {
            margin-top: 40px;
            box-shadow: 0 4px 16px rgba(106,102,157,0.15);
            border: 2px solid #6A669D;
            border-radius: 16px;
            background: #f8f9fa;
        }
        .info-icon {
            font-size: 3rem;
            color: #6A669D;
        }
        .info-header {
            background: #6A669D;
            color: #fff;
            border-radius: 16px 16px 0 0;
            padding: 1.5rem 1rem 1rem 1rem;
            text-align: center;
        }
        .edit-btn {
            border: none;
            background: none;
            color: #6A669D;
            font-size: 1.3rem;
            margin-left: 10px;
            cursor: pointer;
        }
        .edit-btn:focus {
            outline: none;
        }
        .edit-input {
            width: 70%;
            display: inline-block;
            margin-right: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <header class="header">
        <nav class="header_menu d-flex justify-content-center align-items-center position-relative">
            <a class="header_enlaces mx-3" href="index.php">Inicio</a>
            <?php if ($usuario_nombre && (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin')): ?>
                <a class="header_enlaces mx-3" href="solicitud.php">Solicitud</a>
            <?php endif; ?>
            <?php if ($usuario_nombre && isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin'): ?>
                <a class="header_enlaces mx-3" href="admin_solicitudes.php">Panel Admin</a>
            <?php endif; ?>
            <a class="header_enlaces mx-3" href="mapa.php">Mapa Interactivo</a>
            <a class="header_enlaces mx-3" href="soporte.php">Contacto y Soporte</a>
            <a class="header_enlaces mx-3" href="informacion.php">Información</a>
            <a class="header_enlaces mx-3" href="condiciones.php">Términos y condiciones</a>
            <?php if ($usuario_nombre): ?>
                <a class="header_enlaces mx-3" href="logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a class="header_enlaces mx-3" href="sesion.php">Iniciar sesión</a>
            <?php endif; ?>
            <?php if ($usuario_nombre): ?>
                <span class="fw-bold text-primary position-absolute end-0 me-4">
                    <?php echo htmlspecialchars($usuario_nombre); ?>
                </span>
            <?php endif; ?>
        </nav>
    </header>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <?php if ($mensaje) echo $mensaje; ?>
                <div class="card info-card">
                    <div class="info-header">
                        <i class="bi bi-person-circle info-icon"></i>
                        <h2 class="mt-2 mb-0">¡Bienvenido, <?php echo htmlspecialchars($usuario_nombre); ?>!</h2>
                        <p class="mb-0">Esta es tu información personal registrada</p>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item d-flex align-items-center">
                                    <strong class="me-2">Nombre:</strong>
                                    <input type="text" class="form-control ms-2" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?>" required>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <strong class="me-2">Correo:</strong>
                                    <input type="email" class="form-control ms-2" name="email" value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>" required>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <strong class="me-2">Teléfono:</strong>
                                    <input type="text" class="form-control ms-2" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?>" required pattern="[0-9]*" inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'')">
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <strong class="me-2">Cédula:</strong>
                                    <input type="text" class="form-control ms-2" name="cedula" value="<?php echo htmlspecialchars($usuario['cedula'] ?? ''); ?>" required pattern="[0-9]*" inputmode="numeric" oninput="this.value=this.value.replace(/\D/g,'')">
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <strong class="me-2">Dirección:</strong>
                                    <input type="text" class="form-control ms-2" name="direccion" value="<?php echo htmlspecialchars($usuario['direccion'] ?? ''); ?>" required>
                                </li>
                            </ul>
                            <div class="mt-4 text-center">
                                <button type="submit" name="actualizar_todos" class="btn btn-success">
                                    <i class="bi bi-pencil-square"></i> Actualizar datos
                                </button>
                                <a href="solicitud.php" class="btn btn-primary ms-2">Ir a Solicitud de Ayuda</a>
                            </div>
                        </form>
                        <div id="mensaje-actualizacion" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="footer mt-5">
        <p>Desarrollado por GrupoHogares</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
