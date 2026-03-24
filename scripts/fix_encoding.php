<?php
/**
 * Repair script: fixes triple/double-encoded UTF-8 characters in editar_eca.php
 * Root cause: the file went through CP1252-based UTF-8 encoding 3 times.
 */
$file = 'c:/xampp/htdocs/ceaa_recursos/views/formatos/editar_eca.php';
$content = file_get_contents($file);

// --- PASS 1: Fix TRIPLE-encoded characters ---
// Pattern: each accent was encoded 3× through CP1252→UTF-8
// We replace the 8-14 byte garbled sequence with the correct 2-3 byte UTF-8 char.
// strtr() with array does longest-match first, so no ordering issues within this set.
$triple = [
    // Lowercase accents (8 bytes each: C3 83 C6 92 C3 82 C2 XX)
    "\xC3\x83\xC6\x92\xC3\x82\xC2\xA9" => "\xC3\xA9",  // é
    "\xC3\x83\xC6\x92\xC3\x82\xC2\xB3" => "\xC3\xB3",  // ó
    "\xC3\x83\xC6\x92\xC3\x82\xC2\xA1" => "\xC3\xA1",  // á
    "\xC3\x83\xC6\x92\xC3\x82\xC2\xAD" => "\xC3\xAD",  // í
    "\xC3\x83\xC6\x92\xC3\x82\xC2\xBA" => "\xC3\xBA",  // ú
    "\xC3\x83\xC6\x92\xC3\x82\xC2\xB1" => "\xC3\xB1",  // ñ
    "\xC3\x83\xC6\x92\xC3\x82\xC2\xBC" => "\xC3\xBC",  // ü
    // Uppercase accents
    "\xC3\x83\xC6\x92\xC3\xA2\xE2\x82\xAC\xC5\x93" => "\xC3\x93",  // Ó (11 bytes)
    "\xC3\x83\xC6\x92\xC3\x82\xC2\x81" => "\xC3\x81",  // Á (8 bytes)
    // Special chars
    // ← (leftwards arrow, U+2190): 11 bytes
    "\xC3\x83\xC2\xA2\xC3\xA2\xE2\x82\xAC\xC2\xA0\xC3\x82\xC2\x90" => "\xE2\x86\x90",
    // — (em dash, U+2014): 15 bytes
    "\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\xA2\xE2\x82\xAC\xC2\x9D" => "\xE2\x80\x94",
];

$content = strtr($content, $triple);

// --- PASS 2: Fix DOUBLE-encoded characters ---
// Only a few chars in the file are double-encoded (e.g., line 616 in JS).
// These 4-byte patterns will NOT conflict with the above because the triple-encoded
// versions have already been replaced.
$double = [
    "\xC3\x83\xC2\xA9" => "\xC3\xA9",  // é
    "\xC3\x83\xC2\xB3" => "\xC3\xB3",  // ó
    "\xC3\x83\xC2\xA1" => "\xC3\xA1",  // á
    "\xC3\x83\xC2\xAD" => "\xC3\xAD",  // í
    "\xC3\x83\xC2\xBA" => "\xC3\xBA",  // ú
    "\xC3\x83\xC2\xB1" => "\xC3\xB1",  // ñ
    "\xC3\x83\xC2\xBC" => "\xC3\xBC",  // ü
    "\xC3\x83\xC2\x93" => "\xC3\x93",  // Ó
    "\xC3\x83\xC2\x81" => "\xC3\x81",  // Á
];

$content = strtr($content, $double);

// Remove the useless header() call on line 1 that never fires
// (HTML is already sent by dashboard.php before this file is included)
$content = preg_replace('/^<\?php\s+header\([^)]+\);\s*\?>\r?\n/', '', $content);

file_put_contents($file, $content);
echo "Repair complete. File size: " . strlen($content) . " bytes\n";

// Verify: check for remaining garbled C3 83 sequences
$remaining = preg_match_all('/\xC3\x83/', $content, $m);
echo "Remaining C3 83 sequences: $remaining\n";
