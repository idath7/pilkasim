<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang | e-Pilkasim</title>
    @php $faviconSetting = \App\Models\Setting::getCached(); @endphp
    @if($faviconSetting)
        @if($faviconSetting->logo_osim)
            <link rel="icon" href="{{ Storage::url($faviconSetting->logo_osim) }}" type="image/x-icon">
        @endif
        @if($faviconSetting->seo_title || $faviconSetting->seo_description)
            <meta name="description" content="{{ $faviconSetting->seo_description ?? 'Aplikasi Pemilihan' }}">
            <meta property="og:title" content="{{ $faviconSetting->seo_title ?? 'e-Pilkasim' }}">
            <meta property="og:description" content="{{ $faviconSetting->seo_description ?? 'Aplikasi Pemilihan' }}">
            @if($faviconSetting->seo_image)
                <meta property="og:image" content="{{ url(Storage::url($faviconSetting->seo_image)) }}">
            @endif
            <meta property="og:type" content="website">
        @endif
    @endif
    <link href="{{ asset('assets/vendor/plus-jakarta-sans.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome.min.css') }}">
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
            max-width: 1000px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 3rem;
            align-items: center;
        }

        .logo-section {
            width: 100%;
            max-width: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
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

        .content-section {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .instructions {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 16px;
            border-left: 4px solid {{ $appSetting->theme_color_3 ?? '#f59e0b' }};
        }

        .instructions h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.25rem;
            text-decoration: underline;
            font-weight: 700;
        }

        .instructions p {
            margin: 0;
            font-size: 1.05rem;
            line-height: 1.6;
            opacity: 0.9;
        }

        .login-area {
            text-align: left;
        }

        .login-title {
            color: {{ $appSetting->theme_color_3 ?? '#f59e0b' }};
            font-size: 2rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            text-transform: uppercase;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        .school-name {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0 0 1.5rem 0;
            line-height: 1.4;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            @if(isset($appSetting) && $appSetting->use_gradient)
                background: linear-gradient(135deg, {{ $appSetting->theme_color_5 ?? '#f59e0b' }} 0%, {{ $appSetting->theme_color_6 ?? '#d97706' }} 100%);
            @else
                background-color: {{ $appSetting->theme_color_5 ?? '#f59e0b' }};
            @endif
            color: #1e293b;
            padding: 1rem 2rem;
            border-radius: 100px;
            font-size: 1.1rem;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            gap: 0.75rem;
        }

        .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        /* Desktop Layout adjustments */
        @media (min-width: 768px) {
            .container {
                flex-direction: row;
                justify-content: space-between;
                gap: 4rem;
            }

            .logo-section {
                flex: 1;
                max-width: 400px;
                justify-content: flex-end;
            }

            .logo-placeholder {
                width: 300px;
                height: 380px;
            }

            .content-section {
                flex: 1.5;
            }
            
            .login-title {
                font-size: 2.5rem;
            }
            
            .school-name {
                font-size: 1.5rem;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .animate-left {
            animation: fadeIn 0.8s ease forwards;
        }
        
        .animate-right {
            animation: fadeInRight 0.8s ease forwards;
        }
    </style>
</head>
<body>

    <div class="container">
        
        <!-- Left Side: Logo -->
        <div class="logo-section animate-left">
            @if(isset($appSetting) && $appSetting->osim_logo)
                <img src="{{ $appSetting->osim_logo }}" alt="Logo OSIM" style="max-width: 100%; height: auto; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            @else
                <div class="logo-placeholder">
                    <i class="fa-solid fa-shield-halved"></i>
                    <p><strong>Ruang Logo</strong><br><small>Logo OSIM belum diatur</small></p>
                </div>
            @endif
        </div>

        <!-- Right Side: Content -->
        <div class="content-section animate-right">
            
            <div class="instructions">
                <h3>Cara Memilih :</h3>
                <p>{{ $appSetting->instructions ?? 'Instruksi belum diatur.' }}</p>
            </div>

            <div class="login-area">
                <h1 class="login-title">Login Hak Pilih</h1>
                <h2 class="school-name">Pemilihan Ketua OSIM<br>{{ $appSetting->school_name ?? 'Nama Sekolah Belum Diatur' }}</h2>
                
                <a href="{{ route('voter.login') }}" class="btn-primary">
                    Mulai Memilih <i class="fa-solid fa-qrcode"></i>
                </a>
            </div>

        </div>
        
    </div>

    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/vendor/sweetalert2.min.js') }}"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session("success") }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session("error") }}'
            });
        @endif
    </script>
</body>
</html>

