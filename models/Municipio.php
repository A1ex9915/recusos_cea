<?php

class Municipio
{
    private static function pdo()
    {
        return DB::conn();
    }

    public static function listar(): array
    {
        $pdo = self::pdo();
        $sql = "SELECT id, nombre FROM municipios ORDER BY nombre ASC";
        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function obtener(int $id): ?array
{
    $pdo = self::pdo();
    $st = $pdo->prepare("SELECT * FROM municipios WHERE id = ?");
    $st->execute([$id]);
    $row = $st->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}

}
