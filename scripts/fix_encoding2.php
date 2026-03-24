<?php
/**
 * Second-pass repair: fix remaining CP1252-style double-encoded uppercase chars.
 * These have patterns like C3 83 + E2 80 XX (the 0x8X-0x9X CP1252 range maps to
 * multi-byte UTF-8 sequences instead of C2 XX used by ISO-8859-1).
 */
$file = 'c:/xampp/htdocs/ceaa_recursos/views/formatos/editar_eca.php';
$content = file_get_contents($file);

$fixes = [
    // Ó: C3 83 + E2 80 9C (0xD3→C3 93→Ã + 0x93→U+201C→E2 80 9C)
    "\xC3\x83\xE2\x80\x9C" => "\xC3\x93",
    // É: C3 83 + E2 80 B0 (0xC9→C3 89→Ã + 0x89→U+2030→E2 80 B0)
    "\xC3\x83\xE2\x80\xB0" => "\xC3\x89",
    // Ñ: C3 83 + E2 80 98 (0xD1→C3 91→Ã + 0x91→U+2018→E2 80 98)
    "\xC3\x83\xE2\x80\x98" => "\xC3\x91",
    // Ú: C3 83 + C5 A1 (0xDA→C3 9A→Ã + 0x9A→U+0161→C5 A1)
    "\xC3\x83\xC5\xA1" => "\xC3\x9A",
];

$content = strtr($content, $fixes);
file_put_contents($file, $content);

$remaining = preg_match_all('/\xC3\x83/', $content, $m);
echo "Remaining C3 83 sequences after pass 2: $remaining\n";
echo "File size: " . strlen($content) . " bytes\n";
