<?php
session_start();
$usuario_nombre = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;
$usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : null;
$mensaje = "";

if (!$usuario_id) {
    header("Location: sesion.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = trim($_POST['tipo_solicitud']);
    $descripcion = trim($_POST['descripcion']);

    $conn = new mysqli("localhost", "root", "", "proyecto2025h");
    if ($conn->connect_error) {
        $mensaje = '<div class="alert alert-danger">Error de conexión: ' . $conn->connect_error . '</div>';
    } else {
        $tipo = $conn->real_escape_string($tipo);
        $descripcion = $conn->real_escape_string($descripcion);
        // El estado por defecto es 'En espera' (por la base de datos)
        $sql = "INSERT INTO solicitudes (usuario_id, tipo_solicitud, descripcion, fecha_solicitud) VALUES ($usuario_id, '$tipo', '$descripcion', NOW())";
        if ($conn->query($sql) === TRUE) {
            $mensaje = '<div class="alert alert-success">¡Solicitud enviada correctamente!</div>';
        } else {
            $mensaje = '<div class="alert alert-danger">Error al enviar la solicitud: ' . $conn->error . '</div>';
        }
        $conn->close();
    }
}

// Obtener solicitudes del usuario con estado
$solicitudes = [];
$conn = new mysqli("localhost", "root", "", "proyecto2025h");
if (!$conn->connect_error) {
    $sql = "SELECT tipo_solicitud, descripcion, fecha_solicitud, estado FROM solicitudes WHERE usuario_id = $usuario_id ORDER BY fecha_solicitud DESC";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $solicitudes[] = $row;
        }
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
    <title>Crear Solicitud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">

     <style>
        .boton-flotante {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            border: none;
            border-radius: 50%;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            z-index: 1000; 
        }

        .boton-flotante img {
            width: 30px;
            height: 30px;
        }

        .boton-flotante:hover {
            background-color: #0056b3;
        }
        .logo {
            width: 100px; 
            height: 120px;
            margin-right: 20px; 
        }
        .header_menu {
            display: flex;
            justify-content: flex-start; 
            align-items: center;
            width: 100%; 
        }
        .header_menu a {
            margin-left: 15px;
            margin-right: 15px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        .header .logo-container {
            display: flex;
            align-items: center;
        }
        .header_menu {
            margin-left: 100px; 
        }
    </style>

</head>
<body>
    <header class="header">

        <div class="logo-container">
            <a class="header_enlaces mx-3" href="index.php">
            <img src="imagenes/logo.png" alt="Logo" class="logo">
            </a>
        </div>

        <nav class="header_menu d-flex justify-content-center align-items-center position-relative">
            <?php if ($usuario_nombre): ?>
                <a class="header_enlaces mx-3" href="solicitud.php">Solicitud</a>
            <?php endif; ?>
            <a class="header_enlaces mx-3" href="mapa.php">Mapa Interactivo</a>
            <a class="header_enlaces mx-3" href="soporte.php">Contacto y Soporte</a>
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

    <main class="container mt-4">
        <h1 class="presentacion_titulo text-center">
            <strong class="titulo-resaltado">Crear Solicitud de Ayuda</strong>
        </h1>
        <!-- Mensaje de tiempos de espera y estados -->
        <div class="alert alert-info text-center mb-4">
            <strong>Importante:</strong> Al enviar tu solicitud, será atendida en el menor tiempo posible. El tiempo de respuesta puede variar según la demanda y la prioridad de los casos.<br>
            <strong>Estados de tu solicitud:</strong>
            <ul class="mb-0" style="display:inline-block;text-align:left;">
                <li><span class="badge bg-warning text-dark">En espera</span>: Tu solicitud fue recibida y está pendiente de revisión.</li>
                <li><span class="badge bg-primary">En proceso</span>: Tu solicitud está siendo atendida por nuestro equipo.</li>
                <li><span class="badge bg-success">Completada</span>: Tu solicitud ha sido resuelta.</li>
            </ul>
            ¡Gracias por tu paciencia!
        </div>
        <?php if ($mensaje) echo $mensaje; ?>
        <div class="row justify-content-center">
            <div class="col-md-7">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="tipo_solicitud" class="form-label">Tipo de Solicitud</label>
                        <select class="form-select" id="tipo_solicitud" name="tipo_solicitud" required>
                            <option value="">Seleccione una opción</option>
                            <option value="Reparación de vivienda">Reparación de vivienda</option>
                            <option value="Asistencia alimentaria">Asistencia alimentaria</option>
                            <option value="Apoyo psicológico">Apoyo psicológico</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enviar Solicitud</button>
                </form>
            </div>
        </div>

        <!-- Apartado para ver solicitudes del usuario con estado -->
        <div class="row justify-content-center mt-5">
            <div class="col-md-10">
                <h2 class="presentacion_titulo text-center mb-3"><strong class="titulo-resaltado">Mis Solicitudes</strong></h2>
                <?php if (count($solicitudes) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Tipo de Solicitud</th>
                                    <th>Descripción</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Obtener también la observación de cada solicitud
                                $conn = new mysqli("localhost", "root", "", "proyecto2025h");
                                foreach ($solicitudes as $sol) {
                                    $observacion = '';
                                    if ($conn && !$conn->connect_error) {
                                        $id = isset($sol['id']) ? intval($sol['id']) : 0;
                                        $sqlObs = "SELECT observacion FROM solicitudes WHERE usuario_id = $usuario_id AND fecha_solicitud = '" . $conn->real_escape_string($sol['fecha_solicitud']) . "' LIMIT 1";
                                        $resObs = $conn->query($sqlObs);
                                        if ($resObs && $rowObs = $resObs->fetch_assoc()) {
                                            $observacion = $rowObs['observacion'];
                                        }
                                    }
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($sol['tipo_solicitud']); ?></td>
                                    <td><?php echo htmlspecialchars($sol['descripcion']); ?></td>
                                    <td><?php echo htmlspecialchars($sol['fecha_solicitud']); ?></td>
                                    <td>
                                        <?php
                                        $estado = strtolower($sol['estado']);
                                        if ($estado == 'en espera') {
                                            echo '<span class="badge bg-warning text-dark">En espera</span>';
                                        } elseif ($estado == 'en proceso') {
                                            echo '<span class="badge bg-primary">En proceso</span>';
                                        } elseif ($estado == 'completada' || $estado == 'completado') {
                                            echo '<span class="badge bg-success">Completada</span>';
                                        } else {
                                            echo '<span class="badge bg-secondary">'.htmlspecialchars($sol['estado']).'</span>';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($observacion); ?></td>
                                </tr>
                                <?php } if ($conn) $conn->close(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center">No tienes solicitudes registradas.</div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <footer class="footer mt-5">
        <p>Desarrollado por GrupoHogares</p>
         <a class="header_enlaces mx-3" href="informacion.php">Información</a>
            <a class="header_enlaces mx-3" href="condiciones.php">Términos y condiciones</a>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>