<?php

class FormatoModel
{
    private static function pdo(): PDO
    {
        return DB::conn();
    }

    /** Guarda una captura manual de un formato */
    public static function guardarCaptura(
        int $formato_id,
        int $organismo_id,
        int $municipio_id,
        array $campos,
        int $user_id
    ): void {
        $sql = "
            INSERT INTO capturas_formato
                (formato_id, organismo_id, municipio_id, campos, creado_por)
            VALUES (?,?,?,?,?)
        ";

        $st = self::pdo()->prepare($sql);
        $st->execute([
            $formato_id,
            $organismo_id,
            $municipio_id,
            json_encode($campos, JSON_UNESCAPED_UNICODE),
            $user_id,
        ]);
    }

    /** Inserta registros provenientes de un Excel */
    public static function insertarDesdeExcel(
        int $formato_id,
        array $data,
        int $user_id
    ): void {
        $sql = "
            INSERT INTO capturas_formato
                (formato_id, campos, creado_por)
            VALUES (?,?,?)
        ";

        $pdo = self::pdo();
        $st  = $pdo->prepare($sql);

        foreach ($data as $row) {
            $st->execute([
                $formato_id,
                json_encode($row, JSON_UNESCAPED_UNICODE),
                $user_id,
            ]);
        }
    }

    /** Datos para exportar según formato (ajusta a tu necesidad) */
    public static function datosParaExportar(int $formato_id): array
    {
        $pdo = self::pdo();
        $st  = $pdo->prepare("
            SELECT id, campos, creado_por, creado_en
            FROM capturas_formato
            WHERE formato_id = ?
            ORDER BY creado_en DESC
        ");
        $st->execute([$formato_id]);
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
