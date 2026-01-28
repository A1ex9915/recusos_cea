<?php

class Catalogo
{
    private static function pdo(): PDO
    {
        return DB::conn();
    }

    public static function categorias(): array
    {
        return self::pdo()
            ->query("SELECT id, nombre FROM categorias ORDER BY nombre")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function unidades(): array
    {
        return self::pdo()
            ->query("SELECT id, nombre FROM unidades ORDER BY nombre")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

   public static function organismos(): array
{
    return self::pdo()
        ->query("SELECT id, nombre, municipio_id FROM organismos ORDER BY nombre")
        ->fetchAll(PDO::FETCH_ASSOC);
}


    public static function municipios(): array
    {
        return self::pdo()
            ->query("SELECT id, nombre FROM municipios ORDER BY nombre")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function proveedores(): array
    {
        return self::pdo()
            ->query("SELECT id, nombre FROM proveedores ORDER BY nombre")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ubicaciones(): array
    {
        return self::pdo()
            ->query("SELECT id, nombre FROM ubicaciones ORDER BY nombre")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Resuelve el id por nombre en una tabla de catálogo.
     * Si no existe, lo inserta y devuelve el nuevo id.
     */
    public static function idPorNombre(string $tabla, string $nombre): int
    {
        $pdo = self::pdo();

        // Buscar
        $st = $pdo->prepare("SELECT id FROM {$tabla} WHERE nombre = ?");
        $st->execute([$nombre]);
        $id = $st->fetchColumn();

        if ($id) {
            return (int) $id;
        }

        // Crear si no existe
        $ins = $pdo->prepare("INSERT INTO {$tabla}(nombre) VALUES(?)");
        $ins->execute([$nombre]);

        return (int) $pdo->lastInsertId();
    }
 

    public static function organismosPorMunicipio($municipio_id)
{
    $pdo = DB::conn();
    $stmt = $pdo->prepare("SELECT * FROM organismos WHERE municipio_id = ?");
    $stmt->execute([$municipio_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}

