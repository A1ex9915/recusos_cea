<?php
class Reporte {
  private static function pdo(){ return DB::conn(); }


  public static function inventarioPorCategoria(): array {
    $sql = "SELECT COALESCE(c.nombre,'Sin categoría') as categoria, SUM(r.cantidad_disponible) as total
            FROM recursos r LEFT JOIN categorias c ON c.id=r.categoria_id
            GROUP BY c.nombre ORDER BY total DESC";
    return self::pdo()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function inventarioPorFuente(): array {
    $sql = "SELECT fuente, SUM(cantidad_disponible) as total
            FROM recursos GROUP BY fuente ORDER BY total DESC";
    return self::pdo()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function inventarioPorMunicipio(): array {
    $sql = "SELECT COALESCE(m.nombre,'Sin municipio') as municipio, SUM(r.cantidad_disponible) as total
            FROM recursos r LEFT JOIN municipios m ON m.id=r.municipio_id
            GROUP BY m.nombre ORDER BY total DESC";
    return self::pdo()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function serieMensualMovimientos(): array {
    $sql = "SELECT DATE_FORMAT(fecha,'%Y-%m') as mes,
                   SUM(CASE WHEN tipo='ENTRADA' THEN cantidad ELSE 0 END) as entradas,
                   SUM(CASE WHEN tipo='SALIDA'  THEN cantidad ELSE 0 END) as salidas
            FROM movimientos
            GROUP BY DATE_FORMAT(fecha,'%Y-%m')
            ORDER BY mes";
    return self::pdo()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  }
}
