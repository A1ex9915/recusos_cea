<?php

class ManualController
{
    private function findManualPath(): ?string
    {
        $preferred = [
            dirname(__DIR__) . '/public/manuales/MongoDB4.pdf',
            dirname(__DIR__) . '/MongoDB4.pdf',
            dirname(__DIR__) . '/public/manuales/manual_tecnico_ceaa.pdf',
            dirname(__DIR__) . '/public/manuales/MongoDB.pdf',
            dirname(__DIR__) . '/public/manuales/Manual_Tecnico_CEAA.pdf',
            dirname(__DIR__) . '/public/manuales/manual-tecnico-ceaa.pdf',
        ];

        foreach ($preferred as $path) {
            if (is_file($path)) {
                return $path;
            }
        }

        $manualesDir = dirname(__DIR__) . '/public/manuales';
        if (is_dir($manualesDir)) {
            $pdfs = glob($manualesDir . '/*.pdf') ?: [];
            if (!empty($pdfs)) {
                usort($pdfs, fn($a, $b) => filemtime($b) <=> filemtime($a));
                return $pdfs[0];
            }
        }

        $legacyDir = dirname(__DIR__) . '/public/pdf';
        if (is_dir($legacyDir)) {
            $manualLike = glob($legacyDir . '/*{manual,Manual,tecnico,Tecnico,guia,Guia}*.pdf', GLOB_BRACE) ?: [];
            if (!empty($manualLike)) {
                usort($manualLike, fn($a, $b) => filemtime($b) <=> filemtime($a));
                return $manualLike[0];
            }
        }

        return null;
    }

    public function ver(): void
    {
        $filePath = $this->findManualPath();

        if (!$filePath || !is_file($filePath)) {
            http_response_code(404);
            echo 'No se encontró el manual técnico. Colócalo en /public/manuales/';
            exit;
        }

        $fileName = basename($filePath);
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($filePath));

        readfile($filePath);
        exit;
    }
}
