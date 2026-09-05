<?php
$html = file_get_contents('http://192.168.12.12:8000/admin/teachers');
if (preg_match('/<nav.*?<\/nav>/s', $html, $navMatch, PREG_OFFSET_CAPTURE) && preg_match('/<div class=\"container\">/s', $html, $containerMatch, PREG_OFFSET_CAPTURE)) {
    $navPos = $navMatch[0][1];
    $containerPos = $containerMatch[0][1];
    echo "Nav position: $navPos\nContainer position: $containerPos\n";
    if ($navPos > $containerPos) {
        echo "Navbar is rendered AFTER container!\n";
    } else {
        echo "Navbar is rendered BEFORE container!\n";
    }
}
