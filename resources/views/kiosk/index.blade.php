<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk | {{ $appSetting->app_name ?? 'E-Pilketos' }}</title>
    @php $faviconSetting = \App\Models\Setting::getCached(); @endphp
    @if($faviconSetting && $faviconSetting->osim_logo)
        <link rel="icon" href="{{ asset($faviconSetting->osim_logo) }}" type="image/png">
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
    <link href="{{ asset('Assets/vendor/plus-jakarta-sans.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Assets/vendor/font-awesome.min.css') }}">
    <script src="{{ asset('Assets/vendor/qrcode.min.js') }}"></script>
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
            min-width: 300px;
            min-height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        #qrcode img, #qrcode canvas {
            width: 300px;
            height: 300px;
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

        /* Results CSS */
        .result-card {
            display: flex;
            align-items: center;
            padding: 0.25rem;
            gap: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
        }
        
        .result-photo {
            width: 110px;
            height: 110px;
            border-radius: 0.75rem;
            object-fit: cover;
            object-position: top center;
            background-color: #E5E7EB;
        }
        
        .result-info {
            flex: 1;
            padding-right: 0.5rem;
        }
        
        .result-name {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 0.25rem;
            opacity: 0.9;
        }
        
        .progress-bar {
            width: 100%;
            height: 12px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            margin-top: 0.5rem;
            overflow: hidden;
        }
        
        @keyframes progress-stripes {
            from { background-position: 1rem 0; }
            to { background-position: 0 0; }
        }
        
        .progress-fill {
            height: 100%;
            background-color: {{ $appSetting->theme_color_3 ?? '#f59e0b' }};
            border-radius: 6px;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
            background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.25) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.25) 50%, rgba(255, 255, 255, 0.25) 75%, transparent 75%, transparent);
            background-size: 1rem 1rem;
            animation: progress-stripes 1s linear infinite;
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
        
        <!-- Top Section: Logo and Titles -->
        <div class="header-section animate-up" style="display: flex; align-items: center; justify-content: center; gap: 2rem; flex-wrap: wrap;">
            <!-- Logo -->
            <div class="header-logo" style="width: 180px; flex-shrink: 0;">
                @if(isset($appSetting) && $appSetting->osim_logo)
                    <img src="{{ $appSetting->osim_logo }}" alt="Logo OSIM" style="width: 100%; height: auto; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                @else
                    <div class="logo-placeholder" style="width: 180px; height: 180px; border-radius: 1rem; padding: 0.5rem; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.1);">
                        <i class="fa-solid fa-shield-halved" style="font-size: 4rem; margin: 0; color: rgba(255,255,255,0.8);"></i>
                    </div>
                @endif
            </div>
            
            <!-- Titles -->
            <div class="header-text" style="text-align: left;">
                <h1 class="login-title" style="margin-bottom: 0.5rem; margin-top: 0;">{{ $appSetting->header_title ?? 'LOGIN HAK PILIH' }}</h1>
                <h2 class="school-name" style="margin-top: 0;">{{ $appSetting->election_title ?? 'Pemilihan Ketua OSIS' }}<br>{{ $appSetting->school_name ?? 'Nama Madrasah Belum Diatur' }}</h2>
                @if(!empty($appSetting->period))
                    <h3 style="font-size: 1.25rem; font-weight: 600; opacity: 0.9; margin-top: 0.5rem; margin-bottom: 0;">Periode {{ $appSetting->period }}</h3>
                @endif
            </div>
        </div>

        <!-- Middle Section: Instructions and QR -->
        <div class="main-content-row animate-up" style="animation-delay: 0.2s">
            
            <!-- Left Side: Instructions and Results -->
            <div class="instruction-section" style="flex: 1; max-width: 500px; display: flex; flex-direction: column; align-items: flex-start; text-align: left; gap: 2rem;">
                <!-- Live Results -->
                <div style="width: 100%; display: flex; flex-direction: column; gap: 1rem;">
                    @if(isset($candidates) && count($candidates) > 0)
                        @php
                            $totalCandidateVotes = $candidates->sum('votes');
                        @endphp
                        <h3 style="margin: 0; font-size: 1.1rem; opacity: 0.8; text-transform: uppercase; letter-spacing: 1px;">Perolehan Suara Sementara</h3>
                        @foreach($candidates->sortByDesc('votes') as $candidate)
                            <div class="result-card">
                                @php
                                    $photoPath = str_replace('../Assets', '/Assets', $candidate->photo);
                                    $percentage = $totalCandidateVotes > 0 ? round(($candidate->votes / $totalCandidateVotes) * 100, 1) : 0;
                                @endphp
                                <img src="{{ $photoPath }}" alt="{{ $candidate->name }}" class="result-photo" onerror="this.src='{{ asset('Assets/images/default-avatar.svg') }}'">
                                
                                <div class="result-info">
                                    <div class="result-name">{{ $candidate->name }}</div>
                                    <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                                        <span style="font-size: 1.25rem; font-weight: 800; color: white;">{{ $candidate->votes }} Suara</span>
                                        <span style="font-weight: 700; color: {{ $appSetting->theme_color_3 ?? '#f59e0b' }};">{{ $percentage }}%</span>
                                    </div>
                                    
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: 0%;" data-width="{{ $percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Right Side: Content -->
            <div class="qr-container">
                <div id="qrcode"></div>
                <div class="timer-badge">
                    <i class="fa-solid fa-clock-rotate-left"></i> <span id="timer">Memuat...</span>
                </div>
            </div>

        </div>

        <!-- Bottom Section: Instructions -->
        <div class="instruction-bottom animate-up" style="animation-delay: 0.4s; text-align: center; margin-top: 2rem; background: rgba(0,0,0,0.2); padding: 0.75rem 1.5rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <p class="instruction-text" style="font-size: 1.35rem; line-height: 1.6; opacity: 0.95; margin: 0;">
                Silakan buka halaman utama di HP Anda, klik <strong style="color: {{ $appSetting->theme_color_3 ?? '#f59e0b' }}; font-weight: 800;">"Mulai Memilih"</strong>, lalu arahkan kamera ke QR Code ini.
            </p>
        </div>
    </div>

    <!-- Running Text di Bawah Layar -->
    <div class="running-text-container">
        <div class="running-text-content">
            {{ $appSetting->running_text ?? 'Selamat Datang di Pemilihan Ketua OSIM. Gunakan hak suara Anda dengan jujur, adil, bebas, dan rahasia!' }}
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
                    width: 300,
                    height: 300,
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
            
            // Trigger progress bar fill animation
            setTimeout(() => {
                document.querySelectorAll('.progress-fill').forEach(bar => {
                    bar.style.width = bar.getAttribute('data-width');
                });
            }, 300);
        });
    </script>
</body>
</html>

