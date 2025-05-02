<?php
session_start();

// Verifica si el usuario es administrador
$usuario_rol = isset($_SESSION['usuario_rol']) ? $_SESSION['usuario_rol'] : (isset($_SESSION['rol']) ? $_SESSION['rol'] : null);
if (!$usuario_rol || $usuario_rol !== 'admin') {
    echo "Acceso denegado.";
    exit;
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "proyecto2025h");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Ordenamiento por fecha
$orden = (isset($_GET['orden']) && $_GET['orden'] === 'asc') ? 'ASC' : 'DESC';

// Procesar cambio de estado, eliminación y observación
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['solicitud_id'], $_POST['nuevo_estado']) && isset($_POST['actualizar'])) {
        $solicitud_id = intval($_POST['solicitud_id']);
        $nuevo_estado = $conexion->real_escape_string($_POST['nuevo_estado']);
        $observacion = isset($_POST['observacion']) ? $conexion->real_escape_string($_POST['observacion']) : '';
        $conexion->query("UPDATE solicitudes SET estado='$nuevo_estado', observacion='$observacion' WHERE id=$solicitud_id");
    }
    if (isset($_POST['solicitud_id']) && isset($_POST['eliminar'])) {
        $solicitud_id = intval($_POST['solicitud_id']);
        $conexion->query("DELETE FROM solicitudes WHERE id=$solicitud_id");
        // Reordenar IDs (no recomendado en producción, pero solicitado)
        $conexion->query("SET @count = 0");
        $conexion->query("UPDATE solicitudes SET id = (@count := @count + 1) ORDER BY id");
        $conexion->query("ALTER TABLE solicitudes AUTO_INCREMENT = 1");
    }
}

// Asegúrate de que la columna 'observacion' exista en la tabla 'solicitudes'
$conexion->query("ALTER TABLE solicitudes ADD COLUMN IF NOT EXISTS observacion TEXT");

// Consulta para obtener todas las solicitudes con estado, datos del usuario y observación
$sql = "SELECT s.id, u.nombre AS usuario, s.tipo_solicitud, s.descripcion, s.fecha_solicitud, s.estado, s.observacion
        FROM solicitudes s
        INNER JOIN usuarios u ON s.usuario_id = u.id
        ORDER BY s.fecha_solicitud $orden";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es-mx">
<head>
    <meta charset="UTF-8">
    <title>Solicitudes de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .admin-table th, .admin-table td {
            vertical-align: middle;
            text-align: center;
        }
        .admin-table th {
            background: #6A669D;
            color: #fff;
        }
        .admin-table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .admin-table tr:nth-child(odd) {
            background: #e5e3d4;
        }
        .estado-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
        }
        .estado-espera {
            background: #fff3cd;
            color: #856404;
        }
        .estado-proceso {
            background: #0d6efd;
            color: #fff;
        }
        .estado-completada {
            background: #198754;
            color: #fff;
        }
        .form-estado {
            margin: 0;
            display: inline-block;
        }
        .form-estado select,
        .form-estado button {
            display: inline-block;
            vertical-align: middle;
        }
        .form-estado select {
            min-width: 120px;
        }
        .btn-trash {
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 4px 8px;
            border-radius: 5px;
            margin-left: 4px;
        }
        .btn-trash:hover {
            background: #b52a37;
            color: #fff;
        }
        .observacion-input {
            min-width: 120px;
            max-width: 200px;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="header_menu d-flex justify-content-center align-items-center position-relative">
            <a class="header_enlaces mx-3" href="index.php">Inicio</a>
            <a class="header_enlaces mx-3" href="admin_solicitudes.php">Panel Admin</a>
            <a class="header_enlaces mx-3" href="mapa.php">Mapa Interactivo</a>
            <a class="header_enlaces mx-3" href="soporte.php">Contacto y Soporte</a>
            <a class="header_enlaces mx-3" href="informacion.php">Información</a>
            <a class="header_enlaces mx-3" href="condiciones.php">Términos y condiciones</a>
            <a class="header_enlaces mx-3" href="logout.php">Cerrar sesión</a>
        </nav>
    </header>
    <main class="container mt-5">
        <h1 class="presentacion_titulo text-center mb-4">
            <strong class="titulo-resaltado">Solicitudes de Usuarios</strong>
        </h1>
        <div class="mb-3 text-end">
            <a href="admin_solicitudes.php?orden=desc" class="btn btn-outline-primary btn-sm <?php if($orden==='DESC') echo 'active'; ?>">
                Más recientes primero
            </a>
            <a href="admin_solicitudes.php?orden=asc" class="btn btn-outline-primary btn-sm <?php if($orden==='ASC') echo 'active'; ?>">
                Más antiguas primero
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Tipo de Solicitud</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Observación</th>
                    </tr>
                </thead>
<tbody>
<?php
// Mostrar el id visual de la solicitud según el orden de la tabla (no el id real de la base de datos)
$rows = [];
while($row = $resultado->fetch_assoc()) {
    $rows[] = $row;
}
$total = count($rows);
if ($orden === 'ASC') {
    $visual_ids = range(1, $total);
} else {
    $visual_ids = range($total, 1);
}
$i = 0;
foreach ($rows as $row):
?>
    <tr>
        <td><?php echo $visual_ids[$i++]; ?></td>
        <td><?php echo htmlspecialchars($row['usuario']); ?></td>
        <td><?php echo htmlspecialchars($row['tipo_solicitud']); ?></td>
        <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
        <td><?php echo htmlspecialchars($row['fecha_solicitud']); ?></td>
        <td>
            <form method="POST" class="form-estado" style="display:inline;">
                <input type="hidden" name="solicitud_id" value="<?php echo $row['id']; ?>">
                <?php
                $estado = strtolower($row['estado']);
                $class = 'estado-badge';
                if ($estado == 'en espera') {
                    $class .= ' estado-espera';
                } elseif ($estado == 'en proceso') {
                    $class .= ' estado-proceso';
                } elseif ($estado == 'completada' || $estado == 'completado') {
                    $class .= ' estado-completada';
                }
                ?>
                <select name="nuevo_estado" class="<?php echo $class; ?> form-select form-select-sm d-inline w-auto" style="font-weight:600;">
                    <option value="En espera" <?php if($row['estado']=='En espera') echo 'selected'; ?>>En espera</option>
                    <option value="En proceso" <?php if($row['estado']=='En proceso') echo 'selected'; ?>>En proceso</option>
                    <option value="Completada" <?php if($row['estado']=='Completada' || $row['estado']=='Completado') echo 'selected'; ?>>Completada</option>
                </select>
        </td>
        <td>
                <input type="text" name="observacion" class="form-control form-control-sm observacion-input d-inline" placeholder="Observación" value="<?php echo htmlspecialchars($row['observacion'] ?? ''); ?>">
                <button type="submit" name="actualizar" class="btn btn-sm btn-primary ms-1">Actualizar</button>
                <button type="submit" name="eliminar" class="btn-trash" onclick="return confirm('¿Seguro que deseas eliminar esta solicitud?');">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>
            </table>
        </div>
    </main>
    <footer class="footer mt-5">
        <p>Desarrollado por GrupoHogares</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conexion->close();
?>
