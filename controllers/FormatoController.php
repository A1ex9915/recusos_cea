<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class FormatoController
{
    /* ================= Helpers internos ================= */

    private function guard(): void
    {
        if (empty($_SESSION['user'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    private function render(string $vista, array $vars = []): void
    {
        $this->guard();

        extract($vars);

        $_SESSION['vista'] = "formatos/{$vista}.php";

        require dirname(__DIR__) . '/views/dashboard.php';
    }

    /* ================= Acciones públicas ================= */

    /** Listado de formatos + datos para reportes */
    public function index(): void
    {
        $formatos   = Formato::all();
        $municipios = Municipio::listar();
        $organismos = Organismo::listar();

        // Obtener datos para las gráficas
        $pdo = DB::conn();
        
        // Inventario por Categoría
        $stmt = $pdo->query("
            SELECT COALESCE(c.nombre, 'Sin categoría') AS label, COUNT(r.id) AS total
            FROM recursos r
            LEFT JOIN categorias c ON c.id = r.categoria_id
            GROUP BY c.nombre
            ORDER BY total DESC
        ");
        $inventarioCategoria = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Inventario por Estado del Bien
        $stmt = $pdo->query("
            SELECT COALESCE(estado_bien, 'Sin estado') AS label, COUNT(*) AS total
            FROM recursos
            GROUP BY estado_bien
            ORDER BY total DESC
        ");
        $inventarioEstado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Inventario por Municipio
        $stmt = $pdo->query("
            SELECT COALESCE(m.nombre, 'Sin municipio asignado') AS label, COUNT(r.id) AS total
            FROM recursos r
            LEFT JOIN municipios m ON m.id = r.municipio_id
            GROUP BY m.nombre
            ORDER BY total DESC
        ");
        $inventarioMunicipio = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Fichas ECA por Municipio
        $stmt = $pdo->query("
            SELECT COALESCE(m.nombre, 'Sin municipio') AS label, COUNT(e.id) AS total
            FROM eca_fichas e
            LEFT JOIN municipios m ON m.id = e.municipio_id
            GROUP BY m.nombre
            ORDER BY total DESC
        ");
        $fichasECAMunicipio = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->render('index', compact(
            'formatos', 
            'municipios', 
            'organismos',
            'inventarioCategoria',
            'inventarioEstado',
            'inventarioMunicipio',
            'fichasECAMunicipio'
        ));
    }

    /** Formulario para crear un nuevo formato */
    public function nuevo(): void
    {
        $formato = [
            'id'              => null,
            'nombre'          => '',
            'version'         => '',
            'activo'          => 1,
            'definicion_json' => '{}',
        ];

        $this->render('nuevo', compact('formato'));
    }

    /** Captura del formato */
    public function captura(): void
    {
        $id      = (int)($_GET['id'] ?? 0);
        $formato = Formato::find($id);

        if (!$formato) {
            http_response_code(404);
            exit('Formato no encontrado');
        }

        $mapa = json_decode($formato['definicion_json'] ?? '{}', true) ?? [];

        $this->render('captura', compact('formato', 'mapa'));
    }

    /** Guarda la captura manual */
    public function guardarCaptura(): void
    {
        $this->guard();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=formatos&action=index');
            exit;
        }

        $formato_id   = (int)($_POST['formato_id']   ?? 0);
        $organismo_id = (int)($_POST['organismo_id'] ?? 0);
        $municipio_id = (int)($_POST['municipio_id'] ?? 0);
        $campos       = $_POST['campos']            ?? [];
        $user_id      = (int)($_SESSION['user']['id'] ?? 0);

        FormatoModel::guardarCaptura(
            $formato_id,
            $organismo_id,
            $municipio_id,
            $campos,
            $user_id
        );

        $_SESSION['flash'] = 'Captura guardada correctamente.';
        header('Location: index.php?controller=formatos&action=captura&id=' . $formato_id);
        exit;
    }
public function capturaECA(): void
{
    $municipios = Municipio::listar();
    $organismos = Organismo::listar();
    $recursos   = Inventario::listarRecursos(); // 🔥 ESTA LÍNEA NUEVA

    $_SESSION['vista'] = "formatos/captura_eca.php";
    $viewData = compact('municipios','organismos','recursos');

    require dirname(__DIR__) . "/views/dashboard.php";
}

public function guardarCapturaECA(): void
{
    $this->guard();
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?controller=formatos&action=capturaECA");
        exit;
    }

    require_once dirname(__DIR__) . "/models/EcaFicha.php";

    $data = $_POST;
    $data['user_id'] = $_SESSION['user']['id'];

    $id = EcaFicha::crear($data);

    $_SESSION['flash'] = "Ficha Técnica del ECA guardada correctamente.";
    header("Location: index.php?controller=formatos&action=capturaECA&id=" . $id);
    exit;
}
   public function estadisticas()
{
    $this->guard();

    require_once dirname(__DIR__) . "/models/Inventario.php";
    require_once dirname(__DIR__) . "/models/EcaFicha.php";

    $inventarioCategoria = Inventario::conteoPorCategoria();
    $inventarioEstado    = Inventario::conteoPorEstado();
    $inventarioMunicipio = Inventario::conteoPorMunicipio();
    $fichasECAMunicipio  = EcaFicha::conteoPorMunicipio();

    $_SESSION['vista'] = "formatos/index.php";

    $inventarioCategoria ??= [];
    $inventarioEstado ??= [];
    $inventarioMunicipio ??= [];
    $fichasECAMunicipio ??= [];

    require dirname(__DIR__) . "/views/dashboard.php";
}

/* ==========================================================
   CONSULTA DE FICHAS ECA (INTERACTIVO)
   ========================================================== */
public function consultaECA(): void
{
    $this->guard();

    require_once dirname(__DIR__) . "/models/Municipio.php";
    require_once dirname(__DIR__) . "/models/EcaFicha.php";

    $municipios = Municipio::listar();

    $municipio_id = $_GET['municipio_id'] ?? null;

    // 🔥 SI NO SE SELECCIONA MUNICIPIO → TRAE TODAS LAS FICHAS
    if (empty($municipio_id)) {
        $fichas = EcaFicha::listarTodas();
    } else {
        $fichas = EcaFicha::listarPorMunicipio($municipio_id);
    }

    $_SESSION['vista'] = "formatos/eca_consulta.php";

    $viewData = compact(
        "municipios",
        "fichas",
        "municipio_id"
    );

    require dirname(__DIR__) . "/views/dashboard.php";
}
/** ==========================================================
 *  VER FICHA TÉCNICA DEL ECA (PREVISUALIZACIÓN)
 * ========================================================== */
public function verECA(): void
{
    $this->guard();

    require_once dirname(__DIR__) . "/models/EcaFicha.php";

    $id = (int)($_GET['id'] ?? 0);

    if ($id <= 0) {
        exit("ID inválido");
    }

    $ficha = EcaFicha::buscar($id);

    if (!$ficha) {
        exit("Ficha no encontrada");
    }

    // Para mostrar la vista
    $_SESSION['vista'] = "formatos/ver_eca.php";

    $viewData = compact("ficha");

    require dirname(__DIR__) . "/views/dashboard.php";
}
/** ==========================================================
 *  GENERAR PDF DE LA FICHA ECA
 * ========================================================== */
public function generarPDFECA(): void
{
    $this->guard();

    require_once dirname(__DIR__) . "/models/EcaFicha.php";
    require_once dirname(__DIR__) . "/controllers/export/pdf_eca.php"; // archivo que vas a crear

    $id = (int)($_GET['id'] ?? 0);

    if ($id <= 0) {
        exit("ID inválido");
    }

    $ficha = EcaFicha::buscar($id);

    if (!$ficha) {
        exit("Ficha no encontrada");
    }

    generarPDF_ECA($ficha); // Función en pdf_eca.php
    exit;
}



public function dashboard() {
    $this->guard();

    require_once dirname(__DIR__) . "/models/Inventario.php";
    require_once dirname(__DIR__) . "/models/EcaFicha.php";

    $catData   = Inventario::conteoPorCategoria();
    $estData   = Inventario::conteoPorEstado();
    $ubiData   = Inventario::conteoPorUbicacion();
    $ecaData   = EcaFicha::conteoPorMunicipio();

    $_SESSION['vista'] = "formatos/dashboard.php";

    $viewData = compact("catData", "estData", "ubiData", "ecaData");

    require dirname(__DIR__) . "/views/dashboard.php";
}



    /* ==========================================================
       🔥 NUEVO: Generar PDF de reportes (municipio / anual)
       ========================================================== */

    public function generarPDF()
    {
        $tipo         = $_GET['tipo']         ?? '';
        $anio         = $_GET['anio']         ?? '';
        $municipio_id = $_GET['municipio_id'] ?? '';
        $organismo_id = $_GET['organismo_id'] ?? '';

        if ($tipo === 'municipio') {
            require __DIR__ . "/export/InventarioFormatoMunicipioPDF.php";
            exit;
        }

        if ($tipo === 'anual') {
            require __DIR__ . "/export/InventarioFormatoAnualPDF.php";
            exit;
        }

        echo "Tipo de reporte inválido";
        exit;
    }
    public function generarReporte(): void
{
    $this->guard();

    // Cargar listas para los selects
    $municipios = Municipio::listar();
    $organismos = Organismo::listar();

    $this->render('reporte', compact('municipios', 'organismos'));
}



    /* ==========================================================
       Exportar formato a Excel según definiciones JSON
       ========================================================== */

    public function exportar(): void
    {
        $this->guard();

        $formato_id = (int)($_GET['id'] ?? 0);
        if (!$formato_id) exit('ID de formato inválido');

        $formato = Formato::find($formato_id);
        if (!$formato) exit('Formato no encontrado');

        $mapa  = json_decode($formato['definicion_json'] ?? '[]', true) ?: [];
        $datos = FormatoModel::datosParaExportar($formato_id);

        $spread = new Spreadsheet();
        $sheet  = $spread->getActiveSheet();

        // Encabezados
        $col = 1;
        foreach (array_keys($mapa) as $encabezado) {
            $cell = Coordinate::stringFromColumnIndex($col) . '1';
            $sheet->setCellValue($cell, $encabezado);
            $col++;
        }

        // Filas
        $rowNum = 2;
        foreach ($datos as $row) {
            $col = 1;
            foreach ($mapa as $encabezado => $campoBD) {
                $cell = Coordinate::stringFromColumnIndex($col) . $rowNum;
                $sheet->setCellValue($cell, $row[$campoBD] ?? '');
                $col++;
            }
            $rowNum++;
        }

        // Descargar archivo
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="export_' . $formato['nombre'] . '.xlsx"');

        IOFactory::createWriter($spread, 'Xlsx')->save('php://output');
        exit;
    }
}