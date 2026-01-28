<?php
$baseUrl = BASE_URI . '/index.php';
?>

<section class="invrep-wrapper">

    <!-- HEADER -->
    <header class="invrep-header">
        <div>
            <h2>Inventario de bienes</h2>
            <p>Consulta y edita el inventario registrado en el sistema.</p>
        </div>

        <div class="invrep-actions-header">

            <!-- Buscador -->
            <form class="invrep-busqueda" method="get">
                <input type="hidden" name="controller" value="reportes">
                <input type="hidden" name="action" value="inventario">

                <div class="input-search-wrapper">
                    <input
                        type="text"
                        name="q"
                        placeholder="Buscar por no. inventario, descripción..."
                        value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                    >
                    <button type="submit">🔍</button>
                </div>
            </form>

            <!-- (YA SIN BOTONES DE EXCEL) -->
        </div>
    </header>

    <!-- FILTROS -->
    <div class="invrep-filtros">
        <form method="get">
            <input type="hidden" name="controller" value="reportes">
            <input type="hidden" name="action" value="inventario">

            <div class="filtros-grid">

                <div class="filtro-item">
                    <label>Categoría</label>
                    <select name="categoria">
                        <option value="">Todas</option>
                        <?php $catSel = $_GET['categoria'] ?? ''; ?>
                        <?php foreach ($categorias as $c): ?>
                            <option value="<?= htmlspecialchars($c['nombre']) ?>"
                                <?= $catSel === $c['nombre'] ? 'selected' : '' ?>>
                                <?= $c['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filtro-item">
                    <label>Estado del bien</label>
                    <?php $estSel = $_GET['estado_bien'] ?? ''; ?>
                    <select name="estado_bien">
                        <option value="">Todos</option>
                        <option value="bueno"   <?= $estSel === 'bueno'   ? 'selected':'' ?>>Bueno</option>
                        <option value="regular" <?= $estSel === 'regular' ? 'selected':'' ?>>Regular</option>
                        <option value="malo"    <?= $estSel === 'malo'    ? 'selected':'' ?>>Malo</option>
                        <option value="baja"    <?= $estSel === 'baja'    ? 'selected':'' ?>>Baja</option>
                    </select>
                </div>

                <div class="filtro-item">
                    <label>Año de alta</label>
                    <input
                        type="number"
                        name="anio"
                        placeholder="Ej. 2025"
                        value="<?= htmlspecialchars($_GET['anio'] ?? '') ?>"
                    >
                </div>

                <div class="filtro-item filtro-boton">
                    <button class="btn-secundario btn-sm">Aplicar filtros</button>
                </div>
            </div>
        </form>
    </div>

    <!-- TARJETAS -->
    <div class="invrep-resumen">
        <div class="card-resumen total" onclick="filtrarCard('')">
            <span class="label">Total de bienes</span>
            <span class="valor"><?= $resumen['total'] ?? 0 ?></span>
        </div>

        <div class="card-resumen buenos" onclick="filtrarCard('bueno')">
            <span class="label">En buen estado</span>
            <span class="valor"><?= $resumen['bueno'] ?? 0 ?></span>
        </div>

        <div class="card-resumen regulares" onclick="filtrarCard('regular')">
            <span class="label">En estado regular</span>
            <span class="valor"><?= $resumen['regular'] ?? 0 ?></span>
        </div>

        <div class="card-resumen malos" onclick="filtrarCard('malo')">
            <span class="label">En mal estado / baja</span>
            <span class="valor"><?= $resumen['malo'] ?? 0 ?></span>
        </div>
    </div>

    <!-- TABLA -->
    <div class="invrep-card">
        <div class="tabla-responsive">
            <table class="tabla-inventario">
                <thead>
                    <tr>
                        <th>No. Inv.</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                        <th>Fecha alta</th>
                        <th>Valor (MXN)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($inventario)): ?>
                        <tr><td colspan="8" class="sin-registros">No hay registros.</td></tr>
                    <?php else: ?>
                        <?php foreach ($inventario as $item): ?>
                            <tr class="fila-animada">
                                <td><?= htmlspecialchars($item['no_inventario'] ?? $item['clave'] ?? '') ?></td>
                                <td><?= htmlspecialchars($item['descripcion'] ?? $item['nombre'] ?? '') ?></td>
                                <td><?= htmlspecialchars($item['categoria'] ?? '') ?></td>
                                <td><?= htmlspecialchars($item['ubicacion'] ?? '') ?></td>
                                <td>
                                    <span class="badge-estado badge-<?= $item['estado_bien'] ?: 'default' ?>">
                                        <?= $item['estado_bien'] ? ucfirst($item['estado_bien']) : '—' ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($item['fecha_alta'] ?? '') ?></td>
                                <td>$ <?= number_format((float)($item['costo_unitario'] ?? 0), 2) ?></td>
                                <td>
                                    <button type="button"
                                            class="acciones-link"
                                            onclick="openEditModal(<?= (int)$item['id'] ?>)">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINACIÓN -->
    <?php if (($totalPages ?? 1) > 1): ?>
        <div class="invrep-paginacion">
            <span>Página <?= $currentPage ?> de <?= $totalPages ?></span>
        </div>
    <?php endif; ?>

    <!-- MODAL DE EDICIÓN -->
    <div id="editModal" class="excel-modal">
        <div class="excel-modal-content">
            <h3>Editar recurso de inventario</h3>

            <form id="editForm" onsubmit="guardarCambiosInventario(event)">
                <input type="hidden" id="edit_id" name="id">

                <!-- CLAVE / NOMBRE -->
                <label>No. inventario / clave</label>
                <input type="text" id="edit_clave" name="clave">

                <label>Nombre / descripción corta</label>
                <input type="text" id="edit_nombre" name="nombre">

                <!-- CATEGORÍA / UBICACIÓN -->
                <label>Categoría</label>
                <select id="edit_categoria_id" name="categoria_id">
                    <option value="">Selecciona categoría</option>
                    <?php foreach ($categorias as $c): ?>
                        <option value="<?= (int)$c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Ubicación física</label>
                <select id="edit_ubicacion_id" name="ubicacion_id">
                    <option value="">Selecciona ubicación</option>
                    <?php foreach ($ubicaciones as $u): ?>
                        <option value="<?= (int)$u['id'] ?>"><?= htmlspecialchars($u['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- ESTADO / COSTO -->
                <label>Estado del bien</label>
                <select id="edit_estado_bien" name="estado_bien">
                    <option value="">Selecciona...</option>
                    <option value="bueno">Bueno</option>
                    <option value="regular">Regular</option>
                    <option value="malo">Malo</option>
                    <option value="baja">Baja</option>
                </select>

                <label>Costo unitario (MXN)</label>
                <input type="number" step="0.01" id="edit_costo_unitario" name="costo_unitario">

                <!-- DATOS CEAA -->
                <label>Marca</label>
                <input type="text" id="edit_marca" name="marca">

                <label>Modelo</label>
                <input type="text" id="edit_modelo" name="modelo">

                <label>Número de serie</label>
                <input type="text" id="edit_numero_serie" name="numero_serie">

                <label>Color</label>
                <input type="text" id="edit_color" name="color">

                <label>Material</label>
                <input type="text" id="edit_material" name="material">

                <label>Descripción / observaciones</label>
                <textarea id="edit_descripcion" name="descripcion" rows="3"></textarea>

                <!-- CAMPOS OCULTOS PARA NO PERDER INFO -->
                <input type="hidden" id="edit_unidad_id" name="unidad_id">
                <input type="hidden" id="edit_tipo_fuente" name="tipo_fuente">
                <input type="hidden" id="edit_cantidad_total" name="cantidad_total">
                <input type="hidden" id="edit_cantidad_disponible" name="cantidad_disponible">

                <div class="excel-modal-actions">
                    <button type="button" class="btn-secundario" onclick="closeEditModal()">Cancelar</button>
                    <button type="submit" class="btn-primario">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>

</section>

<!-- JS -->
<script>
const BASE_URL = '<?= $baseUrl ?>';

// Tarjetas resumen
function filtrarCard(estado) {
    const url = new URL(window.location.href);
    url.searchParams.set("controller", "reportes");
    url.searchParams.set("action", "inventario");
    url.searchParams.set("estado_bien", estado);
    window.location.href = url.toString();
}

// Abrir modal de edición
function openEditModal(id) {
    fetch(BASE_URL + '?controller=inventario&action=edit&id=' + id)
        .then(r => r.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            // Llenar campos visibles
            document.getElementById('edit_id').value              = data.id;
            document.getElementById('edit_clave').value           = data.clave || '';
            document.getElementById('edit_nombre').value          = data.nombre || '';
            document.getElementById('edit_categoria_id').value    = data.categoria_id || '';
            document.getElementById('edit_ubicacion_id').value    = data.ubicacion_id || '';
            document.getElementById('edit_estado_bien').value     = data.estado_bien || '';
            document.getElementById('edit_costo_unitario').value  = data.costo_unitario || '';
            document.getElementById('edit_marca').value           = data.marca || '';
            document.getElementById('edit_modelo').value          = data.modelo || '';
            document.getElementById('edit_numero_serie').value    = data.numero_serie || '';
            document.getElementById('edit_color').value           = data.color || '';
            document.getElementById('edit_material').value        = data.material || '';
            document.getElementById('edit_descripcion').value     = data.descripcion || '';

            // Ocultos (para no perder info al actualizar)
            document.getElementById('edit_unidad_id').value            = data.unidad_id || '';
            document.getElementById('edit_tipo_fuente').value         = data.tipo_fuente || '';
            document.getElementById('edit_cantidad_total').value      = data.cantidad_total || 0;
            document.getElementById('edit_cantidad_disponible').value = data.cantidad_disponible || data.cantidad_total || 0;

            document.getElementById('editModal').style.display = 'flex';
        })
        .catch(err => {
            console.error(err);
            alert('Error al cargar el recurso.');
        });
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Guardar cambios con fetch POST
function guardarCambiosInventario(e) {
    e.preventDefault();

    const form = document.getElementById('editForm');
    const fd   = new FormData(form);

    fetch(BASE_URL + '?controller=inventario&action=update', {
        method: 'POST',
        body: fd
    })
    .then(r => r.text())
    .then(() => {
        closeEditModal();
        // Recargar para ver los cambios
        window.location.reload();
    })
    .catch(err => {
        console.error(err);
        alert('Error al guardar los cambios.');
    });
}
</script>

<style>
/* ============================
   ANIMACIÓN DE FILAS (YA EXISTENTE)
============================ */
.fila-animada {
    transition: 0.25s ease;
}
.fila-animada:hover {
    background: #fafafa;
    transform: scale(1.01);
    box-shadow: 0 4px 12px rgba(0,0,0,0.07);
}

/* ============================
   MODAL OVERLAY (FONDO)
============================ */
#editModal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(4px);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    padding: 20px;
}

/* ============================
   CONTENEDOR DEL MODAL
============================ */
#editModal .excel-modal-content {
    background: #ffffff;
    width: 95%;
    max-width: 560px;
    max-height: 90vh;
    overflow-y: auto;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.20);
    animation: modalFade 0.25s ease-out;
}

