<?php
session_start();
if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: sesion.php");
    exit();
}
$usuario_nombre = $_SESSION['usuario_nombre'];
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
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <header class="header">
        <nav class="header_menu d-flex justify-content-center align-items-center position-relative">
            <a class="header_enlaces mx-3" href="index.php">Inicio</a>
            <?php if ($usuario_nombre): ?>
                <a class="header_enlaces mx-3" href="solicitud.php">Solicitud</a>
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
                <div class="card info-card">
                    <div class="info-header">
                        <i class="bi bi-person-circle info-icon"></i>
                        <h2 class="mt-2 mb-0">¡Bienvenido, <?php echo htmlspecialchars($usuario_nombre); ?>!</h2>
                        <p class="mb-0">Esta es tu información personal registrada</p>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></li>
                            <?php if (isset($_SESSION['usuario_email'])): ?>
                                <li class="list-group-item"><strong>Correo:</strong> <?php echo htmlspecialchars($_SESSION['usuario_email']); ?></li>
                            <?php endif; ?>
                            <!-- Puedes agregar más datos aquí si los guardas en $_SESSION -->
                        </ul>
                        <div class="mt-4 text-center">
                            <a href="solicitud.php" class="btn btn-primary">Ir a Solicitud de Ayuda</a>
                        </div>
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
