<?php
$f = 'c:/xampp/htdocs/ceaa_recursos/views/formatos/editar_eca.php';
$content = file_get_contents($f);
$pos = strpos($content, 'cnica');
if ($pos !== false) {
    echo 'Pos: ' . $pos . "\n";
    $bytes = substr($content, $pos - 3, 8);
    for ($i = 0; $i < strlen($bytes); $i++) {
        echo '0x' . strtoupper(dechex(ord($bytes[$i]))) . ' ';
    }
    echo "\n";
} else {
    echo "No se encontro 'cnica'\n";
}
$isUtf8 = mb_detect_encoding($content, 'UTF-8', true);
echo 'Is valid UTF-8: ' . ($isUtf8 ? 'SI' : 'NO') . "\n";