/* ANIMACIÓN DE APARICIÓN */
@keyframes modalFade {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* TITULO DEL MODAL */
#editModal h3 {
    margin-bottom: 18px;
    color: #800033;
    font-size: 22px;
    font-weight: bold;
}

/* ============================
   FORMULARIO DEL MODAL
============================ */
#editModal form label {
    font-weight: 600;
    margin-top: 12px;
    color: #800033;
    display: block;
}

#editModal form input,
#editModal form select,
#editModal form textarea {
    width: 100%;
    padding: 10px 12px;
    margin-top: 5px;
    border: 1px solid #d9d9d9;
    border-radius: 8px;
    font-size: 15px;
    background: #fff;
    outline: none;
    transition: 0.2s;
}

#editModal form input:focus,
#editModal form select:focus,
#editModal form textarea:focus {
    border-color: #800033;
    box-shadow: 0 0 4px rgba(128,0,51,0.35);
}

/* ============================
   BOTONES DE ACCIONES
============================ */
.excel-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 25px;
}

.btn-primario {
    background: #800033;
    color: #fff;
    padding: 10px 18px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: 0.2s;
}

.btn-primario:hover {
    background: #a10042;
}

.btn-secundario {
    background: #dddddd;
    color: #333;
    padding: 10px 18px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: 0.2s;
}

.btn-secundario:hover {
    background: #c7c7c7;
}

/* ============================
   SCROLL PERSONALIZADO
============================ */
#editModal .excel-modal-content::-webkit-scrollbar {
    width: 7px;
}
#editModal .excel-modal-content::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 8px;
}
</style>

