<?php
$baseUrl   = BASE_URI . '/index.php';
$totalItems = (int)($totalItems ?? count($inventario ?? []));
?>

<section class="invrep-wrapper">

    <!-- HERO BANNER -->
    <div class="invrep-hero">
        <div class="invrep-hero-left">
            <div class="invrep-hero-icon">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div>
                <button type="button" class="invrep-hero-back" onclick="window.history.back()">
                    <i class="fa-solid fa-arrow-left"></i> Volver
                </button>
                <h2 class="invrep-hero-title">Inventario de bienes</h2>
                <p class="invrep-hero-sub">
                    Consulta y edita el inventario registrado en el sistema.
                    &nbsp;
                    <span style="background:rgba(255,255,255,.2);padding:2px 10px;border-radius:20px;font-size:12px;font-weight:700;">
                        <?= number_format((int)($resumen['total'] ?? 0)) ?> bienes
                    </span>
                </p>
            </div>
        </div>

        <form class="invrep-busqueda" method="get" style="position:relative;z-index:1">
            <input type="hidden" name="controller" value="reportes">
            <input type="hidden" name="action" value="inventario">
            <div class="input-search-wrapper">
                <input type="text" name="q"
                       placeholder="Buscar por no. inventario, descripci&oacute;n..."
                       value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    </div>

    <!-- FILTROS -->
    <div class="invrep-filter-card">
        <div class="invrep-section-label">
            <i class="fa-solid fa-sliders"></i> Filtros
        </div>
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
                    <button class="btn-secundario btn-sm">
                        <i class="fa-solid fa-filter"></i> Aplicar filtros
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- TARJETAS -->
    <div class="invrep-resumen">
        <div class="card-resumen total" onclick="filtrarCard('')">
            <div class="ricon"><i class="fa-solid fa-layer-group"></i></div>
            <div class="rtext">
                <span class="label">Total de bienes</span>
                <span class="valor"><?= $resumen['total'] ?? 0 ?></span>
            </div>
        </div>

        <div class="card-resumen buenos" onclick="filtrarCard('bueno')">
            <div class="ricon"><i class="fa-solid fa-circle-check"></i></div>
            <div class="rtext">
                <span class="label">En buen estado</span>
                <span class="valor"><?= $resumen['bueno'] ?? 0 ?></span>
            </div>
        </div>

        <div class="card-resumen regulares" onclick="filtrarCard('regular')">
            <div class="ricon"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="rtext">
                <span class="label">En estado regular</span>
                <span class="valor"><?= $resumen['regular'] ?? 0 ?></span>
            </div>
        </div>

        <div class="card-resumen malos" onclick="filtrarCard('malo')">
            <div class="ricon"><i class="fa-solid fa-circle-xmark"></i></div>
            <div class="rtext">
                <span class="label">En mal estado / baja</span>
                <span class="valor"><?= $resumen['malo'] ?? 0 ?></span>
            </div>
        </div>
    </div>

    <!-- TABLA -->
    <div class="invrep-card">
        <div class="invrep-table-header">
            <span class="invrep-subsection-label">
                <i class="fa-solid fa-table-list"></i> Registros
            </span>
            <span class="invrep-result-count"><?= number_format($totalItems) ?> en total</span>
        </div>
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
                                <td title="<?= htmlspecialchars($item['organismo'] ?? '') ?>">
                                    <?= htmlspecialchars(mb_strlen($item['organismo'] ?? '') > 30 ? mb_substr($item['organismo'] ?? '', -30) . '...' : ($item['organismo'] ?? '')) ?>
                                </td>
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
                                        <i class="fa-solid fa-pen-to-square"></i> Editar
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
    <?php
        $totalPages  = (int)($totalPages  ?? 1);
        $currentPage = (int)($currentPage ?? 1);
        $totalItems  = (int)($totalItems  ?? count($inventario));
        $perPage     = (int)($perPage     ?? 15);

        // Parámetros GET actuales (sin 'page')
        $qp = $_GET;
        unset($qp['page']);
        $qBase = http_build_query($qp);
        $qBase = $qBase ? $qBase . '&' : '';
        $urlPage = "index.php?{$qBase}page=";
    ?>
    <?php if ($totalPages > 1): ?>
    <nav class="invrep-paginacion" aria-label="Paginación">
        <div class="pag-info">
            Mostrando <?= ($currentPage - 1) * $perPage + 1 ?>–<?= min($currentPage * $perPage, $totalItems) ?>
            de <strong><?= $totalItems ?></strong> registros
        </div>
        <div class="pag-controles">
            <?php if ($currentPage > 1): ?>
                <a href="<?= $urlPage ?>1" class="pag-btn" title="Primera">«</a>
                <a href="<?= $urlPage ?><?= $currentPage - 1 ?>" class="pag-btn" title="Anterior">‹</a>
            <?php else: ?>
                <span class="pag-btn pag-disabled">«</span>
                <span class="pag-btn pag-disabled">‹</span>
            <?php endif; ?>

            <?php
                $rango = 2;
                $inicio = max(1, $currentPage - $rango);
                $fin    = min($totalPages, $currentPage + $rango);
                if ($inicio > 1): ?>
                    <a href="<?= $urlPage ?>1" class="pag-btn">1</a>
                    <?php if ($inicio > 2): ?><span class="pag-elipsis">…</span><?php endif; ?>
                <?php endif;
                for ($p = $inicio; $p <= $fin; $p++):
            ?>
                <a href="<?= $urlPage ?><?= $p ?>" class="pag-btn <?= $p === $currentPage ? 'pag-activa' : '' ?>"><?= $p ?></a>
            <?php
                endfor;
                if ($fin < $totalPages): ?>
                    <?php if ($fin < $totalPages - 1): ?><span class="pag-elipsis">…</span><?php endif; ?>
                    <a href="<?= $urlPage ?><?= $totalPages ?>" class="pag-btn"><?= $totalPages ?></a>
                <?php endif;
            ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="<?= $urlPage ?><?= $currentPage + 1 ?>" class="pag-btn" title="Siguiente">›</a>
                <a href="<?= $urlPage ?><?= $totalPages ?>" class="pag-btn" title="Última">»</a>
            <?php else: ?>
                <span class="pag-btn pag-disabled">›</span>
                <span class="pag-btn pag-disabled">»</span>
            <?php endif; ?>
        </div>
    </nav>
    <?php endif; ?>

    <!-- MODAL DE EDICIÓN -->
    <div id="editModal" class="excel-modal">
        <div class="excel-modal-content">
            <div class="inv-modal-header">
                <i class="fa-solid fa-pen-to-square"></i>
                <div>
                    <h3>Editar recurso</h3>
                    <p>Modifica los datos del bien seleccionado</p>
                </div>
            </div>

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
                <select id="edit_organismo_id" name="organismo_id">
                    <option value="">Selecciona organismo</option>
                    <?php foreach ($organismos as $o): ?>
                        <option value="<?= (int)$o['id'] ?>"><?= htmlspecialchars($o['nombre']) ?></option>
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
            document.getElementById('edit_organismo_id').value    = data.organismo_id || '';
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
   PAGINACIÓN
============================ */
.invrep-paginacion {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 20px;
    padding: 10px 4px;
}
.pag-info {
    font-size: 13px;
    color: #555;
}
.pag-controles {
    display: flex;
    align-items: center;
    gap: 5px;
    flex-wrap: wrap;
}
.pag-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 34px;
    height: 34px;
    padding: 0 8px;
    border-radius: 8px;
    border: 1px solid #ddd;
    background: #fff;
    color: #333;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.15s;
}
.pag-btn:hover:not(.pag-disabled):not(.pag-activa) {
    background: #f3e6ec;
    border-color: #800033;
    color: #800033;
}
.pag-activa {
    background: #800033;
    border-color: #800033;
    color: #fff !important;
    cursor: default;
}
.pag-disabled {
    color: #bbb;
    border-color: #eee;
    cursor: not-allowed;
    background: #fafafa;
}
.pag-elipsis {
    color: #999;
    font-size: 13px;
    padding: 0 4px;
}

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

/* TITULO DEL MODAL (heredado de inv-modal-header en inventario-reporte.css) */
#editModal h3 {
    margin: 0;
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

