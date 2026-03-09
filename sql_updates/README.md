# Actualizaciones de Base de Datos

Este directorio contiene scripts SQL para mantener sincronizada la base de datos entre todos los colaboradores.

## 📋 Instrucciones para Colaboradores

Cuando descargues cambios del repositorio (`git pull`), **revisa esta carpeta** para verificar si hay nuevos scripts SQL que debas ejecutar.

---

## 🔧 Cómo Ejecutar los Scripts

### Opción 1: Desde PowerShell/CMD (Recomendado)

```powershell
# Ubicarse en la carpeta del proyecto
cd C:\xampp\htdocs\recusos_cea

# Ejecutar el script
Get-Content "sql_updates\agregar_cambios_inventario.sql" | & "C:\xampp\mysql\bin\mysql.exe" -u root sistema_ceaa
```

### Opción 2: Desde phpMyAdmin

1. Abre [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Selecciona la base de datos `sistema_ceaa`
3. Ve a la pestaña **SQL**
4. Copia y pega el contenido del archivo SQL
5. Haz clic en **Continuar** o **Ejecutar**

### Opción 3: Desde MySQL CLI

```bash
cd C:\xampp\htdocs\recusos_cea
C:\xampp\mysql\bin\mysql.exe -u root sistema_ceaa < sql_updates\agregar_cambios_inventario.sql
```

---

## 📅 Historial de Actualizaciones

### **2026-03-02** - `2026-03-02_operativa_bitacora_indices.sql`

**Cambios aplicados:**
- ✅ Nueva tabla `bitacora_acciones` para auditoría operativa
- ✅ Índices en `recursos` para filtros por municipio, organismo, estado, fecha y categoría
- ✅ Índices en `pdf_reportes` y `pdf_reportes_anual` para consultas de reportes

**Afecta a:**
- Controladores de autenticación, usuarios, inventario y reportes (registro de acciones)
- Rendimiento de consultas en módulos de inventario/reportes

**Ejecutar si:**
Quieres habilitar bitácora de operaciones y mejorar tiempos de respuesta en filtros/reportes.

### **2026-01-28** - `agregar_cambios_inventario.sql`

**Cambios aplicados:**
- ✅ Agregada categoría "Material didáctico"
- ✅ Campo `numero_serie` convertido de VARCHAR a INT NOT NULL
- ✅ Actualización de registros existentes con numero_serie NULL

**Afecta a:**
- Formulario de captura de inventario
- Modelo Inventario (campos organismo_id, numero_serie)

**Ejecutar si:**
Tu base de datos no tiene la categoría "Material didáctico" o el campo `numero_serie` aún es VARCHAR.

---

## ⚠️ Importante

- **Siempre haz respaldo** de tu base de datos antes de ejecutar scripts
- Los scripts son **idempotentes** (se pueden ejecutar varias veces sin problemas)
- Si tienes errores, verifica que estés usando la base de datos correcta (`sistema_ceaa`)
- Si MySQL no está en la ruta por defecto, ajusta la ruta en los comandos
