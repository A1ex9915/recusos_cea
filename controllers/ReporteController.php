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
     *  LISTAR REPORTES MUNICIPALES GENERADOS
     * ========================================================== */
    public function listarReportesMunicipales()
    {
        $this->guard();

        $pdo = DB::conn();
        
        // Obtener filtros
        $municipio_id = $_GET['municipio_id'] ?? '';
        $organismo_id = $_GET['organismo_id'] ?? '';
        $fecha_desde = $_GET['fecha_desde'] ?? '';
        $fecha_hasta = $_GET['fecha_hasta'] ?? '';
        
        // Construir consulta con filtros
        $sql = "
            SELECT 
                r.id,
                r.archivo,
                r.creado_en,
                m.nombre AS municipio,
                o.nombre AS organismo,
                o.siglas AS organismo_siglas
            FROM pdf_reportes r
            LEFT JOIN municipios m ON m.id = r.municipio_id
            LEFT JOIN organismos o ON o.id = r.organismo_id
            WHERE 1=1
        ";
        
        $params = [];
        
        if ($municipio_id !== '') {
            $sql .= " AND r.municipio_id = ?";
            $params[] = (int)$municipio_id;
        }
        
        if ($organismo_id !== '') {
            $sql .= " AND r.organismo_id = ?";
            $params[] = (int)$organismo_id;
        }
        
        if ($fecha_desde !== '') {
            $sql .= " AND DATE(r.creado_en) >= ?";
            $params[] = $fecha_desde;
        }
        
        if ($fecha_hasta !== '') {
            $sql .= " AND DATE(r.creado_en) <= ?";
            $params[] = $fecha_hasta;
        }
        
        $sql .= " ORDER BY r.creado_en DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->render('reportes/municipales.php', compact('reportes'));
    }

    /* ==========================================================
     *  ELIMINAR REPORTE MUNICIPAL
     * ========================================================== */
    public function eliminarReporteMunicipal()
    {
        $this->guard();

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $archivo = $_POST['archivo'] ?? '';

        if (!$id || !$archivo) {
            echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
            exit;
        }

        $pdo = DB::conn();

        // Eliminar archivo físico
        $filePath = dirname(__DIR__) . '/public/pdf/' . $archivo;
        $archivoEliminado = false;
        
        if (file_exists($filePath)) {
            $archivoEliminado = unlink($filePath);
        } else {
            $archivoEliminado = true; // Si no existe, consideramos que está "eliminado"
        }

        // Eliminar registro de la base de datos
        $stmt = $pdo->prepare("DELETE FROM pdf_reportes WHERE id = ?");
        $dbEliminado = $stmt->execute([$id]);

        if ($dbEliminado && $archivoEliminado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el reporte']);
        }
        exit;
    }

    /* ==========================================================
     *  LISTAR REPORTES ANUALES GENERADOS
     * ========================================================== */
    public function listarReportesAnuales()
    {
        $this->guard();

        $pdo = DB::conn();
        
        // Obtener filtros
        $anio = $_GET['anio'] ?? '';
        $fecha_desde = $_GET['fecha_desde'] ?? '';
        $fecha_hasta = $_GET['fecha_hasta'] ?? '';
        
        // Construir consulta con filtros
        $sql = "
            SELECT 
                id,
                archivo,
                anio,
                fecha AS creado_en
            FROM pdf_reportes_anual
            WHERE 1=1
        ";
        
        $params = [];
        
        if ($anio !== '') {
            $sql .= " AND anio = ?";
            $params[] = (int)$anio;
        }
        
        if ($fecha_desde !== '') {
            $sql .= " AND DATE(fecha) >= ?";
            $params[] = $fecha_desde;
        }
        
        if ($fecha_hasta !== '') {
            $sql .= " AND DATE(fecha) <= ?";
            $params[] = $fecha_hasta;
        }
        
        $sql .= " ORDER BY fecha DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $reportes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->render('reportes/anuales.php', compact('reportes'));
    }

    /* ==========================================================
     *  ELIMINAR REPORTE ANUAL
     * ========================================================== */
    public function eliminarReporteAnual()
    {
        $this->guard();

        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Método no permitido']);
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $archivo = $_POST['archivo'] ?? '';

        if (!$id || !$archivo) {
            echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
            exit;
        }

        $pdo = DB::conn();

        // Eliminar archivo físico
        $filePath = dirname(__DIR__) . '/public/pdf/' . $archivo;
        $archivoEliminado = false;
        
        if (file_exists($filePath)) {
            $archivoEliminado = unlink($filePath);
        } else {
            $archivoEliminado = true;
        }

        // Eliminar registro de la base de datos
        $stmt = $pdo->prepare("DELETE FROM pdf_reportes_anual WHERE id = ?");
        $dbEliminado = $stmt->execute([$id]);

        if ($dbEliminado && $archivoEliminado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo eliminar el reporte']);
        }
        exit;
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
        $ubicaciones = Catalogo::ubicaciones();

        $this->render(
            'reportes/inventario.php',
            compact('inventario', 'resumen', 'municipios', 'categorias', 'organismos', 'ubicaciones')
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
    $anio = $_POST['anio'] ?? date('Y');

    // ================================
    // TRAER TODOS LOS RECURSOS
    // Nota: Como los recursos no tienen año_fortalecimiento configurado,
    // se genera el reporte con TODOS los recursos disponibles
    // ================================
    $recursos = Inventario::listarReporte([]);

    if (empty($recursos)) {
        $_SESSION['error'] = "No hay recursos registrados en el sistema.";
        header("Location: " . BASE_URI . "/index.php?controller=reporte&action=reporte&tipo=anual");
        exit;
    }

    // Ordenar por municipio
    usort($recursos, function($a, $b) {
        $municipioA = $a['municipio'] ?? '';
        $municipioB = $b['municipio'] ?? '';
        return strcmp($municipioA, $municipioB);
    });

    // ================================
    // GENERAR PDF CON MPDF
    // ================================
    require_once dirname(__DIR__) . '/vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf([
        'mode'         => 'utf-8',
        'format'       => 'A4-L',
        'margin_top'   => 40,
        'margin_bottom'=> 20,
        'margin_left'  => 10,
        'margin_right' => 10
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
            h2 { 
                text-align:center; 
                margin-bottom:10px; 
                color:#78002e; 
                font-size:18px;
            }
            .subtitulo {
                text-align:center;
                margin-bottom:15px;
                font-size:12px;
            }
            table { 
                width:100%; 
                border-collapse:collapse; 
                font-size:8px; 
            }
            th {
                background:#78002e;
                color:white;
                padding:5px 3px;
                border:1px solid #333;
                text-align:center;
                font-weight:bold;
                font-size:8px;
            }
            td {
                padding:4px 2px;
                border:1px solid #666;
                font-size:7px;
                vertical-align:top;
            }
            .text-center {
                text-align:center;
            }
        </style>
    ";

    // GENERAR HTML
    ob_start();
    ?>

    <?= $estilos ?>

    <h2>Fortalecimiento de Espacios de Cultura del Agua <?= htmlspecialchars($anio) ?></h2>

    <p class="subtitulo">
        <strong>Total de recursos:</strong> <?= count($recursos) ?> | 
        <strong>Fecha de generación:</strong> <?= date('d/m/Y H:i') ?>
    </p>

    <table>
        <thead>
            <tr>
                <th style="width:3%;">No.</th>
                <th style="width:15%;">Descripción</th>
                <th style="width:12%;">Acción</th>
                <th style="width:3%;">Cant.</th>
                <th style="width:10%;">Concepto</th>
                <th style="width:4%;">Año</th>
                <th style="width:8%;">Marca</th>
                <th style="width:8%;">Modelo</th>
                <th style="width:8%;">No. Serie</th>
                <th style="width:6%;">Color</th>
                <th style="width:8%;">Material</th>
                <th style="width:10%;">Municipio</th>
                <th style="width:5%;">Beneficiario</th>
            </tr>
        </thead>

        <tbody>
        <?php 
        $contador = 1;
        foreach ($recursos as $r): ?>
            <tr>
                <td class="text-center"><?= $contador ?></td>
                <td><?= htmlspecialchars($r['descripcion']) ?></td>
                <td><?= htmlspecialchars($r['accion'] ?? 'Fortalecimiento de Espacios de Cultura del Agua') ?></td>
                <td class="text-center"><?= $r['cantidad'] ?? 1 ?></td>
                <td><?= htmlspecialchars($r['categoria']) ?></td>
                <td class="text-center"><?= $r['anio'] ?? $anio ?></td>
                <td><?= htmlspecialchars($r['marca'] ?? 'Sin Marca') ?></td>
                <td><?= htmlspecialchars($r['modelo'] ?? 'Sin modelo') ?></td>
                <td><?= htmlspecialchars($r['no_serie'] ?? 'Sin número de serie') ?></td>
                <td><?= htmlspecialchars($r['color'] ?? 'Multicolor') ?></td>
                <td><?= htmlspecialchars($r['material'] ?? '') ?></td>
                <td><?= htmlspecialchars($r['municipio']) ?></td>
                <td><?= htmlspecialchars($r['beneficiario'] ?? '') ?></td>
            </tr>
        <?php 
        $contador++;
        endforeach; ?>
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

    $fileName = "ReporteAnual_{$anio}_" . date("Ymd_His") . ".pdf";
    $filePath = $pdfDir . $fileName;

    $mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);

    // ================================
    // GUARDAR REGISTRO BD
    // ================================
    $pdo = DB::conn();
    $stmt = $pdo->prepare("
        INSERT INTO pdf_reportes_anual (archivo, anio, fecha)
        VALUES (?, ?, NOW())
    ");
    $stmt->execute([$fileName, $anio]);

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
