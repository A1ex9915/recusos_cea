<section class="formatos-page">
  <h1 class="formatos-page-title">Nuevo formato</h1>
  <p class="formatos-page-subtitle">
    Define el nombre, versión y los campos que tendrá el formato.
  </p>

  <div class="formatos-grid">
    <!-- Acciones rápidas -->
    <aside class="formatos-sidebar">
      <h3>Acciones rápidas</h3>
      <ul>
        <li><a href="index.php?controller=formatos&action=index">Ver formatos</a></li>
        <li><a href="#">Revisar formato pendiente</a></li>
        <li><a href="#">Generar reporte</a></li>
        <li><a href="index.php?controller=users&action=index">Usuarios y permisos</a></li>
      </ul>
    </aside>

    <!-- Tarjeta principal -->
    <div class="formatos-card">
      <div class="formatos-header">
        <h2>Definición de Ficha Técnica</h2>
      </div>

      <form class="formato-form"
            method="post"
            action="index.php?controller=formatos&action=guardarDefinicion">
        <!-- puedes cambiar la acción cuando implementemos guardarDefinicion -->

        <div class="formato-field-group">
          <label for="nombre">Nombre del formato</label>
          <input
            type="text"
            id="nombre"
            name="nombre"
            class="formato-input"
            required
            value="<?= htmlspecialchars($formato['nombre'] ?? '') ?>">
        </div>

        <div class="formato-field-group">
          <label for="version">Versión</label>
          <input
            type="text"
            id="version"
            name="version"
            class="formato-input"
            value="<?= htmlspecialchars($formato['version'] ?? '') ?>">
        </div>

        <div class="formato-field-group formato-checkbox">
          <input
            type="checkbox"
            id="activo"
            name="activo"
            value="1"
            <?= !isset($formato['activo']) || $formato['activo'] ? 'checked' : '' ?>>
          <label for="activo">Activo</label>
        </div>

        <p class="formato-help">
          Más adelante aquí armamos la tabla para mapear
          <strong>“Encabezado en Excel” → “campo_bd”</strong> de la base de datos.
        </p>

        <div class="formato-actions">
          <a href="index.php?controller=formatos&action=index" class="btn-secondary">
            Cancelar
          </a>
          <button type="submit" class="btn-gold">
            Guardar formato
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
