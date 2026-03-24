-- ================================================================
-- ACTUALIZACIÓN DE SEGURIDAD — 2026-03-19
-- Agrega rol Consultor y vista de auditoría
-- Ejecutar una sola vez en producción
-- ================================================================

-- ---------------------------------------------------------------
-- 1. NUEVO ROL: Consultor (solo lectura / reportes)
-- ---------------------------------------------------------------
INSERT IGNORE INTO `roles` (`id`, `nombre`) VALUES (3, 'Consultor');

-- ---------------------------------------------------------------
-- 2. VISTA DE AUDITORÍA — facilita revisar la bitácora
--    Uso: SELECT * FROM v_auditoria ORDER BY creado_en DESC LIMIT 100;
-- ---------------------------------------------------------------
CREATE OR REPLACE VIEW v_auditoria AS
SELECT
    b.id,
    b.creado_en                              AS fecha,
    COALESCE(u.nombre, '(sistema)')          AS usuario,
    u.email,
    r.nombre                                 AS rol,
    b.accion,
    b.modulo,
    b.detalle,
    b.ip,
    b.metadata_json
FROM bitacora_acciones b
LEFT JOIN usuarios    u ON u.id = b.user_id
LEFT JOIN roles       r ON r.id = u.rol_id
ORDER BY b.creado_en DESC;

-- ---------------------------------------------------------------
-- 3. ÍNDICE para consultas rápidas por fecha y módulo
--    (si no existe ya alguno equivalente)
-- ---------------------------------------------------------------
ALTER TABLE `bitacora_acciones`
    ADD INDEX IF NOT EXISTS idx_bita_modulo   (`modulo`),
    ADD INDEX IF NOT EXISTS idx_bita_accion   (`accion`),
    ADD INDEX IF NOT EXISTS idx_bita_user     (`user_id`),
    ADD INDEX IF NOT EXISTS idx_bita_creado   (`creado_en`);
