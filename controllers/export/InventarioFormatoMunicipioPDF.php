<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/models/Inventario.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;

$anio          = $_GET['anio'] ?? date('Y');
$municipioId   = $_GET['municipio_id'] ?? null;
$organismoId   = $_GET['organismo_id'] ?? null;

$template = __DIR__ . "/Formatos.xlsx";
$excel    = IOFactory::load($template);

// Hoja formato municipal
$hoja = $excel->getSheetByName("Formato por municipio");

// ==========================
//      INSERTAR LOGO CEAA
// ==========================
$logo = new Drawing();
$logo->setName("Logo CEAA");
$logo->setPath(dirname(__DIR__) . '/public/assets/img/logo.png');
$logo->setCoordinates('A1');
$logo->setHeight(85);
$logo->setWorksheet($hoja);

// ==========================
//   ENCABEZADO PRINCIPAL
// ==========================
$nombreMunicipio = Inventario::obtenerNombreMunicipio($municipioId);

$hoja->mergeCells("A5:O5");
$hoja->setCellValue(
    "A5",
    "Fortalecimiento de Espacios de Cultura del Agua del Municipio de $nombreMunicipio"
);

$hoja->getStyle("A5")->getFont()->setBold(true)->setSize(16);
$hoja->getStyle("A5")->getAlignment()->setHorizontal('center');

// ==========================
//   OBTENER LOS REGISTROS
// ==========================
$data = Inventario::obtenerPorMunicipio($municipioId);  // 🔥 CORRECTO

$fila = 10;

// ==========================
//   RELLENAR TABLA
// ==========================
foreach ($data as $i) {

    $hoja->setCellValue("A{$fila}", $i['id']);                        // No.
    $hoja->setCellValue("B{$fila}", $i['descripcion_larga']);        // Descripción completa
    $hoja->setCellValue("C{$fila}", $i['accion'] ?? "");             // Acción (si existe)
    $hoja->setCellValue("D{$fila}", $i['cantidad'] ?? 1);            // Cantidad
    $hoja->setCellValue("E{$fila}", $i['categoria']);                // Concepto
    $hoja->setCellValue("F{$fila}", $anio);                          // Año fortalecimiento
    $hoja->setCellValue("G{$fila}", $i['marca'] ?? "Sin Marca");     // Marca
    $hoja->setCellValue("H{$fila}", $i['modelo'] ?? "Sin modelo");   // Modelo
    $hoja->setCellValue("I{$fila}", $i['numero_serie'] ?? "S/N");    // No. Serie
    $hoja->setCellValue("J{$fila}", $i['color'] ?? "Multicolor");    // Color
    $hoja->setCellValue("K{$fila}", $i['material'] ?? "");           // Material
    $hoja->setCellValue("L{$fila}", $i['municipio']);                // Municipio
    $hoja->setCellValue("M{$fila}", $i['beneficiario'] ?? "");       // Beneficiario
    $hoja->setCellValue("N{$fila}", $i['costo_unitario']);           // Costo
    $hoja->setCellValue("O{$fila}", $i['observaciones'] ?? "");      // Observaciones

    $fila++;
}

// Bordes de tabla
$hoja->getStyle("A10:O{$fila}")
     ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

// Auto-ajuste de columnas
foreach (range('A', 'O') as $col) {
    $hoja->getColumnDimension($col)->setAutoSize(true);
}

// ==========================
//    DESCARGAR ARCHIVO
// ==========================
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=Formato_Municipio_{$municipioId}_{$anio}.xlsx");

$writer = IOFactory::createWriter($excel, 'Xlsx');
$writer->save("php://output");
exit;
