<?php
/**
 * E-Pilketos Mini Installer (Dropper)
 * ----------------------------------------------------
 * File ini adalah satu-satunya file yang diberikan ke klien.
 * Klien mengunggah file ini ke public_html cPanel mereka.
 */

// Ganti URL ini dengan URL direct link ke file ZIP aplikasi Anda di cloud.
$cloudZipUrl = 'https://contoh-cloud-anda.com/download/epilketos-v1.zip'; 
$localZipPath = __DIR__ . '/epilketos-temp.zip';

$step = $_GET['step'] ?? 1;

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Pilketos Mini Installer</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .installer-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .logo {
            width: 60px;
            height: 60px;
            background: #2db8a6;
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            margin: 0 auto 20px;
        }
        h1 { margin: 0 0 10px; font-size: 24px; color: #111827; }
        p { color: #6b7280; font-size: 14px; margin-bottom: 30px; line-height: 1.5; }
        .btn {
            background-color: #2db8a6;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            text-decoration: none;
            display: inline-block;
            box-sizing: border-box;
            transition: background-color 0.2s;
        }
        .btn:hover { background-color: #1b8a7b; }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #2db8a6;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .log-box {
            background: #111827;
            color: #10b981;
            padding: 15px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 12px;
            text-align: left;
            margin-top: 20px;
            overflow-x: hidden;
        }
    </style>
</head>
<body>

<div class="installer-card">
    <div class="logo">EP</div>
    
    <?php if ($step == 1): ?>
        <h1>Instalasi E-Pilketos</h1>
        <p>Sistem akan mengunduh paket aplikasi secara otomatis dari server cloud dan mengekstraknya ke hosting Anda.</p>
        <a href="?step=2" class="btn">Mulai Unduh File</a>
        
    <?php elseif ($step == 2): ?>
        <h1>Memproses...</h1>
        <p>Tolong jangan tutup halaman ini.</p>
        <div class="loader"></div>
        <div class="log-box" id="logBox">Menghubungi server cloud...</div>
        
        <script>
            // Simulasi Log & Pindah Langkah 3 (Karena proses aslinya akan dieksekusi di backend)
            let logs = [
                "Mengunduh epilketos-v1.zip...",
                "Ukuran file: ~30MB",
                "Mengekstrak file ke public_html...",
                "Membersihkan file sementara...",
                "Mengalihkan ke Setup Wizard utama..."
            ];
            let i = 0;
            let interval = setInterval(() => {
                if(i < logs.length) {
                    document.getElementById('logBox').innerHTML += "<br>" + logs[i];
                    i++;
                } else {
                    clearInterval(interval);
                    window.location.href = "?step=3"; // Eksekusi proses sesungguhnya
                }
            }, 800);
        </script>
        
    <?php elseif ($step == 3): ?>
        <?php
        // LOGIKA BACKEND SESUNGGUHNYA DIEKSEKUSI DI SINI
        
        // 1. Download File ZIP
        if (!file_exists($localZipPath)) {
            // Menggunakan @ untuk menyembunyikan warning jika cloudZipUrl belum valid
            $fileContent = @file_get_contents($cloudZipUrl); 
            if ($fileContent) {
                file_put_contents($localZipPath, $fileContent);
            } else {
                echo "<h1>Gagal Mengunduh</h1><p>Pastikan URL Cloud ZIP valid dan server memiliki akses internet.</p>";
                exit;
            }
        }
        
        // 2. Ekstrak File ZIP
        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive;
            if ($zip->open($localZipPath) === TRUE) {
                $zip->extractTo(__DIR__); // Ekstrak ke folder yang sama dengan file installer.php
                $zip->close();
                
                // 3. Bersihkan file ZIP agar tidak memenuhi storage
                @unlink($localZipPath);
                
                // 4. (Opsional) Hapus diri sendiri
                // @unlink(__FILE__);
                
                // 5. Arahkan ke aplikasi utama (Akan memicu CheckInstallation Laravel)
                echo "<h1>Sukses!</h1><p>Mengarahkan Anda ke Setup Wizard...</p>";
                echo "<script>setTimeout(() => { window.location.href = 'index.php'; }, 1000);</script>";
            } else {
                echo "<h1>Gagal Mengekstrak</h1><p>File ZIP rusak atau permission folder ditolak.</p>";
            }
        } else {
            echo "<h1>Error</h1><p>Ekstensi PHP ZipArchive tidak aktif di hosting ini.</p>";
        }
        ?>
    <?php endif; ?>

</div>

</body>
</html>
