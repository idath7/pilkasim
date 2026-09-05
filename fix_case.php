<?php
$viewsDir = __DIR__ . '/resources/views';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        
        $changed = false;
        
        // Fix uppercase A in Assets
        if (strpos($content, "asset('assets/") !== false) {
            $content = str_replace("asset('assets/", "asset('Assets/", $content);
            $changed = true;
        }
        
        if ($changed) {
            file_put_contents($path, $content);
            echo "Updated case in $path\n";
        }
    }
}
echo "Case fix completed!\n";
