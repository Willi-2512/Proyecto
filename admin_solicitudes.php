1. DESCRIPCIÓN GENERAL
----------------------
RenaceHogares es una plataforma web desarrollada en PHP y MySQL que permite a usuarios afectados por desastres naturales solicitar ayuda, hacer seguimiento a sus solicitudes y recibir observaciones del equipo administrador. El sistema cuenta con roles de usuario y administrador, panel de administración, gestión de solicitudes, y funcionalidades de soporte e información.

2. ESTRUCTURA DE ARCHIVOS PRINCIPALES
-------------------------------------
- index.php: Página principal, menú dinámico según el rol.
- solicitud.php: Permite a usuarios crear solicitudes y ver el estado y observación de cada una.
- admin_solicitudes.php: Panel para administradores donde pueden ver, actualizar estado, agregar observaciones y eliminar solicitudes.
- informacion.php: Permite a los usuarios ver y actualizar sus datos personales.
- soporte.php: Página de contacto y soporte.
- condiciones.php: Página de términos y condiciones.
- registro.php: Registro de nuevos usuarios.
- sesion.php: Inicio de sesión.
- logout.php: Cierre de sesión.
- styles.css: Estilos generales del sitio.
- proyecto2025h.sql: Script de la base de datos MySQL.
- add_observacion_column.sql: Script para agregar la columna 'observacion' a la tabla 'solicitudes'.
3. BASE DE DATOS
----------------
Base de datos: proyecto2025h

Tablas principales:
- usuarios: id, nombre, cedula, telefono, email, direccion, password, fecha_registro, rol
- solicitudes: id, usuario_id, tipo_solicitud, descripcion, fecha_solicitud, estado, observacion

Relaciones:
- solicitudes.usuario_id es clave foránea a usuarios.id

4. FUNCIONALIDADES POR ROL
--------------------------
USUARIO:
- Puede registrarse, iniciar sesión y actualizar sus datos.
- Puede crear solicitudes de ayuda.
- Puede ver el estado y la observación de cada solicitud enviada.
- Puede cerrar sesión.

ADMINISTRADOR:
- Acceso a admin_solicitudes.php (Panel Admin).
- Puede ver todas las solicitudes de todos los usuarios.
- Puede cambiar el estado de una solicitud (En espera, En proceso, Completada).
- Puede agregar o modificar una observación para cada solicitud.
- Puede eliminar solicitudes (los IDs se reordenan automáticamente).
- Puede ordenar las solicitudes por fecha (más recientes o más antiguas).

5. FLUJO DE SOLICITUDES
-----------------------
- El usuario crea una solicitud desde solicitud.php.
- El administrador gestiona las solicitudes desde admin_solicitudes.php, cambiando el estado y agregando observaciones.
- El usuario puede ver el estado y la observación de cada solicitud en solicitud.php.

6. SEGURIDAD Y VALIDACIONES
---------------------------
- Las sesiones se usan para controlar el acceso y el rol.
- Los formularios usan validaciones básicas en el frontend y backend.
- Las consultas a la base de datos usan real_escape_string para evitar inyección SQL básica.
- El acceso a páginas de administración está restringido por rol.

7. ESTILOS Y EXPERIENCIA DE USUARIO
-----------------------------------
- El sitio utiliza Bootstrap 5 para el diseño responsivo y componentes visuales.
- El menú de navegación es dinámico y cambia según el rol del usuario.
- Los estados de las solicitudes se muestran con colores distintivos.
- El administrador tiene botones para actualizar estado, agregar observación y eliminar solicitudes.

8. SCRIPTS Y UTILIDADES
-----------------------
- add_observacion_column.sql: Agrega la columna observacion a la tabla solicitudes.
- verificar_conexion.php: Script para probar la conexión a la base de datos.
- hash.php: Script para generar hashes de contraseñas.

9. NOTAS Y RECOMENDACIONES
--------------------------
- La reordenación de IDs en la tabla solicitudes tras eliminar un registro no es recomendable en producción si existen referencias externas.
- La columna observacion debe existir en la tabla solicitudes para que la funcionalidad de observaciones funcione correctamente.
- El sistema está pensado para uso académico o institucional, no para producción sin revisiones adicionales de seguridad.

10. AUTORES
-----------
- Ingeniero Andrés Hernández
- Ingeniero Yilian Pérez
- Ingeniero William Chacón

11. KPI, ANS y SLA en el Proyecto
---------------------------------
KPI (Indicadores Clave de Desempeño):
- Son métricas que permiten medir el rendimiento del sistema o del equipo.
- Ejemplos para RenaceHogares:
  - Tiempo promedio de respuesta a una solicitud.
  - Número de solicitudes atendidas por mes.
  - Porcentaje de solicitudes completadas en un periodo.

ANS/SLA (Acuerdo de Nivel de Servicio):
- Es un compromiso formal sobre los niveles mínimos de servicio que se deben cumplir.
- Ejemplo para RenaceHogares:
  - "El 90% de las solicitudes deben ser atendidas en menos de 48 horas."
  - "El sistema debe estar disponible el 99% del tiempo."

Implementación en el proyecto:
- Se pueden agregar campos en la base de datos para registrar fechas de atención y cierre de solicitudes.
- Crear reportes en el panel de administración que muestren los KPIs definidos.
- Comparar los resultados de los KPIs con los objetivos del ANS/SLA para evaluar el cumplimiento.
- Ejemplo técnico:
  - Registrar la fecha de cambio de estado de cada solicitud.
  - Calcular el tiempo de atención y mostrar alertas si se superan los límites definidos en el SLA.

























?>echo "</div>";}    echo " | % Cumplimiento SLA (<=48h): $porc_sla%";    $porc_sla = round($sla['dentro_sla'] / $atendidas * 100, 2);    $sla = $res2->fetch_assoc();    $res2 = $conn->query("SELECT COUNT(*) as dentro_sla FROM solicitudes WHERE fecha_atencion IS NOT NULL AND TIMESTAMPDIFF(HOUR, fecha_solicitud, fecha_atencion) <= 48");if ($atendidas > 0) {echo "<b>KPI:</b> Solicitudes totales: $total | Atendidas: $atendidas | Completadas: $completadas | Tiempo promedio de atención: $tiempo_promedio horas";echo "<div class='alert alert-info'>";$tiempo_promedio = round($kpi['tiempo_promedio'], 2);$completadas = $kpi['completadas'];$atendidas = $kpi['atendidas'];$total = $kpi['total'];$kpi = $res->fetch_assoc();    FROM solicitudes");    AVG(TIMESTAMPDIFF(HOUR, fecha_solicitud, fecha_atencion)) as tiempo_promedio    SUM(CASE WHEN fecha_cierre IS NOT NULL THEN 1 ELSE 0 END) as completadas,    SUM(CASE WHEN fecha_atencion IS NOT NULL THEN 1 ELSE 0 END) as atendidas,$res = $conn->query("SELECT COUNT(*) as total, // KPIs<?phpFin de la documentación.