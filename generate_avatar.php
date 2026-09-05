<?php
$imagesDir = __DIR__ . '/public/assets/images';
if (!is_dir($imagesDir)) {
    mkdir($imagesDir, 0755, true);
}

// 250x250 solid color image with #4F46E5 background
$img = imagecreatetruecolor(250, 250);
$bg = imagecolorallocate($img, 79, 70, 229); // #4F46E5
imagefill($img, 0, 0, $bg);
$text_color = imagecolorallocate($img, 255, 255, 255);
// simple "U" text as placeholder
imagestring($img, 5, 120, 115, "U", $text_color);

imagepng($img, $imagesDir . '/default-avatar.png');
imagedestroy($img);
echo "Avatar generated!";
