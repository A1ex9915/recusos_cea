<?php

class Formato
{
    private static function pdo(): PDO
    {
        return DB::conn();
    }

    public static function all(): array
    {
        $st = self::pdo()->query("
            SELECT id, nombre, version, activo, definicion_json
            FROM formatos
            ORDER BY nombre
        ");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $st = self::pdo()->prepare("
            SELECT id, nombre, version, activo, definicion_json
            FROM formatos
            WHERE id = ?
        ");
        $st->execute([$id]);
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}
