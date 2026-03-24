<div class="ecacon-wrapper">

    <!-- ===== HERO ===== -->
    <div class="ecacon-hero">
        <a href="<?= BASE_URI ?>/index.php?controller=formatos&action=index" class="ecacon-hero-back">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
        <div class="ecacon-hero-center">
            <div class="ecacon-hero-icon">
                <i class="fa-solid fa-water"></i>
            </div>
            <div>
                <h1 class="ecacon-hero-title">Consulta de Fichas Técnicas ECA</h1>
                <p class="ecacon-hero-sub">Busca, visualiza y gestiona las fichas técnicas registradas</p>
            </div>
        </div>
    </div>

    <!-- ===== BODY ===== -->
    <div class="ecacon-body">

        <!-- FILTRO -->
        <div class="ecacon-section-label">
            <i class="fa-solid fa-filter"></i> Filtros de búsqueda
        </div>

        <form method="GET" action="" class="ecacon-filter-form">
            <input type="hidden" name="controller" value="formatos">
            <input type="hidden" name="action" value="consultaECA">

            <div class="ecacon-filter-row">
                <div class="ecacon-filter-field">
                    <label class="ecacon-label">Municipio</label>
                    <select name="municipio_id" class="ecacon-select">
                        <option value="">Todos los municipios...</option>
                        <?php foreach ($municipios as $m): ?>
                        <option value="<?= $m['id'] ?>" <?= ($municipio_id == $m['id'] ? 'selected' : '') ?>>
                            <?= htmlspecialchars($m['nombre']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="ecacon-btn-search">
                    <i class="fa-solid fa-magnifying-glass"></i> Buscar
                </button>
            </div>
        </form>

        <hr class="ecacon-divider">

        <?php if ($fichas): ?>

        <!-- STATS CARDS -->
        <div class="ecacon-stats">
            <div class="ecacon-stat-card">
                <div class="ecacon-stat-icon"><i class="fa-solid fa-file-lines"></i></div>
                <div>
                    <div class="ecacon-stat-label">Total de fichas</div>
                    <div class="ecacon-stat-value"><?= count($fichas) ?></div>
                </div>
            </div>
            <div class="ecacon-stat-card">
                <div class="ecacon-stat-icon"><i class="fa-solid fa-location-dot"></i></div>
                <div>
                    <div class="ecacon-stat-label">Municipio</div>
                    <div class="ecacon-stat-value"><?= empty($municipio_id) ? 'Todos' : htmlspecialchars($fichas[0]['municipio']) ?></div>
                </div>
            </div>
            <div class="ecacon-stat-card">
                <div class="ecacon-stat-icon"><i class="fa-solid fa-building"></i></div>
                <div>
                    <div class="ecacon-stat-label">Organismo</div>
                    <div class="ecacon-stat-value"><?= empty($municipio_id) ? 'Todos' : htmlspecialchars($fichas[0]['organismo']) ?></div>
                </div>
            </div>
        </div>

        <!-- TABLA -->
        <div class="ecacon-section-label" style="margin-top:4px;">
            <i class="fa-solid fa-table-list"></i> Fichas registradas
        </div>

        <div class="ecacon-table-wrapper">
            <table class="ecacon-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Clave ECA</th>
                        <th>RECA</th>
                        <th>Habitantes</th>
                        <th>Último fortalecimiento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($fichas as $f): ?>
                    <tr>
                        <td><?= (int)$f['id'] ?></td>
                        <td><?= htmlspecialchars($f['clave_eca']) ?></td>
                        <td><?= htmlspecialchars($f['nombre_reca']) ?></td>
                        <td><?= (int)$f['habitantes'] ?></td>
                        <td><?= htmlspecialchars($f['fecha_ultimo_fortalecimiento']) ?></td>
                        <td>
                            <div class="ecacon-actions">
                                <a href="index.php?controller=formatos&action=verECA&id=<?= (int)$f['id'] ?>" class="ecacon-btn-act ecacon-btn-ver">
                                    <i class="fa-solid fa-eye"></i> Ver
                                </a>
                                <a href="index.php?controller=formatos&action=editarECA&id=<?= (int)$f['id'] ?>" class="ecacon-btn-act ecacon-btn-edit">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </a>
                                <a href="index.php?controller=formatos&action=generarPDFECA&id=<?= (int)$f['id'] ?>" class="ecacon-btn-act ecacon-btn-pdf">
                                    <i class="fa-solid fa-file-pdf"></i> PDF
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php else: ?>
        <div class="ecacon-empty">
            <i class="fa-solid fa-inbox"></i>
            <span>No hay fichas registradas<?= $municipio_id ? ' para este municipio' : '' ?>.</span>
        </div>
        <?php endif; ?>

    </div><!-- /.ecacon-body -->
</div><!-- /.ecacon-wrapper -->

<style>
/* ================================================================
   MÓDULO: CONSULTA DE FICHAS ECA
   ================================================================ */

.ecacon-wrapper { padding: 24px; }

/* HERO --------------------------------------------------------- */
.ecacon-hero {
    position: relative;
    background: linear-gradient(135deg, #7b1b3b 0%, #a83260 100%);
    border-radius: 20px;
    padding: 28px 32px;
    margin-bottom: 20px;
    overflow: hidden;
    display: flex;
    align-items: center;
    gap: 20px;
}
.ecacon-hero::before {
    content: '';
    position: absolute;
    width: 220px; height: 220px;
    top: -80px; right: 200px;
    background: rgba(255,255,255,.06);
    border-radius: 50%;
    pointer-events: none;
}
.ecacon-hero::after {
    content: '';
    position: absolute;
    width: 140px; height: 140px;
    bottom: -50px; right: 60px;
    background: rgba(255,255,255,.07);
    border-radius: 50%;
    pointer-events: none;
}
.ecacon-hero-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.30);
    border-radius: 999px;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    transition: background .2s;
    flex-shrink: 0;
    z-index: 1;
}
.ecacon-hero-back:hover { background: rgba(255,255,255,.25); color: #fff; }
.ecacon-hero-center {
    display: flex;
    align-items: center;
    gap: 16px;
    z-index: 1;
}
.ecacon-hero-icon {
    width: 54px; height: 54px;
    background: rgba(255,255,255,.15);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    color: #fff;
    flex-shrink: 0;
}
.ecacon-hero-title {
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 3px;
}
.ecacon-hero-sub {
    color: rgba(255,255,255,.80);
    font-size: 13px;
    margin: 0;
}

/* BODY --------------------------------------------------------- */
.ecacon-body {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
    padding: 28px 32px;
}

/* SECTION LABEL ----------------------------------------------- */
.ecacon-section-label {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #7b1b3b;
    background: #fdf0f4;
    border-left: 3px solid #7b1b3b;
    border-radius: 0 8px 8px 0;
    padding: 8px 14px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .6px;
    margin-bottom: 18px;
}

/* FILTER ------------------------------------------------------ */
.ecacon-filter-form { margin-bottom: 8px; }
.ecacon-filter-row {
    display: flex;
    align-items: flex-end;
    gap: 16px;
    flex-wrap: wrap;
}
.ecacon-filter-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.ecacon-label { font-size: 13px; font-weight: 700; color: #374151; }
.ecacon-select {
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    color: #374151;
    min-width: 260px;
    transition: border-color .2s, box-shadow .2s;
}
.ecacon-select:focus {
    outline: none;
    border-color: #7b1b3b;
    box-shadow: 0 0 0 3px rgba(123,27,59,.12);
}
.ecacon-btn-search {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 22px;
    background: linear-gradient(135deg, #7b1b3b, #a83260);
    color: #fff;
    border: none;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: transform .15s, box-shadow .15s;
    box-shadow: 0 4px 14px rgba(123,27,59,.28);
}
.ecacon-btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(123,27,59,.38);
}

/* DIVIDER ------------------------------------------------------ */
.ecacon-divider { border: none; border-top: 2px solid #f3f4f6; margin: 20px 0; }

/* STATS ------------------------------------------------------- */
.ecacon-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.ecacon-stat-card {
    display: flex;
    align-items: center;
    gap: 14px;
    background: #fdf0f4;
    border-left: 4px solid #7b1b3b;
    border-radius: 12px;
    padding: 16px 20px;
}
.ecacon-stat-icon {
    width: 40px; height: 40px;
    background: linear-gradient(135deg, #7b1b3b, #a83260);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
    color: #fff;
    flex-shrink: 0;
}
.ecacon-stat-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #6b7280;
    margin-bottom: 3px;
}
.ecacon-stat-value {
    font-size: 20px;
    font-weight: 800;
    color: #7b1b3b;
    line-height: 1.1;
}

/* TABLE ------------------------------------------------------- */
.ecacon-table-wrapper {
    overflow-x: auto;
    border-radius: 12px;
    border: 1px solid #f0f0f0;
    margin-bottom: 8px;
}
.ecacon-table { width: 100%; border-collapse: collapse; font-size: 14px; }
.ecacon-table thead tr {
    background: linear-gradient(90deg, #7b1b3b 0%, #a83260 100%);
}
.ecacon-table thead th {
    padding: 13px 16px;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    text-align: left;
    white-space: nowrap;
}
.ecacon-table tbody tr { border-bottom: 1px solid #f3f4f6; transition: background .15s; }
.ecacon-table tbody tr:nth-child(even) { background: #fafafa; }
.ecacon-table tbody tr:hover { background: #fdf0f4; }
.ecacon-table tbody td { padding: 12px 16px; color: #4b5563; }

/* ACTION BUTTONS ---------------------------------------------- */
.ecacon-actions { display: flex; gap: 6px; flex-wrap: nowrap; }
.ecacon-btn-act {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: transform .15s, box-shadow .15s;
}
.ecacon-btn-act:hover { transform: translateY(-1px); }
.ecacon-btn-ver  { background: #eff6ff; color: #1d4ed8; }
.ecacon-btn-ver:hover  { background: #dbeafe; color: #1d4ed8; box-shadow: 0 3px 8px rgba(29,78,216,.15); }
.ecacon-btn-edit { background: #fef3c7; color: #92400e; }
.ecacon-btn-edit:hover { background: #fde68a; color: #92400e; box-shadow: 0 3px 8px rgba(146,64,14,.15); }
.ecacon-btn-pdf  { background: #fdf0f4; color: #7b1b3b; }
.ecacon-btn-pdf:hover  { background: #fce7ef; color: #7b1b3b; box-shadow: 0 3px 8px rgba(123,27,59,.15); }

/* EMPTY ------------------------------------------------------- */
.ecacon-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 40px;
    color: #9ca3af;
    font-size: 14px;
    font-style: italic;
    background: #f9fafb;
    border-radius: 10px;
    margin-top: 8px;
}
.ecacon-empty i { font-size: 20px; }

/* RESPONSIVE -------------------------------------------------- */
@media (max-width: 700px) {
    .ecacon-hero { flex-direction: column; align-items: flex-start; gap: 12px; }
    .ecacon-hero-center { flex-direction: column; align-items: flex-start; }
    .ecacon-body { padding: 20px 16px; }
    .ecacon-filter-row { flex-direction: column; align-items: stretch; }
    .ecacon-select { min-width: 100%; }
    .ecacon-stats { grid-template-columns: 1fr; }
    .ecacon-table thead th, .ecacon-table tbody td { font-size: 12px; padding: 9px 10px; }
    .ecacon-actions { flex-wrap: wrap; }
}
</style>

