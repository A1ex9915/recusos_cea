-- ============================================================
-- ACTUALIZACIONES PARA FORMULARIO DE CAPTURA DE INVENTARIO
-- Fecha: 28 de enero de 2026
-- 
-- INSTRUCCIONES PARA COLABORADORES:
-- 1. Ejecuta este script después de hacer git pull
-- 2. Ver README.md en esta carpeta para más detalles
-- 
-- EJECUCIÓN RÁPIDA (PowerShell):
-- Get-Content "sql_updates\agregar_cambios_inventario.sql" | & "C:\xampp\mysql\bin\mysql.exe" -u root sistema_ceaa
-- ============================================================

USE sistema_ceaa;

-- 1. Agregar nueva categoría "Material didáctico"
INSERT INTO categorias (nombre) 
VALUES ('Material didáctico')
ON DUPLICATE KEY UPDATE nombre = nombre;

-- 2. Modificar campo numero_serie para que sea INT NOT NULL
-- NOTA: Primero actualizamos los registros existentes con NULL o vacíos
UPDATE recursos 
SET numero_serie = '0' 
WHERE numero_serie IS NULL OR numero_serie = '';

-- Ahora alteramos la columna (cambiar a INT y NOT NULL)
ALTER TABLE recursos 
MODIFY COLUMN numero_serie INT NOT NULL DEFAULT 0;

-- ============================================================
-- VERIFICACIÓN DE CAMBIOS
-- ============================================================
-- Ver categorías actualizadas
SELECT * FROM categorias ORDER BY nombre;

-- Ver estructura de tabla recursos
DESCRIBE recursos;
