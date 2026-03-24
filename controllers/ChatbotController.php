<?php

class ChatbotController
{
    /**
     * POST /index.php?controller=chatbot&action=rating
     * Body JSON: { intent: string, vote: 0|1, _csrf_token: string }
     * Guarda la calificación en scripts/chatbot_ratings.json
     */
    public function rating(): string
    {
       
        if (empty($_SESSION['user'])) {
            http_response_code(401);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'No autenticado']);
            exit;
        }

      
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
            exit;
        }

        $raw  = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (!is_array($data)) {
            http_response_code(400);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'JSON inválido']);
            exit;
        }

        // Validar CSRF
        $token = (string)($data['_csrf_token'] ?? '');
        if (!hash_equals((string)($_SESSION['_csrf_token'] ?? ''), $token)) {
            http_response_code(403);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'CSRF inválido']);
            exit;
        }

        // Sanitizar campos
        $intent = preg_replace('/[^a-z_]/', '', strtolower((string)($data['intent'] ?? '')));
        $vote   = (int)(bool)($data['vote'] ?? 0);

        if ($intent === '') {
            http_response_code(400);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'intent requerido']);
            exit;
        }

        $entry = [
            'intent'     => $intent,
            'vote'       => $vote,
            'usuario_id' => (int)($_SESSION['user']['id'] ?? 0),
            'ts'         => date('c'),
        ];

        $logFile = __DIR__ . '/../scripts/chatbot_ratings.json';
        $entries = [];

        if (is_file($logFile)) {
            $decoded = json_decode(file_get_contents($logFile), true);
            if (is_array($decoded)) {
                $entries = $decoded;
            }
        }

        $entries[] = $entry;

        // Limitar a los últimos 5 000 registros para que el archivo no crezca sin límite
        if (count($entries) > 5000) {
            $entries = array_slice($entries, -5000);
        }

        file_put_contents(
            $logFile,
            json_encode($entries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        );

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => true]);
        exit;
    }

    /**
     * GET /index.php?controller=chatbot&action=inventarioEstados
     * Devuelve conteos agrupados por estado_bien.
     */
    public function inventarioEstados(): void
    {
        if (empty($_SESSION['user'])) {
            http_response_code(401);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'No autenticado']);
            exit;
        }

        $pdo = DB::conn();

        $rows = $pdo->query("
            SELECT estado_bien,
                   COUNT(*)          AS registros,
                   SUM(cantidad_total) AS cantidad
            FROM recursos
            WHERE estado_bien IS NOT NULL
            GROUP BY estado_bien
            ORDER BY FIELD(estado_bien, 'bueno', 'regular', 'malo', 'baja')
        ")->fetchAll(PDO::FETCH_ASSOC);

        $estados = [];
        foreach ($rows as $r) {
            $estados[$r['estado_bien']] = [
                'registros' => (int) $r['registros'],
                'cantidad'  => (int) $r['cantidad'],
            ];
        }

        $total = (int) $pdo->query("SELECT COUNT(*) FROM recursos")->fetchColumn();

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => true, 'estados' => $estados, 'total' => $total]);
        exit;
    }

    /**
     * GET /index.php?controller=chatbot&action=buscarArticulo&q=XXXX
     * Busca por clave exacta; si no halla, por nombre o clave parcial (máx. 5 resultados).
     */
    public function buscarArticulo(): void
    {
        if (empty($_SESSION['user'])) {
            http_response_code(401);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'No autenticado']);
            exit;
        }

        $q = trim((string) ($_GET['q'] ?? ''));
        if ($q === '' || strlen($q) > 100) {
            http_response_code(400);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'Parámetro q requerido (máx. 100 caracteres)']);
            exit;
        }

        $pdo = DB::conn();
        $cols = "r.id, r.clave, r.nombre, r.descripcion, r.estado_bien,
                 r.cantidad_total, r.cantidad_disponible, r.marca, r.modelo,
                 r.costo_unitario, r.fecha_alta,
                 c.nombre AS categoria,
                 o.nombre AS organismo,
                 m.nombre AS municipio";
        $joins = "LEFT JOIN categorias c ON c.id = r.categoria_id
                  LEFT JOIN organismos o ON o.id = r.organismo_id
                  LEFT JOIN municipios m ON m.id = r.municipio_id";

        // 1) Coincidencia exacta de clave
        $st = $pdo->prepare("SELECT $cols FROM recursos r $joins WHERE r.clave = ? LIMIT 5");
        $st->execute([$q]);
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);

        // 2) Si no encontró nada, búsqueda parcial por nombre o clave
        if (empty($rows)) {
            $like = '%' . $q . '%';
            $st   = $pdo->prepare("SELECT $cols FROM recursos r $joins
                                   WHERE r.nombre LIKE ? OR r.clave LIKE ?
                                   ORDER BY r.nombre LIMIT 5");
            $st->execute([$like, $like]);
            $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => true, 'articulos' => $rows, 'q' => $q]);
        exit;
    }
}
