<?php
/**
 * views/bitacora/index.php
 * Módulo de auditoría — visible solo para luis.roldangamero@gmail.com
 */
?>

<style>
/* ── Hero ─────────────────────────────────────────────────── */
.bit-hero {
  position: relative;
  overflow: hidden;
  background: linear-gradient(135deg, #7b1b3b 0%, #a83260 100%);
  border-radius: 16px;
  padding: 2rem 2.5rem;
  margin-bottom: 1.8rem;
  color: #fff;
  display: flex;
  align-items: center;
  gap: 1.2rem;
  box-shadow: 0 8px 32px rgba(123,27,59,.25);
}
.bit-hero::before,
.bit-hero::after {
  content: '';
  position: absolute;
  border-radius: 50%;
  background: rgba(255,255,255,.07);
  z-index: 0;
}
.bit-hero::before { width: 220px; height: 220px; top: -60px; right: -40px; }
.bit-hero::after  { width: 140px; height: 140px; bottom: -50px; right: 100px; }
.bit-hero > * { position: relative; z-index: 1; }
.bit-hero-icon {
  font-size: 2.6rem;
  background: rgba(255,255,255,.15);
  border-radius: 50%;
  width: 64px; height: 64px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.bit-hero h1 { font-size: 1.5rem; font-weight: 700; margin: 0 0 .25rem; }
.bit-hero p  { margin: 0; opacity: .85; font-size: .9rem; }
.bit-badge-acceso {
  margin-left: auto;
  background: rgba(255,255,255,.2);
  border: 1px solid rgba(255,255,255,.35);
  border-radius: 20px;
  padding: .3rem .9rem;
  font-size: .8rem;
  white-space: nowrap;
}

/* ── Cards de resumen ─────────────────────────────────────── */
.bit-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
  gap: 1rem;
  margin-bottom: 1.8rem;
}
.bit-card {
  background: #fff;
  border-radius: 12px;
  padding: 1.2rem 1rem;
  text-align: center;
  box-shadow: 0 2px 12px rgba(0,0,0,.07);
  border-top: 4px solid #7b1b3b;
}
.bit-card.verde  { border-top-color: #2d8a4e; }
.bit-card.rojo   { border-top-color: #c0392b; }
.bit-card.azul   { border-top-color: #2980b9; }
.bit-card-num  { font-size: 1.9rem; font-weight: 800; color: #7b1b3b; line-height: 1; }
.bit-card.verde .bit-card-num  { color: #2d8a4e; }
.bit-card.rojo  .bit-card-num  { color: #c0392b; }
.bit-card.azul  .bit-card-num  { color: #2980b9; }
.bit-card-lbl  { font-size: .75rem; color: #666; margin-top: .35rem; }

/* ── Filtros ──────────────────────────────────────────────── */
.bit-filtros {
  background: #fff;
  border-radius: 12px;
  padding: 1.2rem 1.5rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 2px 12px rgba(0,0,0,.07);
}
.bit-filtros h3 {
  margin: 0 0 1rem;
  font-size: .9rem;
  color: #7b1b3b;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .05em;
  border-left: 3px solid #7b1b3b;
  padding-left: .6rem;
}
.bit-filtros-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: .8rem;
  align-items: end;
}
.bit-filtros label { font-size: .8rem; color: #555; display: block; margin-bottom: .3rem; }
.bit-filtros select,
.bit-filtros input[type=date] {
  width: 100%;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: .45rem .7rem;
  font-size: .85rem;
  color: #333;
  background: #fafafa;
  outline: none;
  transition: border-color .2s;
}
.bit-filtros select:focus,
.bit-filtros input[type=date]:focus { border-color: #7b1b3b; background: #fff; }
.bit-filtros-btns { display: flex; gap: .6rem; flex-wrap: wrap; }
.btn-filtrar {
  background: #7b1b3b; color: #fff; border: none; border-radius: 8px;
  padding: .5rem 1.2rem; font-size: .85rem; cursor: pointer;
  transition: background .2s;
}
.btn-filtrar:hover { background: #9e2150; }
.btn-limpiar {
  background: #f0f0f0; color: #555; border: none; border-radius: 8px;
  padding: .5rem 1rem; font-size: .85rem; cursor: pointer; text-decoration: none;
  display: inline-flex; align-items: center;
  transition: background .2s;
}
.btn-limpiar:hover { background: #e0e0e0; }

/* ── Tabla ────────────────────────────────────────────────── */
.bit-table-wrap {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0,0,0,.07);
  overflow: hidden;
  margin-bottom: 1.5rem;
}
.bit-table-header {
  background: linear-gradient(90deg, #7b1b3b, #a83260);
  padding: .9rem 1.4rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.bit-table-header span { color: #fff; font-size: .9rem; }
.bit-table-header strong { color: rgba(255,255,255,.8); font-size: .8rem; font-weight: 400; }
.bit-table { width: 100%; border-collapse: collapse; font-size: .83rem; }
.bit-table thead th {
  background: #f8f0f3;
  color: #7b1b3b;
  padding: .65rem .9rem;
  text-align: left;
  font-weight: 700;
  font-size: .78rem;
  text-transform: uppercase;
  letter-spacing: .04em;
  border-bottom: 2px solid #edd5de;
}
.bit-table tbody tr { transition: background .15s; }
.bit-table tbody tr:hover { background: #fdf7f9; }
.bit-table tbody tr:not(:last-child) { border-bottom: 1px solid #f0e0e6; }
.bit-table td { padding: .6rem .9rem; color: #444; vertical-align: top; max-width: 220px; word-break: break-word; }
.bit-table td.td-id    { color: #aaa; font-size: .75rem; white-space: nowrap; }
.bit-table td.td-fecha { white-space: nowrap; font-size: .78rem; color: #888; }
.bit-table td.td-ip    { font-family: monospace; font-size: .78rem; color: #999; white-space: nowrap; }
.bit-table td.td-detalle { max-width: 280px; }
.bit-detalle-text { max-height: 2.8em; overflow: hidden; }

/* Badges de acción */
.bit-badge {
  display: inline-block;
  border-radius: 20px;
  padding: .2rem .65rem;
  font-size: .73rem;
  font-weight: 700;
  white-space: nowrap;
}
.bit-badge-login       { background: #d4edda; color: #155724; }
.bit-badge-login_fallido { background: #f8d7da; color: #721c24; }
.bit-badge-logout      { background: #e2e3e5; color: #383d41; }
.bit-badge-crear       { background: #cce5ff; color: #004085; }
.bit-badge-actualizar  { background: #fff3cd; color: #856404; }
.bit-badge-eliminar    { background: #f8d7da; color: #721c24; }
.bit-badge-default     { background: #e8f0fe; color: #3c4043; }

/* Badge módulo */
.bit-modulo {
  display: inline-block;
  background: #f0e6ec;
  color: #7b1b3b;
  border-radius: 6px;
  padding: .15rem .5rem;
  font-size: .73rem;
  font-weight: 600;
}

/* Usuario */
.bit-usuario { font-weight: 600; color: #333; display: block; font-size: .82rem; }
.bit-usuario-email { font-size: .73rem; color: #999; }

/* Vacío */
.bit-empty {
  text-align: center;
  padding: 3rem 1rem;
  color: #aaa;
}
.bit-empty i { font-size: 2.5rem; display: block; margin-bottom: .6rem; }

/* ── Paginación ───────────────────────────────────────────── */
.bit-pag {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .4rem;
  flex-wrap: wrap;
  padding: .5rem 0 1rem;
}
.bit-pag a,
.bit-pag span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 34px; height: 34px;
  border-radius: 8px;
  font-size: .82rem;
  text-decoration: none;
  border: 1px solid #ddd;
  color: #555;
  background: #fff;
  transition: all .2s;
}
.bit-pag a:hover     { background: #f8f0f3; border-color: #7b1b3b; color: #7b1b3b; }
.bit-pag span.activo { background: #7b1b3b; color: #fff; border-color: #7b1b3b; font-weight: 700; }
.bit-pag span.puntos { border: none; background: none; color: #aaa; }
</style>

<!-- Hero -->
<div class="bit-hero">
  <div class="bit-hero-icon"><i class="fa-solid fa-shield-halved"></i></div>
  <div>
    <h1>Bitácora de Auditoría</h1>
    <p>Registro completo de acciones en el sistema — acceso restringido</p>
  </div>
  <span class="bit-badge-acceso"><i class="fa-solid fa-lock"></i> Acceso exclusivo</span>
</div>

<!-- Tarjetas de resumen -->
<div class="bit-cards">
  <div class="bit-card">
    <div class="bit-card-num"><?= number_format((int)($stResumen['total'] ?? 0)) ?></div>
    <div class="bit-card-lbl">Total de registros</div>
  </div>
  <div class="bit-card verde">
    <div class="bit-card-num"><?= number_format((int)($stResumen['logins'] ?? 0)) ?></div>
    <div class="bit-card-lbl">Inicios de sesión</div>
  </div>
  <div class="bit-card rojo">
    <div class="bit-card-num"><?= number_format((int)($stResumen['fallidos'] ?? 0)) ?></div>
    <div class="bit-card-lbl">Accesos fallidos</div>
  </div>
  <div class="bit-card azul">
    <div class="bit-card-num"><?= number_format((int)($stResumen['cambios'] ?? 0)) ?></div>
    <div class="bit-card-lbl">Cambios de datos</div>
  </div>
</div>

<!-- Filtros -->
<?php
  /* Construir query string manteniendo filtros activos para la paginación */
  function bitQs(array $extra = [], array $excluir = []): string {
    $base = [
      'controller'  => 'bitacora',
      'action'      => 'index',
      'modulo'      => $_GET['modulo']      ?? '',
      'accion'      => $_GET['accion']      ?? '',
      'usuario_id'  => $_GET['usuario_id']  ?? '',
      'fecha_desde' => $_GET['fecha_desde'] ?? '',
      'fecha_hasta' => $_GET['fecha_hasta'] ?? '',
    ];
    foreach ($excluir as $k) unset($base[$k]);
    return http_build_query(array_filter(array_merge($base, $extra), fn($v) => $v !== ''));
  }
?>
<div class="bit-filtros">
  <h3><i class="fa-solid fa-filter"></i> Filtros</h3>
  <form method="GET" action="<?= htmlspecialchars(BASE_URI) ?>/index.php">
    <input type="hidden" name="controller" value="bitacora">
    <input type="hidden" name="action"     value="index">
    <div class="bit-filtros-grid">
      <div>
        <label>Módulo</label>
        <select name="modulo">
          <option value="">Todos</option>
          <?php foreach ($modulos as $m): ?>
            <option value="<?= htmlspecialchars($m) ?>" <?= $filtroModulo === $m ? 'selected' : '' ?>>
              <?= htmlspecialchars($m) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label>Acción</label>
        <select name="accion">
          <option value="">Todas</option>
          <?php foreach ($acciones as $a): ?>
            <option value="<?= htmlspecialchars($a) ?>" <?= $filtroAccion === $a ? 'selected' : '' ?>>
              <?= htmlspecialchars($a) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label>Usuario</label>
        <select name="usuario_id">
          <option value="">Todos</option>
          <?php foreach ($usuarios as $u): ?>
            <option value="<?= (int)$u['id'] ?>" <?= (string)$filtroUsuario === (string)$u['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($u['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div>
        <label>Desde</label>
        <input type="date" name="fecha_desde" value="<?= htmlspecialchars($filtroDesde) ?>">
      </div>
      <div>
        <label>Hasta</label>
        <input type="date" name="fecha_hasta" value="<?= htmlspecialchars($filtroHasta) ?>">
      </div>
      <div class="bit-filtros-btns">
        <button type="submit" class="btn-filtrar"><i class="fa-solid fa-magnifying-glass"></i> Filtrar</button>
        <a href="<?= BASE_URI ?>/index.php?controller=bitacora&action=index" class="btn-limpiar">
          <i class="fa-solid fa-xmark"></i> Limpiar
        </a>
      </div>
    </div>
  </form>
</div>

<!-- Tabla -->
<div class="bit-table-wrap">
  <div class="bit-table-header">
    <span><i class="fa-solid fa-list-check"></i> Registros</span>
    <strong><?= number_format($total) ?> resultado<?= $total !== 1 ? 's' : '' ?></strong>
  </div>

  <?php if (empty($registros)): ?>
    <div class="bit-empty">
      <i class="fa-solid fa-inbox"></i>
      No se encontraron registros con los filtros aplicados.
    </div>
  <?php else: ?>
    <div style="overflow-x:auto">
      <table class="bit-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Usuario</th>
            <th>Acción</th>
            <th>Módulo</th>
            <th>Detalle</th>
            <th>IP</th>
            <th>Fecha y hora</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($registros as $r):
            $badgeClass = match($r['accion'] ?? '') {
              'login'          => 'bit-badge-login',
              'login_fallido'  => 'bit-badge-login_fallido',
              'logout'         => 'bit-badge-logout',
              'crear'          => 'bit-badge-crear',
              'actualizar'     => 'bit-badge-actualizar',
              'eliminar'       => 'bit-badge-eliminar',
              default          => 'bit-badge-default',
            };
          ?>
            <tr>
              <td class="td-id"><?= (int)$r['id'] ?></td>
              <td>
                <span class="bit-usuario"><?= htmlspecialchars($r['usuario_nombre']) ?></span>
                <?php if ($r['usuario_email']): ?>
                  <span class="bit-usuario-email"><?= htmlspecialchars($r['usuario_email']) ?></span>
                <?php endif; ?>
              </td>
              <td>
                <span class="bit-badge <?= $badgeClass ?>">
                  <?= htmlspecialchars($r['accion']) ?>
                </span>
              </td>
              <td>
                <span class="bit-modulo"><?= htmlspecialchars($r['modulo']) ?></span>
              </td>
              <td class="td-detalle">
                <div class="bit-detalle-text" title="<?= htmlspecialchars($r['detalle'] ?? '') ?>">
                  <?= htmlspecialchars($r['detalle'] ?? '—') ?>
                </div>
              </td>
              <td class="td-ip"><?= htmlspecialchars($r['ip'] ?? '—') ?></td>
              <td class="td-fecha">
                <?= htmlspecialchars(date('d/m/Y H:i', strtotime($r['creado_en']))) ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<!-- Paginación -->
<?php if ($totalPaginas > 1): ?>
  <div class="bit-pag">
    <?php if ($pagina > 1): ?>
      <a href="<?= BASE_URI ?>/index.php?<?= bitQs(['pagina' => $pagina - 1]) ?>">
        <i class="fa-solid fa-chevron-left"></i>
      </a>
    <?php endif; ?>

    <?php
      $rango = 2;
      for ($i = 1; $i <= $totalPaginas; $i++):
        if ($i === 1 || $i === $totalPaginas || abs($i - $pagina) <= $rango):
          if ($i === $pagina):
    ?>
          <span class="activo"><?= $i ?></span>
    <?php   else: ?>
          <a href="<?= BASE_URI ?>/index.php?<?= bitQs(['pagina' => $i]) ?>"><?= $i ?></a>
    <?php   endif;
        elseif (abs($i - $pagina) === $rango + 1):
    ?>
          <span class="puntos">…</span>
    <?php
        endif;
      endfor;
    ?>

    <?php if ($pagina < $totalPaginas): ?>
      <a href="<?= BASE_URI ?>/index.php?<?= bitQs(['pagina' => $pagina + 1]) ?>">
        <i class="fa-solid fa-chevron-right"></i>
      </a>
    <?php endif; ?>
  </div>
<?php endif; ?>
