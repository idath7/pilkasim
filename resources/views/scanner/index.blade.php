<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner | e-Pilkasim</title>
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
    <link href="{{ asset('Assets/vendor/plus-jakarta-sans.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Assets/vendor/font-awesome.min.css') }}">
    <!-- Include html5-qrcode library -->
    <script src="{{ asset('Assets/vendor/html5-qrcode.min.js') }}" type="text/javascript"></script>
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
            flex-direction: column;
            align-items: center;
        }

        .header {
            width: 100%;
            padding: 1.5rem;
            text-align: center;
            box-sizing: border-box;
        }

        .header h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .scanner-container {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            margin: 1rem;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        #reader {
            width: 100%;
            border: none !important;
            outline: none !important;
        }

        #reader video {
            border: none !important;
            outline: none !important;
        }

        #reader svg path {
            stroke: transparent !important;
        }

        
        #reader__dashboard_section_csr span {
            color: #333;
        }

        .scanner-overlay {
            padding: 1.5rem;
            text-align: center;
            background: #ffffff;
            color: #1e293b;
            border-top: 1px solid #e5e7eb;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 100px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 1rem;
            border: 1px solid rgba(255,255,255,0.3);
        }

        #message {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 8px;
            display: none;
            font-weight: 600;
            background: #fee2e2;
            color: #991b1b;
        }

        /* Modernize html5-qrcode UI */
        #reader button {
            background-color: {{ $appSetting->theme_color_3 ?? '#f59e0b' }};
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 100px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            margin: 0.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        #reader button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        #reader select {
            padding: 0.75rem 1rem;
            border-radius: 100px;
            border: 2px solid #e5e7eb;
            font-size: 1rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0.5rem;
            outline: none;
            cursor: pointer;
            transition: border-color 0.2s ease;
            max-width: 90%;
        }

        #reader select:focus {
            border-color: {{ $appSetting->theme_color_1 ?? '#2db8a6' }};
        }

        #reader a {
            color: {{ $appSetting->theme_color_1 ?? '#2db8a6' }};
            text-decoration: none;
            font-weight: 600;
        }

        #reader__dashboard_section_csr span, #reader__dashboard_section_swaplink {
            display: none !important; /* Hide unnecessary default texts */
        }
        
        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            .scanner-container {
                background: #1e293b;
                box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            }
            .scanner-overlay {
                background: #1e293b;
                color: #f8fafc;
                border-top: 1px solid #334155;
            }
            .scanner-overlay h3 {
                color: #f8fafc;
            }
            .scanner-overlay p {
                color: #cbd5e1 !important;
            }
            #reader select {
                background-color: #334155;
                color: #f8fafc;
                border-color: #475569;
            }
            #reader select:focus {
                border-color: {{ $appSetting->theme_color_3 ?? '#f59e0b' }};
            }
            #reader button {
                box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            }
            .btn-back {
                background: rgba(0,0,0,0.2);
                border: 1px solid rgba(255,255,255,0.1);
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Pindai QR Code</h1>
        <p style="opacity: 0.9; margin-top: 0.5rem; font-size: 0.9rem;">Arahkan kamera HP Anda ke layar Kiosk untuk login.</p>
    </div>

    <div class="scanner-container">
        <div id="reader"></div>
        <div class="scanner-overlay">
            <i class="fa-solid fa-qrcode" style="font-size: 2rem; color: {{ $appSetting->theme_color_3 ?? '#f59e0b' }}; margin-bottom: 0.5rem;"></i>
            <h3 style="margin: 0 0 0.5rem 0;">Menunggu QR Code...</h3>
            <p style="margin: 0; font-size: 0.9rem; color: #64748b;">Pastikan QR Code berada di dalam kotak pemindai.</p>
            
            <button id="switch-camera-btn" style="margin-top: 1rem; background: {{ $appSetting->theme_color_1 ?? '#2db8a6' }}; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 100px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); font-family: 'Plus Jakarta Sans', sans-serif;">
                <i class="fa-solid fa-camera-rotate"></i> Ganti Kamera
            </button>

            <div id="message"></div>
        </div>
    </div>

    <a href="{{ url('/') }}" class="btn-back">
        <i class="fa-solid fa-arrow-left" style="margin-right: 0.5rem;"></i> Kembali
    </a>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let html5QrCode = new Html5Qrcode("reader");
            let currentFacingMode = "environment";
            let lastScannedText = "";
            let scanDelay = false;

            function onScanSuccess(decodedText, decodedResult) {
                if (scanDelay) return;
                
                // Cek apakah URL valid dan mengandung /voting?token=
                if (decodedText.includes('/voting?token=')) {
                    scanDelay = true;
                    html5QrCode.stop().then(() => {
                        document.getElementById('message').style.display = 'block';
                        document.getElementById('message').style.background = '#dcfce7';
                        document.getElementById('message').style.color = '#166534';
                        document.getElementById('message').innerText = 'Berhasil! Mengalihkan ke bilik suara...';
                        
                        setTimeout(() => {
                            window.location.href = decodedText;
                        }, 500);
                    }).catch(err => console.error(err));
                } else {
                    scanDelay = true;
                    document.getElementById('message').style.display = 'block';
                    document.getElementById('message').style.background = '#fee2e2';
                    document.getElementById('message').style.color = '#991b1b';
                    document.getElementById('message').innerText = 'QR Code tidak valid untuk login.';
                    
                    setTimeout(() => {
                        scanDelay = false;
                        document.getElementById('message').style.display = 'none';
                    }, 3000);
                }
            }

            function onScanFailure(error) {
                // handle scan failure, usually better to ignore and keep scanning.
            }

            function showError(err) {
                console.error("Gagal memulai kamera", err);
                document.getElementById('message').style.display = 'block';
                document.getElementById('message').style.background = '#fee2e2';
                document.getElementById('message').style.color = '#991b1b';
                document.getElementById('message').innerText = 'Kamera tidak dapat diakses. Mohon izinkan akses kamera di browser Anda.';
            }

            function startScanner() {
                let config = { fps: 10, qrbox: {width: 250, height: 250}, aspectRatio: 1.0 };
                
                // Prioritaskan kamera belakang jika diminta
                let constraint = (currentFacingMode === "environment") 
                    ? { facingMode: { exact: "environment" } } 
                    : { facingMode: "user" };

                html5QrCode.start(constraint, config, onScanSuccess, onScanFailure)
                .catch((err) => {
                    // Fallback 1: Coba environment tanpa exact (untuk device tanpa back camera yg spesifik)
                    if (currentFacingMode === "environment") {
                        html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess, onScanFailure)
                        .catch((errFallback) => {
                            // Fallback 2: Coba kamera apapun (biasanya kamera depan akan menyala)
                            html5QrCode.start({ facingMode: "user" }, config, onScanSuccess, onScanFailure)
                            .catch(showError);
                        });
                    } else {
                        // Jika mode user (depan) gagal, coba kamera apapun
                        html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess, onScanFailure)
                        .catch(showError);
                    }
                });
            }

            document.getElementById('switch-camera-btn').addEventListener('click', function() {
                this.disabled = true;
                let btn = this;
                html5QrCode.stop().then(() => {
                    currentFacingMode = (currentFacingMode === "environment") ? "user" : "environment";
                    startScanner();
                    btn.disabled = false;
                }).catch(err => {
                    console.error("Gagal menghentikan kamera", err);
                    btn.disabled = false;
                });
            });

            // Mulai langsung saat halaman dimuat
            startScanner();
        });
    </script>
</body>
</html>

