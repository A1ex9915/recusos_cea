-- =========================================================
-- Actualización operativa CEAA
-- Fecha: 2026-03-02
-- Objetivo:
-- 1) Crear tabla de bitácora de acciones
-- 2) Agregar índices de rendimiento para consultas frecuentes
-- =========================================================

CREATE TABLE IF NOT EXISTS bitacora_acciones (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id INT NULL,
  accion VARCHAR(80) NOT NULL,
  modulo VARCHAR(80) NOT NULL,
  detalle VARCHAR(255) NULL,
  ip VARCHAR(45) NULL,
  user_agent VARCHAR(255) NULL,
  metadata_json LONGTEXT NULL,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_bitacora_user (user_id),
  KEY idx_bitacora_modulo_accion (modulo, accion),
  KEY idx_bitacora_fecha (creado_en)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DELIMITER $$

DROP PROCEDURE IF EXISTS sp_add_index_if_not_exists $$
CREATE PROCEDURE sp_add_index_if_not_exists(
  IN p_table_name VARCHAR(64),
  IN p_index_name VARCHAR(64),
  IN p_columns VARCHAR(255)
)
BEGIN
  IF NOT EXISTS (
    SELECT 1
    FROM information_schema.statistics
    WHERE table_schema = DATABASE()
      AND table_name = p_table_name
      AND index_name = p_index_name
  ) THEN
    SET @sql = CONCAT('ALTER TABLE `', p_table_name, '` ADD INDEX `', p_index_name, '` (', p_columns, ')');
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
  END IF;
END $$

DELIMITER ;

CALL sp_add_index_if_not_exists('recursos', 'idx_recursos_municipio', '`municipio_id`');
CALL sp_add_index_if_not_exists('recursos', 'idx_recursos_organismo', '`organismo_id`');
CALL sp_add_index_if_not_exists('recursos', 'idx_recursos_estado_bien', '`estado_bien`');
CALL sp_add_index_if_not_exists('recursos', 'idx_recursos_fecha_alta', '`fecha_alta`');
CALL sp_add_index_if_not_exists('recursos', 'idx_recursos_categoria', '`categoria_id`');

CALL sp_add_index_if_not_exists('pdf_reportes', 'idx_pdf_reportes_municipio', '`municipio_id`');
CALL sp_add_index_if_not_exists('pdf_reportes', 'idx_pdf_reportes_organismo', '`organismo_id`');
CALL sp_add_index_if_not_exists('pdf_reportes', 'idx_pdf_reportes_fecha', '`creado_en`');

CALL sp_add_index_if_not_exists('pdf_reportes_anual', 'idx_pdf_reportes_anual_anio', '`anio`');
CALL sp_add_index_if_not_exists('pdf_reportes_anual', 'idx_pdf_reportes_anual_fecha', '`fecha`');

DROP PROCEDURE IF EXISTS sp_add_index_if_not_exists;
