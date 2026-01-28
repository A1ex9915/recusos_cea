<style>
/* ===== CONTENEDOR GENERAL ===== */
.eca-consulta-wrapper {
    width: 100%;
    padding: 20px;
    animation: fadeIn .3s ease-in-out;
}
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

.eca-title {
    font-size: 28px;
    font-weight: bold;
    border-left: 6px solid #800000;
    padding-left: 12px;
    margin-bottom: 20px;
    color: #333;
}

/* ===== FILTRO ===== */
.filtro-card {
    background: #fff;
    padding: 18px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    margin-bottom: 20px;
}

.filtro-flex {
    display: flex;
    gap: 18px;
    flex-wrap: wrap;
}

.filtro-card select {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #aaa;
    font-size: 15px;
}

.btn-gold {
    background: #bd9957;
    border: none;
    color: #fff;
    padding: 10px 18px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}

/* ===== TARJETAS DE RESUMEN ===== */
.cards-resumen {
    display: flex;
    gap: 20px;
    margin: 20px 0;
    flex-wrap: wrap;
}

.card-resumen {
    flex: 1;
    min-width: 220px;
    background: #fafafa;
    padding: 18px;
    border-radius: 12px;
    border-left: 6px solid #800000;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.card-resumen h4 {
    margin: 0;
    font-size: 18px;
}

.card-resumen p {
    font-size: 26px;
    margin-top: 6px;
    font-weight: bold;
    color: #800000;
}

/* ===== TABLA ===== */
.eca-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.eca-table thead {
    background: #800000;
    color: #fff;
}

.eca-table th,
.eca-table td {
    padding: 10px;
    border: 1px solid #ddd;
}

.acciones a {
    margin-right: 7px;
    color: #800000;
    font-weight: bold;
    text-decoration: none;
}
</style>


<div class="eca-consulta-wrapper">

    <h2 class="eca-title">Consulta de Fichas Técnicas del ECA</h2>

    <!-- FILTRO -->
    <div class="filtro-card">
        <form method="GET" action="">
            <input type="hidden" name="controller" value="formatos">
            <input type="hidden" name="action" value="consultaECA">

            <div class="filtro-flex">
                <div>
                    <label><strong>Municipio:</strong></label><br>
                    <select name="municipio_id">
                        <option value="">Todos los municipios…</option>
                        <?php foreach ($municipios as $m): ?>
                            <option value="<?= $m['id'] ?>" 
                                <?= ($municipio_id == $m['id'] ? 'selected' : '') ?>>
                                <?= $m['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button class="btn-gold" style="height:42px;margin-top:22px;">
                    Buscar
                </button>
            </div>
        </form>
    </div>


    <!-- TARJETAS RESUMEN -->
   <?php if ($fichas): ?>
<div class="cards-resumen">
    
    <div class="card-resumen">
        <h4>Total de fichas</h4>
        <p><?= count($fichas) ?></p>
    </div>

    <div class="card-resumen">
        <h4>Municipio</h4>
        <p>
            <?= empty($municipio_id) ? 'Todos' : $fichas[0]['municipio'] ?>
        </p>
    </div>

    <div class="card-resumen">
        <h4>Organismo</h4>
        <p>
            <?= empty($municipio_id) ? 'Todos' : $fichas[0]['organismo'] ?>
        </p>
    </div>

</div>
<?php endif; ?>



    <!-- TABLA -->
    <?php if ($fichas): ?>
    <table class="eca-table">
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
                <td><?= $f['id'] ?></td>
                <td><?= $f['clave_eca'] ?></td>
                <td><?= $f['nombre_reca'] ?></td>
                <td><?= $f['habitantes'] ?></td>
                <td><?= $f['fecha_ultimo_fortalecimiento'] ?></td>

                <td class="acciones">
                    <a href="index.php?controller=formatos&action=verECA&id=<?= $f['id'] ?>">Ver</a>
                    |
                    <a href="index.php?controller=formatos&action=generarPDFECA&id=<?= $f['id'] ?>">PDF</a>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php else: ?>
        <p>No hay fichas registradas.</p>
    <?php endif; ?>

</div>
