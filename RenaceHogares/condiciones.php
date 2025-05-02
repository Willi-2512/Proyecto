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
    <title>Términos y Condiciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
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
            <?php if ($usuario_nombre): ?>
                <a class="header_enlaces mx-3" href="informacion.php">Información</a>
                <a class="header_enlaces mx-3" href="condiciones.php">Términos y condiciones</a>
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

    <main class="presentacion"> 
        <section class="presentacion_contenido">
            <h1 class="presentacion_titulo">
                <strong class="titulo-resaltado">Términos y Condiciones de Uso
                </strong>
            </h1>
            <p class="presentacion_parrafo">Por favor, lea los siguientes términos y condiciones antes de usar la plataforma RenaceHogares. Al utilizar este sitio web, acepta estos términos en su totalidad.</p>
            
            <h3 class="presentacion_titulo">1. Aceptación de los Términos</h3>
            <p>Al acceder y utilizar este sitio web, usted acepta cumplir con estos términos y condiciones, así como con las leyes y regulaciones aplicables. Si no está de acuerdo con alguno de estos términos, le recomendamos no utilizar este sitio web.</p>

            <h3 class="presentacion_titulo">2. Uso del Sitio</h3>
            <p>Este sitio web está diseñado para brindar apoyo y asistencia a las personas afectadas por desastres naturales. Solo está permitido utilizarlo para los fines descritos en este contexto. Cualquier uso no autorizado de la plataforma, incluyendo la distribución de contenido ilegal, está prohibido.</p>

            <h3 class="presentacion_titulo">3. Privacidad y Protección de Datos</h3>
            <p>Nos comprometemos a proteger su privacidad. Todos los datos personales proporcionados en la plataforma se utilizarán únicamente con fines de asistencia en situaciones de emergencia, y se manejarán conforme a las leyes de privacidad vigentes en Colombia.</p>

            <h3 class="presentacion_titulo">4. Responsabilidades del Usuario</h3>
            <p>Los usuarios se comprometen a utilizar la plataforma de manera adecuada y responsable. Esto incluye la provisión de información precisa y veraz al completar formularios de solicitud de ayuda y cualquier otra información solicitada en el sitio.</p>

            <h3 class="presentacion_titulo">5. Exenciones y Limitaciones de Responsabilidad</h3>
            <p>La plataforma no será responsable por daños indirectos, incidentales o consecuencias de la utilización del servicio, incluyendo pérdidas de datos o interrupciones del servicio debido a mantenimiento o fallos imprevistos.</p>

            <h3 class="presentacion_titulo">6. Modificaciones de los Términos</h3>
            <p>Nos reservamos el derecho de modificar estos términos y condiciones en cualquier momento. Las modificaciones entrarán en vigor tan pronto como se publiquen en este sitio web, por lo que le recomendamos revisarlos periódicamente.</p>

            <h3 class="presentacion_titulo">7. Ley Aplicable</h3>
            <p>Estos términos y condiciones están regidos por las leyes de la República de Colombia. Cualquier disputa relacionada con el uso de la plataforma se resolverá en los tribunales competentes de Colombia.</p>
             
            <h3 class="presentacion_titulo">6. SLA</h3>
            <p>El presente Acuerdo de Nivel de Servicio (SLA) tiene como objetivo definir los términos y condiciones para el uso de la página web RenaceHogares, dedicada a brindar asistencia y apoyo a las personas afectadas por desastres naturales en Caucasia, Antioquia. Este acuerdo establece las expectativas de disponibilidad, soporte y tiempos de respuesta para los usuarios de la plataforma, que incluye la provisión de información actualizada sobre desastres naturales, una red de ayuda con información sobre refugios, centros de atención, distribución de alimentos y otros recursos, un formulario de solicitud de ayuda, y soporte de emergencia en línea. La página web estará disponible las 24 horas del día, los 7 días de la semana, excepto durante mantenimientos programados que serán notificados con al menos 24 horas de antelación. Se realizará un esfuerzo para minimizar los tiempos de inactividad no planificados, pero estos pueden ser necesarios para mantener o actualizar el sistema. Los usuarios recibirán respuestas a sus consultas generales en un plazo máximo de 24 horas durante días hábiles, mientras que en situaciones de desastre, se garantizará una respuesta inicial dentro de las 2 horas siguientes a la recepción de la solicitud de ayuda, priorizando los casos urgentes. Se proporcionará soporte a través de chat en línea, correo electrónico y un número telefónico de emergencia. Además, se realizarán mantenimientos periódicos con previo aviso de al menos 24 horas y las actualizaciones de contenido sobre alertas de desastres serán realizadas al menos una vez al día, o con mayor frecuencia en casos de emergencia. Los usuarios deberán utilizar la plataforma de manera adecuada y responsable, proporcionando información precisa y actualizada en sus solicitudes de ayuda o reportes de emergencias. Este SLA no será aplicable en casos de fuerza mayor, como desastres naturales, guerras, disturbios civiles u otros eventos fuera del control razonable que impidan el cumplimiento de los términos. Se garantizará la protección de la información personal y sensible de los usuarios, conforme a las leyes de privacidad aplicables en Colombia. Este SLA será revisado periódicamente y podrá ser modificado según sea necesario. Los cambios serán notificados a los usuarios a través de la página web, y al utilizar la plataforma, los usuarios aceptan los términos y condiciones establecidos en este acuerdo.</p>

        </section>
    </main>

    <footer class="footer">
        <p>Desarrollado por GrupoHogares</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>