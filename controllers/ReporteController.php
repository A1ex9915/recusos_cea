<?php

class ReporteController
{
    private function guard()
    {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URI . '/index.php?controller=auth&action=login');
            exit;
        }
    }

    private function render(string $vista, array $vars = [])
    {
        extract($vars);
        $_SESSION['vista'] = $vista;
        require dirname(__DIR__) . '/views/dashboard.php';
    }

    /* ==========================================================
     *  EXPORTAR EXCEL (general o formato especial CEAA)
     * ========================================================== */
 public function excel()
{
    $this->guard();

    $tipo = $_GET['tipo'] ?? '';

    if ($tipo === 'formato_anual') {
        require __DIR__ . '/export/InventarioFormatoAnualPDF.php';
        return;
    }

    if ($tipo === 'formato_municipio') {
        require __DIR__ . '/export/InventarioFormatoMunicipioPDF.php';
        return;
    }

    header("HTTP/1.1 400 Bad Request");
    exit;
}



    /* ==========================================================
     *  REPORTE DE INVENTARIO (vista)
     * ========================================================== */
    public function inventario()
    {
        $this->guard();

        $filtros = [
            'q'           => $_GET['q'] ?? '',
            'categoria'   => $_GET['categoria'] ?? '',
            'estado_bien' => $_GET['estado_bien'] ?? '',
            'anio'        => $_GET['anio'] ?? '',
        ];

        $inventario = Inventario::listarReporte($filtros);

        $resumen = [
            'total'   => count($inventario),
            'bueno'   => count(array_filter($inventario, fn($i) => $i['estado_bien'] === 'bueno')),
            'regular' => count(array_filter($inventario, fn($i) => $i['estado_bien'] === 'regular')),
            'malo'    => count(array_filter($inventario, fn($i) => $i['estado_bien'] === 'malo')),
            'baja'    => count(array_filter($inventario, fn($i) => $i['estado_bien'] === 'baja')),
        ];

        $municipios = Catalogo::municipios();
        $categorias = Catalogo::categorias();
        $organismos = Catalogo::organismos();

        $this->render(
            'reportes/inventario.php',
            compact('inventario', 'resumen', 'municipios', 'categorias', 'organismos')
        );
    }
