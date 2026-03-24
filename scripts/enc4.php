<?php
$f = 'c:/xampp/htdocs/ceaa_recursos/views/formatos/editar_eca.php';
$content = file_get_contents($f);

// Find remaining C3 83 sequence
$pos = 0;
while (($pos = strpos($content, "\xC3\x83", $pos)) !== false) {
    // Show context with bytes
    $start = max(0, $pos - 10);
    $len = min(40, strlen($content) - $start);
    $chunk = substr($content, $start, $len);
    
    // Find line number
    $before = substr($content, 0, $pos);
    $line = substr_count($before, "\n") + 1;
    
    echo "Found at byte pos $pos (line ~$line):\n";
    echo "Text: " . $chunk . "\n";
    echo "Bytes: ";
    for ($i = 0; $i < strlen($chunk); $i++) {
        echo sprintf('%02X ', ord($chunk[$i]));
    }
    echo "\n\n";
    
    $pos += 2;
}

// Also show first 5 lines to verify header removal
echo "=== First 3 lines ===\n";
$lines = explode("\n", $content);
for ($i = 0; $i < 3; $i++) {
    echo "Line " . ($i+1) . ": " . rtrim($lines[$i]) . "\n";
}
