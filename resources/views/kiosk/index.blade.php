<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk | e-Pilkasim</title>
    @php $faviconSetting = \App\Models\Setting::getCached(); @endphp
    @if($faviconSetting && $faviconSetting->logo_osim)
        <link rel="icon" href="{{ Storage::url($faviconSetting->logo_osim) }}" type="image/png">
    @endif
    @if(isset($appSetting) && is_array($appSetting->dynamic_color_tags))
    <style>
        @foreach($appSetting->dynamic_color_tags as $tagData)
            @if(!empty($tagData['tag']))
            .{{ $tagData['tag'] }} { 
                background-color: {{ $tagData['bg_color'] ?? 'transparent' }} !important; 
                color: {{ $tagData['text_color'] ?? 'inherit' }} !important; 
            }
            .text-{{ $tagData['tag'] }} { color: {{ $tagData['text_color'] ?? 'inherit' }} !important; }
            @endif
        @endforeach
    </style>
    @endif
    <link href="{{ asset('assets/vendor/plus-jakarta-sans.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome.min.css') }}">
    <script src="{{ asset('assets/vendor/qrcode.min.js') }}"></script>
    <style>
        body {
            @if(isset($appSetting) && $appSetting->use_gradient)
                background: linear-gradient(135deg, {{ $appSetting->theme_color_1 ?? '#2db8a6' }} 0%, {{ $appSetting->theme_color_2 ?? '#1b9282' }} 100%);
            @else
                background-color: {{ $appSetting->theme_color_1 ?? '#2db8a6' }};
            @endif
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: {{ $appSetting->theme_color_4 ?? '#ffffff' }};
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            align-items: center;
        }

        .header-section {
            width: 100%;
            text-align: center;
            margin-bottom: 1rem;
        }

        .main-content-row {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 3rem;
            align-items: center;
        }

        .logo-section {
            width: 100%;
            max-width: 350px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            text-align: center;
        }

        .logo-placeholder {
            width: 250px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px dashed rgba(255, 255, 255, 0.5);
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            text-align: center;
            padding: 1rem;
        }
        
        .logo-placeholder i {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .login-title {
            color: {{ $appSetting->theme_color_3 ?? '#f59e0b' }};
            font-size: 2rem;
            font-weight: 800;
            margin: 0;
            text-transform: uppercase;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        .school-name {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        .qr-container {
            background: white;
            padding: 2rem;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            position: relative;
        }

        #qrcode {
            /* Kiosk QR code should be big */
            min-width: 400px;
            min-height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        #qrcode img, #qrcode canvas {
            width: 400px;
            height: 400px;
        }

        .timer-badge {
            background: {{ $appSetting->theme_color_3 ?? '#f59e0b' }};
            color: #1e293b;
            padding: 0.75rem 2rem;
            border-radius: 100px;
            font-size: 1.25rem;
            font-weight: 800;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Desktop Layout adjustments */
        @media (min-width: 768px) {
            .container {
                gap: 3rem;
            }

            .header-section {
                margin-top: -4rem; /* Geser teks judul lebih ke atas */
            }

            .main-content-row {
                flex-direction: row;
                justify-content: center;
                align-items: flex-start;
                gap: 6rem;
                margin-top: -2rem; /* Geser seluruh baris logo & QR ke atas */
            }

            .logo-section {
                flex: 1;
                max-width: 400px;
                align-items: center;
            }

            .logo-placeholder {
                width: 300px;
                height: 380px;
            }
            
            .login-title {
                font-size: 2.5rem;
            }
            
            .school-name {
                font-size: 2rem;
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-up {
            animation: fadeIn 0.8s ease forwards;
        }

        /* Running Text CSS */
        .running-text-container {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.3);
            color: #ffffff;
            padding: 0.8rem 0;
            overflow: hidden;
            white-space: nowrap;
            z-index: 1000;
            backdrop-filter: blur(8px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 -5px 15px rgba(0,0,0,0.1);
        }

        .running-text-content {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 25s linear infinite;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }
    </style>
</head>
<body>

    <div class="container">
        
        <!-- Top Section: Titles -->
        <div class="header-section animate-up">
            <h1 class="login-title">Scan Untuk Memilih</h1>
            <h2 class="school-name">Pemilihan Ketua OSIM<br>{{ $appSetting->school_name ?? 'Nama Madrasah Belum Diatur' }}</h2>
        </div>

        <!-- Middle Section: Logo and QR -->
        <div class="main-content-row animate-up" style="animation-delay: 0.2s">
            
            <!-- Left Side: Logo -->
            <div class="logo-section">
                @if(isset($appSetting) && $appSetting->osim_logo)
                    <img src="{{ $appSetting->osim_logo }}" alt="Logo OSIM" style="max-width: 100%; height: auto; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                @else
                    <div class="logo-placeholder">
                        <i class="fa-solid fa-shield-halved"></i>
                        <p><strong>Ruang Logo</strong><br><small>Logo OSIM belum diatur</small></p>
                    </div>
                @endif
                <p class="instruction-text" style="font-size: 1.35rem; line-height: 1.6; opacity: 0.95; margin-top: 2rem; margin-bottom: 0; max-width: 90%;">Silakan buka halaman utama di HP Anda, klik <strong style="color: {{ $appSetting->theme_color_3 ?? '#f59e0b' }}; font-weight: 800;">"Mulai Memilih"</strong>, lalu arahkan kamera ke QR Code ini.</p>
            </div>

            <!-- Right Side: Content -->
            <div class="qr-container">
                <div id="qrcode"></div>
                <div class="timer-badge">
                    <i class="fa-solid fa-clock-rotate-left"></i> <span id="timer">Memuat...</span>
                </div>
            </div>

        </div>
    </div>

    <!-- Running Text di Bawah Layar -->
    <div class="running-text-container">
        <div class="running-text-content">
            Selamat Datang di Pemilihan Ketua OSIM {{ $appSetting->school_name ?? '' }} Tahun {{ date('Y') }}. Pastikan Anda telah terdaftar sebagai pemilih tetap. Gunakan hak suara Anda dengan jujur, adil, bebas, dan rahasia! Satu suara Anda menentukan masa depan Madrasah kita.
        </div>
    </div>

    <script>
        let qrCodeObj = null;
        let pollInterval = null;
        let countdownTimer = null;
        let currentToken = null;

        function renderQR(url) {
            if (qrCodeObj) {
                qrCodeObj.clear();
                qrCodeObj.makeCode(url);
            } else {
                qrCodeObj = new QRCode(document.getElementById("qrcode"), {
                    text: url,
                    width: 400,
                    height: 400,
                    colorDark : "#1e293b",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.H
                });
            }
        }

        function fetchToken() {
            clearInterval(pollInterval);
            clearInterval(countdownTimer);
            fetch('{{ route("kiosk.token") }}')
                .then(res => res.json())
                .then(data => {
                    currentToken = data.token;
                    renderQR(data.url);
                    startCountdown(data.remaining || 30);
                    startPolling();
                })
                .catch(err => {
                    console.error('Error fetching token:', err);
                    document.getElementById('timer').innerText = 'Gagal memuat. Mencoba lagi...';
                    setTimeout(fetchToken, 3000);
                });
        }

        function startCountdown(seconds) {
            let remaining = seconds;
            document.getElementById('timer').innerText = remaining + ' Detik';
            
            countdownTimer = setInterval(() => {
                remaining--;
                if (remaining <= 0) {
                    clearInterval(countdownTimer);
                    document.getElementById('timer').innerText = 'Memperbarui QR...';
                    fetchToken(); // Auto refresh if not scanned
                } else {
                    document.getElementById('timer').innerText = remaining + ' Detik';
                }
            }, 1000);
        }

        function startPolling() {
            pollInterval = setInterval(() => {
                if (!currentToken) return;
                fetch(`{{ route("kiosk.status") }}?token=${currentToken}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'used') {
                            clearInterval(countdownTimer); // Stop countdown immediately
                            document.getElementById('timer').innerText = 'Memperbarui QR...';
                            fetchToken();
                        }
                    })
                    .catch(err => console.error('Error checking status:', err));
            }, 2000);
        }

        document.addEventListener("DOMContentLoaded", function() {
            fetchToken();
        });
    </script>
</body>
</html>

