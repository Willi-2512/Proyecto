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
    <script src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY&callback=initMap" async defer></script>
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

    <main class="presentacion"> 
        <section class="presentacion_contenido">
            <h1 class="presentacion_titulo">
                <strong class="titulo-resaltado">Mapa Interactivo</strong>
            </h1>
            <p class="presentacion_parrafo">Encontrar ubicacion del hogar afectado</p>
        </section>

        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col">
                    <h2>Ubicación en el mapa</h2>
                    <div id="map" style="height: 400px; width: 100%;"></div> 
                </div>
            </div>
        </div>
     
    </main>

    <footer class="footer">
        <p>Desarrollado por GrupoHogares</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function initMap() {
            const mapOptions = {
                center: { lat: 19.432608, lng: -99.133209 }, 
                zoom: 12,
            };

            const map = new google.maps.Map(document.getElementById("map"), mapOptions);

            const marker = new google.maps.Marker({
                position: { lat: 19.432608, lng: -99.133209 },
                map: map,
                title: "Ubicación de ejemplo",
            });
        }
    </script>
</body>
</html>