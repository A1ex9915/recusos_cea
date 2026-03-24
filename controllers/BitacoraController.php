<?php

class BitacoraController
{
    /** Solo el usuario luis.roldangamero@gmail.com puede acceder */
    private const ALLOWED_EMAIL = 'luis.roldangamero@gmail.com';
    private const PER_PAGE      = 25;

    private function guard(): void
    {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URI . '/index.php?controller=auth&action=login');
            exit;
        }
        if (($_SESSION['user']['email'] ?? '') !== self::ALLOWED_EMAIL) {
            http_response_code(403);
            exit('No autorizado');
        }
    }

    private function render(string $vista, array $vars = []): void
    {
        extract($vars);
        $_SESSION['vista'] = $vista;
        require dirname(__DIR__) . '/views/dashboard.php';
    }

    public function index(): void
    {
        $this->guard();

        $pdo = DB::conn();

        /* ── Filtros ─────────────────────────────────────────── */
        $filtroModulo  = trim($_GET['modulo']       ?? '');
        $filtroAccion  = trim($_GET['accion']       ?? '');
        $filtroUsuario = trim($_GET['usuario_id']   ?? '');
        $filtroDesde   = trim($_GET['fecha_desde']  ?? '');
        $filtroHasta   = trim($_GET['fecha_hasta']  ?? '');
        $pagina        = max(1, (int)($_GET['pagina'] ?? 1));

        /* ── WHERE dinámico ──────────────────────────────────── */
        $where  = [];
        $params = [];

        if ($filtroModulo !== '') {
            $where[]  = 'b.modulo = ?';
            $params[] = $filtroModulo;
        }
        if ($filtroAccion !== '') {
            $where[]  = 'b.accion = ?';
            $params[] = $filtroAccion;
        }
        if ($filtroUsuario !== '') {
            $where[]  = 'b.user_id = ?';
            $params[] = (int)$filtroUsuario;
        }
        if ($filtroDesde !== '') {
            $where[]  = 'b.creado_en >= ?';
            $params[] = $filtroDesde . ' 00:00:00';
        }
        if ($filtroHasta !== '') {
            $where[]  = 'b.creado_en <= ?';
            $params[] = $filtroHasta . ' 23:59:59';
        }

        $sql_where = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        /* ── Total para paginación ───────────────────────────── */
        $stTotal = $pdo->prepare("SELECT COUNT(*) FROM bitacora_acciones b $sql_where");
        $stTotal->execute($params);
        $total   = (int)$stTotal->fetchColumn();
        $totalPaginas = max(1, (int)ceil($total / self::PER_PAGE));
        $pagina  = min($pagina, $totalPaginas);
        $offset  = ($pagina - 1) * self::PER_PAGE;

        /* ── Registros ───────────────────────────────────────── */
        $stRows = $pdo->prepare("
            SELECT
                b.id,
                b.accion,
                b.modulo,
                b.detalle,
                b.ip,
                b.metadata_json,
                b.creado_en,
                COALESCE(u.nombre, '(sistema)') AS usuario_nombre,
                COALESCE(u.email,  '')           AS usuario_email,
                b.user_id
            FROM bitacora_acciones b
            LEFT JOIN usuarios u ON u.id = b.user_id
            $sql_where
            ORDER BY b.creado_en DESC
            LIMIT " . self::PER_PAGE . " OFFSET $offset
        ");
        $stRows->execute($params);
        $registros = $stRows->fetchAll(PDO::FETCH_ASSOC);

        /* ── Catálogos para los selects de filtro ────────────── */
        $modulos  = $pdo->query("SELECT DISTINCT modulo FROM bitacora_acciones ORDER BY modulo")->fetchAll(PDO::FETCH_COLUMN);
        $acciones = $pdo->query("SELECT DISTINCT accion FROM bitacora_acciones ORDER BY accion")->fetchAll(PDO::FETCH_COLUMN);
        $usuarios = $pdo->query("
            SELECT DISTINCT u.id, u.nombre
            FROM usuarios u
            INNER JOIN bitacora_acciones b ON b.user_id = u.id
            ORDER BY u.nombre
        ")->fetchAll(PDO::FETCH_ASSOC);

        /* ── Tarjetas de resumen ─────────────────────────────── */
        $stResumen = $pdo->query("
            SELECT
                COUNT(*)                                          AS total,
                SUM(accion = 'login')                             AS logins,
                SUM(accion = 'login_fallido')                     AS fallidos,
                SUM(accion IN ('crear','actualizar','eliminar'))  AS cambios
            FROM bitacora_acciones
        ")->fetch(PDO::FETCH_ASSOC);

        $this->render('bitacora/index.php', compact(
            'registros', 'total', 'totalPaginas', 'pagina',
            'modulos', 'acciones', 'usuarios', 'stResumen',
            'filtroModulo', 'filtroAccion', 'filtroUsuario',
            'filtroDesde', 'filtroHasta'
        ));
    }
}
