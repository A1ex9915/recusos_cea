<?php
$f = 'c:/xampp/htdocs/ceaa_recursos/views/formatos/editar_eca.php';
$lines = file($f);

// Show bytes for specific lines
$targets = [188, 393, 394, 395, 616];
foreach ($targets as $n) {
    $idx = $n - 1;
    if (!isset($lines[$idx])) continue;
    $line = $lines[$idx];
    echo "--- Line $n ---\n";
    echo "Text: " . rtrim($line) . "\n";
    echo "Bytes: ";
    for ($i = 0; $i < min(strlen($line), 100); $i++) {
        echo sprintf('%02X ', ord($line[$i]));
    }
    echo "\n\n";
}
