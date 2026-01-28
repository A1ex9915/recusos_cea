<!-- inventario_captura.php -->
<link rel="stylesheet" href="<?php echo BASE_URI; ?>/public/css/inventario-captura.css">

<section class="inv-wrapper">
  <header class="inv-header">
    <div>
      <h2>Captura de inventario</h2>
      <p>Registra nuevos bienes de inventario en el sistema. Los campos marcados con * son obligatorios.</p>
    </div>
    <button type="button" class="btn-volver" onclick="window.history.back()">
      ← Volver
    </button>
  </header>

  <div class="inv-card">
    <form 
      class="inv-form" 
      method="post" 
      action="<?php echo BASE_URI; ?>/index.php?controller=inventario&action=guardar"
      enctype="multipart/form-data"
    >
      <!-- FILA 1 -->
      <div class="form-row">
        <div class="form-group">
          <label for="no_inventario">No. de inventario <span>*</span></label>
          <input 
            type="text" 
            id="no_inventario" 
            name="no_inventario" 
            placeholder="Ej. 0001-2025" 
            required
          >
        </div>

        <div class="form-group">
          <label for="descripcion">Descripción del bien <span>*</span></label>
          <input 
            type="text" 
            id="descripcion" 
            name="descripcion" 
            placeholder="Ej. Escritorio metálico de 1.20m" 
            required
          >
        </div>
      </div>

      <!-- FILA 2 -->
      <div class="form-row">
        <div class="form-group">
          <label for="categoria">Categoría</label>
          <select id="categoria" name="categoria">
            <option value="">Selecciona una categoría</option>
            <option value="mobiliario">Mobiliario</option>
            <option value="equipo_computo">Equipo de cómputo</option>
            <option value="vehiculo">Vehículo</option>
            <option value="otros">Otros</option>
          </select>
        </div>

        <div class="form-group">
          <label for="cantidad">Cantidad <span>*</span></label>
          <input 
            type="number" 
            id="cantidad" 
            name="cantidad" 
            min="1" 
            step="1" 
            placeholder="Ej. 1" 
            required
          >
        </div>
      </div>

      <!-- FILA 3 (NUEVO: MATERIAL) -->
      <div class="form-row">
        <div class="form-group">
          <label for="material">Material</label>
          <input
            type="text"
            id="material"
            name="material"
            placeholder="Ej. Madera, metal, plástico"
          >
        </div>
      </div>

      <!-- FILA 4 -->
      <div class="form-row">
        <div class="form-group">
          <label for="unidad_medida">Unidad de medida</label>
          <input 
            type="text" 
            id="unidad_medida" 
            name="unidad_medida" 
            placeholder="Ej. pieza, juego, paquete"
          >
        </div>

        <div class="form-group">
          <label for="valor_unitario">Valor unitario (MXN)</label>
          <input 
            type="number" 
            id="valor_unitario" 
            name="valor_unitario" 
            step="0.01" 
            placeholder="Ej. 2500.00"
          >
        </div>
      </div>

      <!-- FILA 5 -->
      <div class="form-row">
        <div class="form-group">
          <label for="area_responsable">Área responsable / Unidad</label>
          <input 
            type="text" 
            id="area_responsable" 
            name="area_responsable" 
            placeholder="Ej. Dirección de Cultura del Agua"
          >
        </div>

        <div class="form-group">
          <label for="ubicacion">Ubicación física</label>
          <input 
            type="text" 
            id="ubicacion" 
            name="ubicacion" 
            placeholder="Ej. Oficina 2, Planta Baja"
          >
        </div>
      </div>

      <!-- FILA 6 -->
      <div class="form-row">
        <div class="form-group">
          <label for="estado_bien">Estado del bien</label>
          <select id="estado_bien" name="estado_bien">
            <option value="">Selecciona...</option>
            <option value="bueno">Bueno</option>
            <option value="regular">Regular</option>
            <option value="malo">Malo</option>
            <option value="baja">Baja / En proceso de baja</option>
          </select>
        </div>

        <div class="form-group">
          <label for="fecha_alta">Fecha de alta</label>
          <input type="date" id="fecha_alta" name="fecha_alta">
        </div>
      </div>

      <!-- FILA 7 -->
      <div class="form-group">
        <label for="no_serie">No. de serie</label>
        <input 
          type="text" 
          id="no_serie" 
          name="no_serie" 
          placeholder="Ej. SN-ABC12345"
        >
      </div>

      <!-- FILA 8 -->
      <div class="form-group">
        <label for="doc_soporte">Documento soporte (opcional)</label>
        <input 
          type="file" 
          id="doc_soporte" 
          name="doc_soporte" 
          accept=".pdf,.jpg,.jpeg,.png"
        >
        <small class="help-text">Puedes adjuntar oficio, factura o evidencia fotográfica (PDF o imagen).</small>
      </div>

      <!-- OBSERVACIONES -->
      <div class="form-group">
        <label for="observaciones">Observaciones</label>
        <textarea 
          id="observaciones" 
          name="observaciones" 
          rows="3" 
          placeholder="Notas adicionales sobre el bien."
        ></textarea>
      </div>

      <!-- ACCIONES -->
      <div class="form-actions">
        <button type="submit" class="btn-primario">Guardar registro</button>
        <button type="reset" class="btn-secundario">Limpiar</button>
      </div>
    </form>
  </div>
</section>
