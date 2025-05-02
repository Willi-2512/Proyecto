<?php
session_start();
$usuario_nombre = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;
?>
<!DOCTYPE html>
<html lang="es-mx">
<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte Técnico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
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

    <main class="presentacion"> 
        <section class="presentacion_contenido">
            <h1 class="presentacion_titulo">
                <strong class="titulo-resaltado">Soporte Técnico</strong>
            </h1>
            <p class="presentacion_parrafo">
                En caso de experimentar cualquier inconveniente técnico con nuestra plataforma, ya sea con el acceso, la visualización de contenido o alguna funcionalidad específica, no dude en ponerse en contacto con nuestro equipo de soporte especializado. 
                Estamos comprometidos en brindarle la asistencia necesaria para resolver cualquier problema de manera rápida y eficiente. A continuación, le proporcionamos los canales de comunicación habilitados:
            </p>
        </section>

        <div class="container">
            <h2>Datos de contacto:</h2>
            <ul>
                <li><strong>Teléfono Fijo:</strong> (601) 999999</li>
                <li><strong>Correo Electrónico:</strong> <a href="mailto:renacehogares@gmail.com">renacehogares@gmail.com</a></li>
                <li><strong>WhatsApp:</strong> <a href="https://wa.me/573111111111" target="_blank">3111111111</a></li>
            </ul>
            <p>Recuerde que nuestro equipo de soporte está disponible para atenderle y ayudarle a resolver cualquier inconveniente técnico que pueda surgir. No dude en ponerse en contacto con nosotros a través de cualquiera de los métodos mencionados. ¡Estamos aquí para ayudarte!</p>
        </div>
    </main>

    <footer class="footer">
        <p>Desarrollado por GrupoHogares</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>