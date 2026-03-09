<?php

class Bitacora
{
    public static function registrar(string $accion, string $modulo, string $detalle = '', array $metadata = []): void
    {
        try {
            $userId = null;
            if (!empty($_SESSION['user']['id'])) {
                $userId = (int)$_SESSION['user']['id'];
            }

            $ip = $_SERVER['REMOTE_ADDR'] ?? null;
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
            $metadataJson = !empty($metadata)
                ? json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                : null;

            $sql = "
                INSERT INTO bitacora_acciones
                    (user_id, accion, modulo, detalle, ip, user_agent, metadata_json, creado_en)
                VALUES
                    (?, ?, ?, ?, ?, ?, ?, NOW())
            ";

            $stmt = DB::conn()->prepare($sql);
            $stmt->execute([
                $userId,
                $accion,
                $modulo,
                $detalle,
                $ip,
                $userAgent,
                $metadataJson,
            ]);
        } catch (Throwable $e) {
        }
    }
}
