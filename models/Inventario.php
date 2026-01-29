<?php

class Inventario
{
    private static function pdo(): PDO
    {
        return DB::conn();
    }

    /** ===========================
     *  LISTAR (BÚSQUEDA NORMAL)
     *  =========================== */
    public static function listar(string $q = ''): array
    {
        $pdo = self::pdo();

        if ($q !== '') {
            $st = $pdo->prepare("
                SELECT r.*, c.nombre AS categoria, u.nombre AS unidad,
                       o.nombre AS organismo, m.nombre AS municipio
                FROM recursos r
                LEFT JOIN categorias  c ON c.id = r.categoria_id
                LEFT JOIN unidades    u ON u.id = r.unidad_id
                LEFT JOIN organismos  o ON o.id = r.organismo_id
                LEFT JOIN municipios  m ON m.id = r.municipio_id
                WHERE r.nombre LIKE :q OR r.clave LIKE :q
                ORDER BY r.nombre
            ");
            $st->execute([':q' => "%$q%"]);
            return $st->fetchAll(PDO::FETCH_ASSOC);
        }

        return $pdo->query("
            SELECT r.*, c.nombre AS categoria, u.nombre AS unidad,
                   o.nombre AS organismo, m.nombre AS municipio
            FROM recursos r
            LEFT JOIN categorias  c ON c.id = r.categoria_id
            LEFT JOIN unidades    u ON u.id = r.unidad_id
            LEFT JOIN organismos  o ON o.id = r.organismo_id
            LEFT JOIN municipios  m ON m.id = r.municipio_id
            ORDER BY r.nombre
        ")->fetchAll(PDO::FETCH_ASSOC);
    }



    /** ===========================
     *  BUSCAR RECURSO
     *  =========================== */
    public static function buscar(int $id): ?array
    {
        $pdo = self::pdo();
        $st  = $pdo->prepare("SELECT * FROM recursos WHERE id = ?");
        $st->execute([$id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }



    /** ===========================
     *  CREAR RECURSO
     *  =========================== */
  public static function crear(array $p): void
{
    $pdo = self::pdo();
    $p = array_map(fn($v) => is_string($v) ? trim($v) : $v, $p);
    $fechaAlta = date('Y-m-d');

   $sql = "
    INSERT INTO recursos (
        clave, nombre, descripcion,
        categoria_id, estado_bien, unidad_id,
        tipo_fuente, costo_unitario,
        cantidad_total, cantidad_disponible,
        organismo_id, fecha_alta,
        marca, modelo, numero_serie, color,
        material
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
";

$args = [
    $p['clave'] ?? null,
    $p['nombre'] ?? null,
    $p['descripcion'] ?? null,

    !empty($p['categoria_id']) ? (int)$p['categoria_id'] : null,
    $p['estado_bien'] ?? null,
    !empty($p['unidad_id']) ? (int)$p['unidad_id'] : null,

    $p['tipo_fuente'] ?? null,
    (float)($p['costo_unitario'] ?? 0),

    (int)($p['cantidad_total'] ?? 0),
    (int)($p['cantidad_disponible'] ?? ($p['cantidad_total'] ?? 0)),

    !empty($p['organismo_id']) ? (int)$p['organismo_id'] : null,
    $fechaAlta,

    $p['marca'] ?? null,
    $p['modelo'] ?? null,
    !empty($p['numero_serie']) ? (int)$p['numero_serie'] : 0,
    $p['color'] ?? null,
    $p['material'] ?? null
];


    $pdo->prepare($sql)->execute($args);
}




    /** ===========================
     *  ACTUALIZAR RECURSO
     *  =========================== */
  public static function actualizar(int $id, array $p): void
{
    $pdo = self::pdo();
    $p = array_map(fn($v) => is_string($v) ? trim($v) : $v, $p);

    $sql = "
    UPDATE recursos SET
        clave=?, nombre=?, descripcion=?,
        categoria_id=?, estado_bien=?, unidad_id=?,
        tipo_fuente=?, costo_unitario=?,
        cantidad_total=?, cantidad_disponible=?,
        organismo_id=?,
        marca=?, modelo=?, numero_serie=?, color=?,
        material=?
    WHERE id=?
";

$args = [
    $p['clave'] ?? null,
    $p['nombre'] ?? null,
    $p['descripcion'] ?? null,

    !empty($p['categoria_id']) ? (int)$p['categoria_id'] : null,
    $p['estado_bien'] ?? null,
    !empty($p['unidad_id']) ? (int)$p['unidad_id'] : null,

    $p['tipo_fuente'] ?? null,
    (float)($p['costo_unitario'] ?? 0),

    (int)($p['cantidad_total'] ?? 0),
    (int)($p['cantidad_disponible'] ?? ($p['cantidad_total'] ?? 0)),

    !empty($p['organismo_id']) ? (int)$p['organismo_id'] : null,

    $p['marca'] ?? null,
    $p['modelo'] ?? null,
    !empty($p['numero_serie']) ? (int)$p['numero_serie'] : 0,
    $p['color'] ?? null,
    $p['material'] ?? null,

    $id
];


    $pdo->prepare($sql)->execute($args);
}




    /** ===========================
     *  REPORTE (para Excel y vista)
     *  =========================== */
  public static function listarReporte(array $filtros = []): array
{
    $pdo = self::pdo();

    $sql = "
        SELECT
            r.id,
            r.clave AS no_inventario,
            r.nombre AS descripcion,
            r.descripcion AS descripcion_larga,
            c.nombre AS categoria,
            u.nombre AS ubicacion,
            r.estado_bien,
            r.fecha_alta,
            r.costo_unitario,
            r.cantidad_total AS cantidad,
            r.accion,
            r.anio_fortalecimiento AS anio,
            r.marca,
            r.modelo,
            r.numero_serie AS no_serie,
            r.color,
            r.material,
            COALESCE(r.beneficiario, '') AS beneficiario,
            COALESCE(m.nombre, '') AS municipio,
            COALESCE(o.nombre, '') AS organismo

        FROM recursos r
        LEFT JOIN categorias  c ON c.id = r.categoria_id
        LEFT JOIN ubicaciones u ON u.id = r.ubicacion_id
        LEFT JOIN municipios m ON m.id = r.municipio_id
        LEFT JOIN organismos o ON o.id = r.organismo_id
        WHERE 1 = 1
    ";

    $params = [];

    if (!empty($filtros['q'])) {
        $sql .= " AND (r.clave LIKE :q OR r.nombre LIKE :q)";
        $params[':q'] = "%{$filtros['q']}%";
    }

    if (!empty($filtros['categoria'])) {
        $sql .= " AND c.nombre = :cat";
        $params[':cat'] = $filtros['categoria'];
    }

    if (!empty($filtros['estado_bien'])) {
        $sql .= " AND r.estado_bien = :est";
        $params[':est'] = $filtros['estado_bien'];
    }

    if (!empty($filtros['anio'])) {
        $sql .= " AND (r.anio_fortalecimiento = :anio OR YEAR(r.fecha_alta) = :anio2)";
        $params[':anio'] = (int)$filtros['anio'];
        $params[':anio2'] = (int)$filtros['anio'];
    }

    if (!empty($filtros['municipio_id'])) {
        $sql .= " AND (r.municipio_id = :municipio_id OR o.municipio_id = :municipio_id2)";
        $params[':municipio_id'] = (int)$filtros['municipio_id'];
        $params[':municipio_id2'] = (int)$filtros['municipio_id'];
    }

    $sql .= " ORDER BY municipio ASC, r.fecha_alta DESC, r.clave ASC";

    $st = $pdo->prepare($sql);
    $st->execute($params);

    return $st->fetchAll(PDO::FETCH_ASSOC);
}

/* ==========================================================
 *  OBTENER NOMBRE DE MUNICIPIO POR ID
 * ========================================================== */
public static function obtenerNombreMunicipio(int $id): string
{
    $pdo = self::pdo();
    $st = $pdo->prepare("SELECT nombre FROM municipios WHERE id = ?");
    $st->execute([$id]);
    $row = $st->fetch(PDO::FETCH_ASSOC);

    return $row['nombre'] ?? '—';
}

/* ==========================================================
 *  OBTENER NOMBRE DE ORGANISMO OPERADOR POR ID
 * ========================================================== */
public static function obtenerNombreOrganismo(?int $id): string
{
    if ($id === null) {
        return '—';
    }

    $pdo = self::pdo();
    $st  = $pdo->prepare("SELECT nombre FROM organismos WHERE id = ?");
    $st->execute([$id]);
    $row = $st->fetch(PDO::FETCH_ASSOC);

    return $row['nombre'] ?? '—';
}
// CONTEO POR MUNICIPIO (para "Reportes por municipio")
public static function conteoPorMunicipio(): array {
    $pdo = DB::conn();
    $sql = "
        SELECT 
            m.nombre AS label,
            COUNT(*) AS total
        FROM recursos r
        LEFT JOIN municipios m ON m.id = r.municipio_id
        GROUP BY m.nombre
        ORDER BY m.nombre
    ";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// CONTEO POR CATEGORÍA (para "Inventario por categoría")
public static function conteoPorCategoria(): array {
    $pdo = DB::conn();
    $sql = "
        SELECT c.nombre AS label, COUNT(*) AS total
        FROM recursos r
        LEFT JOIN categorias c ON c.id = r.categoria_id
        GROUP BY c.nombre
        ORDER BY c.nombre
    ";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// REPORTES MENSUALES (para "Reportes mensuales")
public static function conteoMensual(): array {
    $pdo = DB::conn();
    $sql = "
        SELECT MONTH(r.fecha_alta) AS mes, COUNT(*) AS total
        FROM recursos r
        GROUP BY MONTH(r.fecha_alta)
        ORDER BY mes
    ";
    $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    $meses = [
        1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',
        5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',
        9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'
    ];

    return array_map(fn($r) => [
        'label' => $meses[$r['mes']] ?? $r['mes'],
        'total' => $r['total']
    ], $rows);
}

// MATERIALES MÁS USADOS (para "Materiales más usados")
public static function materialesMasUsados(): array {
    $pdo = DB::conn();
    $sql = "
        SELECT material AS label, COUNT(*) AS total
        FROM recursos
        WHERE material IS NOT NULL AND material <> ''
        GROUP BY material
        ORDER BY total DESC
        LIMIT 10
    ";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
// CONTEO POR ESTADO DEL BIEN (para gráficos)
public static function conteoPorEstado(): array {
    $pdo = DB::conn();
    $sql = "
        SELECT r.estado_bien AS label, COUNT(*) AS total
        FROM recursos r
        WHERE r.estado_bien IS NOT NULL AND r.estado_bien <> ''
        GROUP BY r.estado_bien
        ORDER BY r.estado_bien
    ";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
// CONTEO POR UBICACIÓN (para gráficos)
public static function conteoPorUbicacion(): array {
    $pdo = DB::conn();
    $sql = "
        SELECT u.nombre AS label, COUNT(*) AS total
        FROM recursos r
        LEFT JOIN ubicaciones u ON u.id = r.ubicacion_id
        WHERE r.ubicacion_id IS NOT NULL
        GROUP BY u.nombre
        ORDER BY u.nombre
    ";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}


public static function obtenerPorIds(array $ids): array
{
    if (empty($ids)) return [];

    $pdo = self::pdo();
    $in  = implode(',', array_fill(0, count($ids), '?'));

    $sql = "
        SELECT
            r.id,
            r.clave AS no_inventario,
            r.nombre AS descripcion,
            r.descripcion AS descripcion_larga,
            r.cantidad_total AS cantidad,
            c.nombre AS categoria,
            r.estado_bien,
            r.fecha_alta,
            r.costo_unitario,
            r.marca,
            r.modelo,
            r.numero_serie,
            r.color,
            u.nombre AS ubicacion,
            m.nombre AS municipio,
            o.nombre AS organismo,
            r.material,
            r.beneficiario,
            r.accion
        FROM recursos r
        LEFT JOIN categorias  c ON c.id = r.categoria_id
        LEFT JOIN ubicaciones u ON u.id = r.ubicacion_id
        LEFT JOIN municipios m ON m.id = r.municipio_id
        LEFT JOIN organismos o ON o.id = r.organismo_id
        WHERE r.id IN ($in)
    ";

    $st = $pdo->prepare($sql);
    $st->execute($ids);

    return $st->fetchAll(PDO::FETCH_ASSOC);
}

/* ==========================================================
 * OBTENER INVENTARIO POR MUNICIPIO (PARA EL PDF)
 * ========================================================== */

public static function obtenerPorMunicipio(int $municipio_id): array
{
    $pdo = self::pdo();

    $sql = "
        SELECT
            r.id,
            r.clave AS no_inventario,
            r.nombre AS descripcion,
            r.descripcion AS descripcion_larga,
            r.categoria_id,
            c.nombre AS categoria,
            r.cantidad_total AS cantidad,
            r.accion,
            r.concepto,
            r.anio_fortalecimiento AS anio,
            r.marca,
            r.modelo,
            r.numero_serie,
            r.color,
            r.material,
            r.beneficiario,
            m.nombre AS municipio,
            o.nombre AS organismo
        FROM recursos r
        LEFT JOIN categorias  c ON c.id = r.categoria_id
        LEFT JOIN municipios m ON m.id = r.municipio_id
        LEFT JOIN organismos o ON o.id = r.organismo_id
        WHERE r.municipio_id = :mun
        ORDER BY r.id ASC
    ";

    $st = $pdo->prepare($sql);
    $st->execute([':mun' => $municipio_id]);

    return $st->fetchAll(PDO::FETCH_ASSOC);
}




    /** ===========================
     *  ELIMINAR
     *  =========================== */
    public static function eliminar(int $id): void
    {
        self::pdo()->prepare("DELETE FROM recursos WHERE id = ?")->execute([$id]);
    }
    public static function listarPorMunicipio($municipio_id)
{
    $pdo = DB::conn();

    $sql = "SELECT r.*, 
                   c.nombre AS categoria,
                   m.nombre AS municipio,
                   o.nombre AS organismo
            FROM recursos r
            LEFT JOIN categorias c ON c.id = r.categoria_id
            LEFT JOIN municipios m ON m.id = r.municipio_id
            LEFT JOIN organismos o ON o.id = r.organismo_id
            WHERE r.municipio_id = :mun
            ORDER BY r.id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['mun' => $municipio_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public static function listarRecursos(): array {
    $pdo = DB::conn();

    $sql = "
        SELECT 
            r.*, 
            c.nombre AS categoria
        FROM recursos r
        LEFT JOIN categorias c ON c.id = r.categoria_id
        ORDER BY c.nombre ASC, r.nombre ASC
    ";

    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



}