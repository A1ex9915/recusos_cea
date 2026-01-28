<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/models/Inventario.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;

$anio = $_GET['anio'] ?? date('Y');
$municipioId = $_GET['municipio_id'] ?? null;
$organismoId = $_GET['organismo_id'] ?? null;

$template = __DIR__ . "/Formatos.xlsx";
$excel = IOFactory::load($template);

// HOJA
$hoja = $excel->getSheetByName("Formato por municipio");

// LOGO
$logo = new Drawing();
$logo->setName("Logo CEAA");
$logo->setPath(dirname(__DIR__) . '/public/assets/img/logo.png');
$logo->setCoordinates('A1');
$logo->setHeight(85);
$logo->setOffsetX(5);
$logo->setWorksheet($hoja);

// ENCABEZADO
$nombreMunicipio = Inventario::obtenerNombreMunicipio($municipioId);
$hoja->mergeCells("A5:O5");
$hoja->setCellValue("A5", "Fortalecimiento de Espacios de Cultura del Agua del Municipio de $nombreMunicipio");
$hoja->getStyle("A5")->getFont()->setBold(true)->setSize(16);
$hoja->getStyle("A5")->getAlignment()->setHorizontal('center');

// DATOS
$data = Inventario::listarReporte(['municipio_id' => $municipioId]);

$fila = 10;

foreach ($data as $i) {

    $hoja->setCellValue("A{$fila}", $i['no_inventario']);
    $hoja->setCellValue("B{$fila}", $i['descripcion']);
    $hoja->setCellValue("C{$fila}", $i['accion'] ?? "");
    $hoja->setCellValue("D{$fila}", 1);
    $hoja->setCellValue("E{$fila}", $i['categoria']);
    $hoja->setCellValue("F{$fila}", $i['anio'] ?? $anio);
    $hoja->setCellValue("G{$fila}", $i['marca'] ?? "Sin Marca");
    $hoja->setCellValue("H{$fila}", $i['modelo'] ?? "Sin modelo");
    $hoja->setCellValue("I{$fila}", $i['no_serie'] ?? "S/N");
    $hoja->setCellValue("J{$fila}", $i['color'] ?? "Multicolor");
    $hoja->setCellValue("K{$fila}", $i['material'] ?? "");
    $hoja->setCellValue("L{$fila}", $nombreMunicipio);
    $hoja->setCellValue("M{$fila}", $i['beneficiario'] ?? "");
    $hoja->setCellValue("N{$fila}", $i['costo_unitario']);
    $hoja->setCellValue("O{$fila}", $i['observaciones'] ?? "");

    $fila++;
}

$hoja->getStyle("A10:O{$fila}")
    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

foreach (range('A', 'O') as $col) {
    $hoja->getColumnDimension($col)->setAutoSize(true);
}

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=Formato_Municipio_{$municipioId}_{$anio}.xlsx");

$writer = IOFactory::createWriter($excel, 'Xlsx');
$writer->save("php://output");
exit;
