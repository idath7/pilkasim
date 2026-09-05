<?php
// Script to download external assets

$vendorDir = __DIR__ . '/assets/vendor';
if (!is_dir($vendorDir)) {
    mkdir($vendorDir, 0755, true);
}

$webfontsDir = $vendorDir . '/webfonts';
if (!is_dir($webfontsDir)) {
    mkdir($webfontsDir, 0755, true);
}

// Map of URLs to download
$assets = [
    // SweetAlert2
    'https://cdn.jsdelivr.net/npm/sweetalert2@11' => 'sweetalert2.min.js',
    // HTML5-QRCode
    'https://unpkg.com/html5-qrcode' => 'html5-qrcode.min.js',
    // QRCode.js
    'https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js' => 'qrcode.min.js',
    // Quill.js
    'https://cdn.quilljs.com/1.3.6/quill.js' => 'quill.js',
    'https://cdn.quilljs.com/1.3.6/quill.snow.css' => 'quill.snow.css',
    // Flatpickr
    'https://cdn.jsdelivr.net/npm/flatpickr' => 'flatpickr.min.js',
    'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css' => 'flatpickr.min.css',
];

// Context for fetching to act like a real browser
$context = stream_context_create([
    "http" => [
        "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
    ]
]);

foreach ($assets as $url => $filename) {
    echo "Downloading $filename...\n";
    $content = file_get_contents($url, false, $context);
    if ($content) {
        file_put_contents($vendorDir . '/' . $filename, $content);
        echo "OK\n";
    } else {
        echo "FAILED to download $url\n";
    }
}

// Download FontAwesome Free 6.4.0 CSS and adjust paths
$faUrl = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
echo "Downloading font-awesome.min.css...\n";
$faCss = file_get_contents($faUrl, false, $context);
if ($faCss) {
    // Save as is
    file_put_contents($vendorDir . '/font-awesome.min.css', $faCss);
    echo "OK\n";
}

// FontAwesome Webfonts
$faFonts = [
    'fa-brands-400.woff2',
    'fa-brands-400.ttf',
    'fa-regular-400.woff2',
    'fa-regular-400.ttf',
    'fa-solid-900.woff2',
    'fa-solid-900.ttf',
    'fa-v4compatibility.woff2',
    'fa-v4compatibility.ttf'
];
foreach ($faFonts as $font) {
    $fontUrl = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/webfonts/$font";
    echo "Downloading $font...\n";
    $content = file_get_contents($fontUrl, false, $context);
    if ($content) {
        file_put_contents($webfontsDir . '/' . $font, $content);
        echo "OK\n";
    } else {
        echo "FAILED\n";
    }
}

// Download Google Fonts CSS (Inter + Plus Jakarta Sans)
// Since Google Fonts returns different CSS based on User-Agent, we will fetch standard WOFF2 URLs
// We can use the API from https://gwfh.mranftl.com/api/fonts to get actual fonts easily, 
// but it's simpler to just include the CSS from Google, download the linked woff2 files, and rewrite the CSS.

function downloadGoogleFont($name, $weights) {
    global $vendorDir, $context, $webfontsDir;
    $url = "https://fonts.googleapis.com/css2?family=" . urlencode($name) . ":wght@" . $weights . "&display=swap";
    
    echo "Downloading CSS for $name...\n";
    $css = file_get_contents($url, false, $context);
    
    if ($css) {
        preg_match_all('/url\((https:\/\/fonts\.gstatic\.com\/s\/[^\)]+)\)/', $css, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $fontUrl) {
                $filename = basename($fontUrl);
                echo "Downloading font file $filename...\n";
                $fontData = file_get_contents($fontUrl, false, $context);
                if ($fontData) {
                    file_put_contents($webfontsDir . '/' . $filename, $fontData);
                    // Replace URL in CSS
                    $css = str_replace($fontUrl, 'webfonts/' . $filename, $css);
                }
            }
        }
        $cssFilename = str_replace(' ', '-', strtolower($name)) . '.css';
        file_put_contents($vendorDir . '/' . $cssFilename, $css);
        echo "Saved CSS $cssFilename\n";
    }
}

downloadGoogleFont('Inter', '300;400;500;600;700');
downloadGoogleFont('Plus Jakarta Sans', '400;500;600;700;800');

echo "All downloads completed!\n";
