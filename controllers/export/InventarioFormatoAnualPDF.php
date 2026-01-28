<?php
require __DIR__ . "/../../vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$data = $reporteData ?? [];
$anio = $_GET['anio'] ?? date("Y");

ob_start();
?>

<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
h2 { text-align:center; margin-bottom: 10px; }
table { width:100%; border-collapse: collapse; font-size: 10px; }
th, td { border:1px solid #000; padding:4px; }
th { background:#e8e8e8; }
.header-logos { width: 100%; text-align:center; }
</style>

<div class="header-logos">
    <img src="<?= BASE_URI ?>/public/assets/img/logo.png" width="130">
</div>

<h2>Fortalecimiento de Espacios de Cultura del Agua - Consolidado <?= $anio ?></h2>

<table>
<thead>
<tr>
    <th>No.</th>
    <th>Municipio</th>
    <th>Descripción</th>
    <th>Acción</th>
    <th>Cantidad</th>
    <th>Concepto</th>
    <th>Año</th>
    <th>Marca</th>
    <th>Modelo</th>
    <th>No. Serie</th>
    <th>Color</th>
    <th>Material</th>
</tr>
</thead>
<tbody>

<?php foreach ($data as $i => $row): ?>
<tr>
    <td><?= $i+1 ?></td>
    <td><?= $row['municipio'] ?></td>
    <td><?= $row['descripcion'] ?></td>
    <td><?= $row['accion'] ?></td>
    <td><?= $row['cantidad'] ?></td>
    <td><?= $row['concepto'] ?></td>
    <td><?= $row['anio'] ?></td>
    <td><?= $row['marca'] ?></td>
    <td><?= $row['modelo'] ?></td>
    <td><?= $row['no_serie'] ?></td>
    <td><?= $row['color'] ?></td>
    <td><?= $row['material'] ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<?php
$html = ob_get_clean();

$dompdf->loadHtml($html);
$dompdf->setPaper('landscape', 'A4');
$dompdf->render();
$dompdf->stream("Formato_Anual_$anio.pdf", ["Attachment" => true]);
exit;
