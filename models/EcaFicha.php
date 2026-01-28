<?php

require_once dirname(__DIR__) . "/config/database.php";

class EcaFicha
{
    private static function pdo(): PDO 
    {
        return DB::conn();
    }

    /* ==========================================================
       CREAR FICHA — Inserta dinámicamente todas las columnas
    ========================================================== */
    public static function crear(array $p): int 
    {
        $pdo = self::pdo();

        // Obtener columnas reales
        $cols = $pdo->query("SHOW COLUMNS FROM eca_fichas")->fetchAll(PDO::FETCH_COLUMN);

        $insertCols = [];
        $insertVals = [];
        $params     = [];

        foreach ($cols as $col) {

            if ($col === 'id') continue;
            if ($col === 'fecha_captura') continue;

            $insertCols[] = $col;
            $insertVals[] = ":" . $col;
            $params[":" . $col] = $p[$col] ?? null;
        }

        $sql = "INSERT INTO eca_fichas (" . implode(",", $insertCols) . ")
                VALUES (" . implode(",", $insertVals) . ")";

        $st = $pdo->prepare($sql);
        $st->execute($params);

        return (int)$pdo->lastInsertId();
    }

    /* ==========================================================
       OBTENER FICHA POR ID
    ========================================================== */
    public static function obtener(int $id): ?array
    {
        $pdo = self::pdo();

        $st = $pdo->prepare("SELECT 
                                f.*,
                                m.nombre AS municipio,
                                o.nombre AS organismo
                             FROM eca_fichas f
                             LEFT JOIN municipios m ON m.id = f.municipio_id
                             LEFT JOIN organismos o ON o.id = f.organismo_id
                             WHERE f.id = ?
                             LIMIT 1");
        $st->execute([$id]);

        $row = $st->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }

    /* ==========================================================
       ALIAS: buscar() → usar obtener()
    ========================================================== */
    public static function buscar(int $id): ?array
    {
        return self::obtener($id);
    }

    /* ==========================================================
       LISTAR POR MUNICIPIO
    ========================================================== */
    public static function listarPorMunicipio(int $municipio_id): array
    {
        $pdo = DB::conn();

        $sql = "SELECT f.*, m.nombre AS municipio, o.nombre AS organismo
                FROM eca_fichas f
                LEFT JOIN municipios m ON m.id = f.municipio_id
                LEFT JOIN organismos o ON o.id = f.organismo_id
                WHERE f.municipio_id = ?
                ORDER BY f.id DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$municipio_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function conteoPorMunicipio() {
    $pdo = DB::conn();

    $sql = "SELECT 
                m.nombre AS label,
                COUNT(*) AS total
            FROM eca_fichas f
            LEFT JOIN municipios m ON m.id = f.municipio_id
            GROUP BY m.nombre
            ORDER BY m.nombre";

    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}


    /* ==========================================================
       LISTAR TODAS LAS FICHAS
    ========================================================== */
    public static function listarTodas(): array
    {
        $pdo = DB::conn();

        $sql = "SELECT 
                    e.*,
                    m.nombre AS municipio,
                    o.nombre AS organismo
                FROM eca_fichas e
                LEFT JOIN municipios m ON m.id = e.municipio_id
                LEFT JOIN organismos o ON o.id = e.organismo_id
                ORDER BY m.nombre ASC, e.clave_eca ASC";

        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
