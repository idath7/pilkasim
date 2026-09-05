<?php
$directory = __DIR__ . '/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

$count = 0;
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php' && strpos($file->getFilename(), '.blade.php') !== false) {
        $path = $file->getRealPath();
        $content = file_get_contents($path);
        $original = $content;

        // Replace logo_osim with osim_logo in favicon logic
        $content = str_replace('$faviconSetting->logo_osim', '$faviconSetting->osim_logo', $content);
        
        // Replace Storage::url($faviconSetting->osim_logo) with just $faviconSetting->osim_logo
        // Because the db value already contains /storage/
        $content = str_replace('{{ Storage::url($faviconSetting->osim_logo) }}', '{{ asset($faviconSetting->osim_logo) }}', $content);
        
        if ($content !== $original) {
            file_put_contents($path, $content);
            echo "Updated: $path\n";
            $count++;
        }
    }
}
echo "Total files updated: $count\n";
