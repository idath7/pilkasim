<?php
$path = __DIR__ . '/public/assets/vendor/font-awesome.min.css';
$css = file_get_contents($path);
$css = str_replace('../webfonts/', 'webfonts/', $css);
file_put_contents($path, $css);
echo "CSS webfonts path fixed!";
