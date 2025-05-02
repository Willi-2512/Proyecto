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
    <title>Mapa Interactivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY&callback=initMap" async defer></script> <!-- Aquí debes reemplazar TU_API_KEY con tu propia clave API de Google Maps -->
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
            <?php if ($usuario_nombre): ?>
                <a class="header_enlaces mx-3" href="informacion.php">Información</a>
                <a class="header_enlaces mx-3" href="logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a class="header_enlaces mx-3" href="sesion.php">Iniciar sesión</a>
            <?php endif; ?>
            <a class="header_enlaces mx-3" href="condiciones.php">Términos y condiciones</a>
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
                <strong class="titulo-resaltado">Mapa Interactivo</strong>
            </h1>
            <p class="presentacion_parrafo">Encontrar ubicacion del hogar afect