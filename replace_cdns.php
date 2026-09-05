<?php
$viewsDir = __DIR__ . '/resources/views';

$replacements = [
    'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap' => "{{ asset('assets/vendor/plus-jakarta-sans.css') }}",
    'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap' => "{{ asset('assets/vendor/inter.css') }}",
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' => "{{ asset('assets/vendor/font-awesome.min.css') }}",
    'https://cdn.jsdelivr.net/npm/sweetalert2@11' => "{{ asset('assets/vendor/sweetalert2.min.js') }}",
    'https://unpkg.com/html5-qrcode' => "{{ asset('assets/vendor/html5-qrcode.min.js') }}",
    'https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js' => "{{ asset('assets/vendor/qrcode.min.js') }}",
    'https://cdn.quilljs.com/1.3.6/quill.js' => "{{ asset('assets/vendor/quill.js') }}",
    'https://cdn.quilljs.com/1.3.6/quill.snow.css' => "{{ asset('assets/vendor/quill.snow.css') }}",
    'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css' => "{{ asset('assets/vendor/flatpickr.min.css') }}",
    'https://cdn.jsdelivr.net/npm/flatpickr' => "{{ asset('assets/vendor/flatpickr.min.js') }}"
];

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        $changed = false;
        
        foreach ($replacements as $search => $replace) {
            if (strpos($content, $search) !== false) {
                $content = str_replace($search, $replace, $content);
                $changed = true;
            }
        }

        // Replace UI Avatars
        $uiAvatarRegex = '/https:\/\/ui-avatars\.com\/api\/\?name=[^\']+/';
        if (preg_match($uiAvatarRegex, $content)) {
            $content = preg_replace($uiAvatarRegex, "{{ asset('assets/images/default-avatar.png') }}", $content);
            $changed = true;
        }
        
        if ($changed) {
            file_put_contents($path, $content);
            echo "Updated $path\n";
        }
    }
}
