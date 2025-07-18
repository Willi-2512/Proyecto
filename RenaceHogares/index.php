<?php
session_start();
$usuario_nombre = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;
$usuario_rol = isset($_SESSION['usuario_rol']) ? $_SESSION['usuario_rol'] : null;
?>
<!DOCTYPE html>
<html lang="es-mx">
<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            <?php if ($usuario_nombre && $usuario_rol !== 'admin'): ?>
                <a class="header_enlaces mx-3" href="solicitud.php">Solicitud</a>
            <?php endif; ?>
            <?php if ($usuario_nombre && $usuario_rol === 'admin'): ?>
                <a class="header_enlaces mx-3" href="admin_solicitudes.php">Panel Admin</a>
            <?php endif; ?>
            <a class="header_enlaces mx-3" href="mapa.php">Mapa Interactivo</a>
            <a class="header_enlaces mx-3" href="soporte.php">Contacto y Soporte</a>
            <?php if ($usuario_nombre): ?>
                <a class="header_enlaces mx-3" href="logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a class="header_enlaces mx-3" href="sesion.php">Iniciar sesión</a>
                <a class="header_enlaces mx-3" href="condiciones.php">Términos y condiciones</a>
            <?php endif; ?>
            <?php if ($usuario_nombre): ?>
                <span class="fw-bold text-primary position-absolute end-0 me-4">
                    <?php echo htmlspecialchars($usuario_nombre); ?>
                </span>
            <?php endif; ?>
        </nav>
    </header>

    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="imagenes/mathieu-stern-tv7GF92ZWvs-unsplash.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="imagenes/milivoj-kuhar-Te48TPzdcU8-unsplash.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="imagenes/tierra-mallorca-rgJ1J8SDEAY-unsplash.jpg" alt="Third slide">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <main class="presentacion"> 
        <section class="presentacion_contenido">
            <h1 class="presentacion_titulo">
                <strong class="titulo-resaltado">Juntos Reconstruimos lo que el Desastre se Llevó
                </strong>
            </h1>
            <p class="presentacion_parrafo">En momentos difíciles, la solidaridad y el apoyo son nuestra mayor fortaleza. 
                Esta plataforma está diseñada para ayudarte a recuperar tu hogar y tu vida después de un desastre natural.
                Aquí encontrarás recursos, asistencia y una comunidad que te acompañará en cada paso hacia
                la rehabilitación.
            </p>
            <div class="botones">
                <a class="botones_estilo" href="https://instagram.com/">
                    <img src="imagenes/boton-de-informacion.png" width="20px" height="20px">Más Información
                </a>
            </div>
        </section>

        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="presentacion_titulo">
                        <strong class="titulo-resaltado">Tu Hogar, Nuestra Prioridad
                        </strong>
                    </h1>
                    <p class="parrafo1">"Sabemos que tu vivienda es más que un espacio; es tu refugio y tu tranquilidad. 
                        Por eso, ofrecemos herramientas y recursos para que puedas rehabilitar tu hogar
                        de manera segura y eficiente. No estás solo, estamos aquí para ayudarte."
                    </p>
                </div>
                <div class="col">
                    <img class="d-block w-100" src="imagenes/familia-feliz-perro-mudandose-nuevo-hogar_23-2149749178.avif" alt="imagen familia feliz">
                </div>
            </div>
        </div>
     
    </main>

    <footer class="footer">
        <p>Desarrollado por GrupoHogares</p>
        <a class="header_enlaces mx-3" href="informacion.php">Información</a>
        <a class="header_enlaces mx-3" href="condiciones.php">Términos y condiciones</a>
    </footer>

    <!-- Botón flotante de mensaje -->
    <a href="https://docs.google.com/forms/d/1cMO0dX7vkM-kzsmDY4AarqnToxqJpTYEr7XKo67hmWo/edit?usp=drive_web" target="_blank">
        <button class="boton-flotante">
            <img src="imagenes/mensaje.png" alt="Encuesta de satisfaccion">
        </button>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>