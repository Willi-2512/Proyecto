ALTER TABLE solicitudes
ADD COLUMN fecha_atencion DATETIME NULL AFTER observacion,
ADD COLUMN fecha_cierre DATETIME NULL AFTER fecha_atencion;
