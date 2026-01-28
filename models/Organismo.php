<?php

class Organismo
{
    private static function pdo()
    {
        return DB::conn();
    }

    public static function obtener(int $id): ?array
    {
        $pdo = self::pdo();
        $st = $pdo->prepare("SELECT * FROM organismos WHERE id = ?");
        $st->execute([$id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function listar(): array
    {
        $pdo = self::pdo();
        return $pdo->query("SELECT id, nombre FROM organismos ORDER BY nombre ASC")
                   ->fetchAll(PDO::FETCH_ASSOC);
    }
}