public function generarMunicipioPDF()
{
    $this->guard();

    // ==============================================
    // RECIBIR DATOS DEL FORMULARIO
    // ==============================================
    // DATOS DEL FORMULARIO
$anio          = $_POST['anio'] ?? date('Y');
$municipio_id  = $_POST['municipio_id'] ?? null;
$beneficiario  = $_POST['beneficiario'] ?? '—';
$accion        = $_POST['accion'] ?? '—';
$idsRecursos   = $_POST['recursos'] ?? [];

if (!$municipio_id || empty($idsRecursos)) {
    exit("Faltan datos para generar el PDF");
}

// RECURSOS SELECCIONADOS
$recursos = Inventario::obtenerPorIds($idsRecursos);

if (empty($recursos)) exit("No se encontraron recursos.");

// ===============
// ORGANISMO REAL
// ===============
$organismo_id = $_POST['organismo_id'] ?? null;
  
$organismo = Inventario::obtenerNombreOrganismo($organismo_id);

// MUNICIPIO
$municipio = Inventario::obtenerNombreMunicipio($municipio_id);


    // ==============================================
    // MPDF
    // ==============================================
    require_once dirname(__DIR__) . '/vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf([
        'mode'         => 'utf-8',
        'format'       => 'A4-L',
        'margin_top'   => 40,
        'margin_bottom'=> 20
    ]);

    // LOGO
    $logo = "../public/assets/img/logo.png";

    $mpdf->SetHTMLHeader("
        <div style='text-align:left;'>
            <img src='$logo' height='60'>
        </div>
    ");

    // ==============================================
    // ESTILOS
    // ==============================================
    $estilos = "
        <style>
            h2 { text-align:center; margin-bottom:5px; }
            table { width:100%; border-collapse:collapse; font-size:11px; }
            th {
                background:#555;
                color:white;
                padding:6px;
                border:1px solid #333;
                text-align:center;
            }
            td {
                padding:6px;
                border:1px solid #555;
            }
        </style>
    ";

    ob_start();
    ?>

    <?= $estilos ?>

    <h2>
        Fortalecimiento de Espacios de Cultura del Agua<br>
        Municipio de <?= htmlspecialchars($municipio) ?>
    </h2>

    <table>
        <thead>
            <tr>
                <th>No. Inventario</th>
                <th>Descripción</th>
                <th>Acción</th>
                <th>Concepto</th>
                <th>Año de fortalecimiento</th>
                <th>Cantidad</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>No. Serie</th>
                <th>Color</th>
                <th>Material</th>
                <th>Municipio</th>
                <th>Organismo</th>
                <th>Beneficiario</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($recursos as $r): ?>
            <tr>
                <td><?= $r['no_inventario'] ?></td>
                <td><?= $r['descripcion_larga'] ?></td>
                <td><?= htmlspecialchars($accion) ?></td>
                <td><?= $r['categoria'] ?></td>
                <td><?= $anio ?></td>
                <td><?= $r['cantidad'] ?></td>
                <td><?= $r['marca'] ?></td>
                <td><?= $r['modelo'] ?></td>
                <td><?= $r['numero_serie'] ?></td>
                <td><?= $r['color'] ?></td>
                <td><?= $r['material'] ?? '—' ?></td>
                <td><?= $municipio ?></td>
                <td><?= $organismo ?></td>
                <td><?= htmlspecialchars($beneficiario) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    $html = ob_get_clean();
    $mpdf->WriteHTML($html);

    // ==============================================
    // GUARDAR PDF
    // ==============================================
    $pdfDir = dirname(__DIR__) . "/public/pdf/";
    if (!is_dir($pdfDir)) mkdir($pdfDir, 0777, true);

    $fileName = "Municipio_{$municipio_id}_" . date("Ymd_His") . ".pdf";
    $filePath = $pdfDir . $fileName;

    $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

    // ==============================================
    // GUARDAR REGISTRO EN BD
    // ==============================================
    $pdo = DB::conn();
    $pdo->prepare("
        INSERT INTO pdf_reportes (municipio_id, organismo_id, archivo)
        VALUES (?, ?, ?)
    ")->execute([$municipio_id, $organismo_id, $fileName]);

    // ==============================================
    // MOSTRAR AL USUARIO
    // ==============================================
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename={$fileName}");
    readfile($filePath);
    exit;
}


public function generarAnualPDF()
{
    $this->guard();

    // ================================
    // DATOS DEL FORMULARIO
    // ================================
    $anio          = $_POST['anio'] ?? date('Y');
    $accion        = $_POST['accion'] ?? '—';
    $beneficiario  = $_POST['beneficiario'] ?? '—';

    // ================================
    // TRAER TODOS LOS RECURSOS DEL ESTADO
    // ================================
    $recursos = Inventario::listarReporte([]);

    if (empty($recursos)) exit("No hay recursos para generar el reporte anual.");

    // ================================
    // MPDF CONFIG
    // ================================
    require_once dirname(__DIR__) . '/vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf([
        'mode'         => 'utf-8',
        'format'       => 'A4-L',
        'margin_top'   => 40,
        'margin_bottom'=> 20
    ]);

    // LOGO
    $logo = "../public/assets/img/logo.png";

    $mpdf->SetHTMLHeader("
        <div style='text-align:left;'>
            <img src='$logo' height='60'>
        </div>
    ");

    // ESTILOS
    $estilos = "
        <style>
            h2 { text-align:center; margin-bottom:5px; }
            table { width:100%; border-collapse:collapse; font-size:11px; }
            th {
                background:#78002e;
                color:white;
                padding:6px;
                border:1px solid #333;
                text-align:center;
            }
            td {
                padding:6px;
                border:1px solid #555;
            }
        </style>
    ";

    // ================================
    // GENERAR HTML
    // ================================
    ob_start();
    ?>

    <?= $estilos ?>

    <h2>
        Reporte Anual Estatal de Entregas<br>
        Año <?= htmlspecialchars($anio) ?>
    </h2>

    <p><strong>Acción global:</strong> <?= htmlspecialchars($accion) ?></p>
    <p><strong>Beneficiario global:</strong> <?= htmlspecialchars($beneficiario) ?></p>

    <table>
        <thead>
            <tr>
                <th>No. Inventario</th>
                <th>Descripción</th>
                <th>Concepto</th>
                <th>Año Fortalecimiento</th>
                <th>Cantidad</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>No. Serie</th>
                <th>Color</th>
                <th>Material</th>
                <th>Municipio</th>
                <th>Organismo</th>
            </tr>
        </thead>

        <tbody>
        <?php
        // Ordenar por municipio
        usort($recursos, function($a, $b) {
            return strcmp($a['municipio'], $b['municipio']);
        });

        foreach ($recursos as $r): ?>
            <tr>
                <td><?= $r['no_inventario'] ?></td>
                <td><?= $r['descripcion_larga'] ?></td>
                <td><?= $r['categoria'] ?></td>
                <td><?= $anio ?></td>
                <td><?= $r['cantidad'] ?></td>
                <td><?= $r['marca'] ?></td>
                <td><?= $r['modelo'] ?></td>
                <td><?= $r['no_serie'] ?></td>
                <td><?= $r['color'] ?></td>
                <td><?= $r['material'] ?></td>
                <td><?= $r['municipio'] ?></td>
                <td><?= $r['organismo'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    $html = ob_get_clean();
    $mpdf->WriteHTML($html);

    // ================================
    // GUARDAR PDF
    // ================================
    $pdfDir = dirname(__DIR__) . "/public/pdf/";
    if (!is_dir($pdfDir)) mkdir($pdfDir, 0777, true);

    $fileName = "ReporteAnual_" . date("Ymd_His") . ".pdf";
    $filePath = $pdfDir . $fileName;

    $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

    // ================================
    // GUARDAR REGISTRO BD
    // ================================
    $pdo = DB::conn();
    $pdo->prepare("
        INSERT INTO pdf_reportes_anual (archivo, anio)
        VALUES (?, ?)
    ")->execute([$fileName, $anio]);

    // ================================
    // MOSTRAR AL USUARIO
    // ================================
    header("Content-Type: application/pdf");
    header("Content-Disposition: inline; filename={$fileName}");
    readfile($filePath);
    exit;
}



public function reporte()
{
    $this->guard();

    $municipios  = Catalogo::municipios();
    $organismos  = Catalogo::organismos();

    $municipio_id = $_GET['municipio_id'] ?? null;

    // Filtrar organismos del municipio seleccionado
    $organismos_filtrados = [];
    if ($municipio_id) {
        foreach ($organismos as $o) {
            if ($o['municipio_id'] == $municipio_id) {
                $organismos_filtrados[] = $o;
            }
        }
    }

    // Recursos disponibles para este municipio
    $recursos = $municipio_id
        ? Inventario::listarReporte(['municipio_id' => $municipio_id])
        : [];

    $this->render("formatos/reporte.php", [
        "municipios"           => $municipios,
        "organismos"           => $organismos,  // lista completa (para el JS)
        "organismos_filtrados" => $organismos_filtrados,
        "recursos"             => $recursos,
        "municipio_id"         => $municipio_id
    ]);
}



}
