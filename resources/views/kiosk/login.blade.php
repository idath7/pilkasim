<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiosk Auth | e-Pilkasim</title>
    @php $faviconSetting = \App\Models\Setting::getCached(); @endphp
    @if($faviconSetting && $faviconSetting->logo_osim)
        <link rel="icon" href="{{ Storage::url($faviconSetting->logo_osim) }}" type="image/x-icon">
    @endif
    <link href="{{ asset('Assets/vendor/inter.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Assets/vendor/font-awesome.min.css') }}">
    <style>
        :root {
            --primary: {{ $appSetting->theme_color_1 ?? '#4F46E5' }};
            --primary-hover: {{ $appSetting->theme_color_2 ?? '#4338CA' }};
            --background: #F3F4F6;
            --surface: #FFFFFF;
            --text-main: #111827;
            --text-muted: #6B7280;
            --radius: 12px;
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        
        body {
            background-color: var(--background);
            background-image: url('{{ $appSetting->main_image ?? "" }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            z-index: 1;
        }

        .auth-card {
            background: var(--surface);
            width: 100%;
            max-width: 420px;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            padding: 2.5rem;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 1.5rem;
        }

        h2 {
            font-size: 1.5rem;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        p {
            color: var(--text-muted);
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .pin-inputs {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-bottom: 2rem;
            direction: ltr;
        }

        .pin-input {
            width: 45px;
            height: 55px;
            font-size: 1.5rem;
            text-align: center;
            font-weight: 700;
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            text-transform: uppercase;
            transition: all 0.2s;
            background: #F9FAFB;
        }

        .pin-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
            background: white;
        }

        .btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s;
        }

        .btn:hover { background-color: var(--primary-hover); transform: translateY(-1px); }

        .alert {
            background-color: #FEE2E2;
            color: #B91C1C;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>

    <div class="auth-card">
        @if($appSetting->school_logo)
            <img src="{{ $appSetting->school_logo }}" alt="Logo" class="logo">
        @endif
        
        <h2>Otorisasi Kiosk</h2>
        <p>Masukkan 6 Karakter PIN/Token Kiosk yang diatur di panel Admin untuk mengaktifkan layar ini.</p>

        @if(session('error'))
            <div class="alert"><i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}</div>
        @endif

        <form action="{{ route('kiosk.login') }}" method="POST">
            @csrf
            <input type="hidden" name="pin" id="pin_hidden" required>
            
            <div class="pin-inputs" id="pin_container">
                <input type="text" class="pin-input" maxlength="1" autocomplete="off" autofocus>
                <input type="text" class="pin-input" maxlength="1" autocomplete="off">
                <input type="text" class="pin-input" maxlength="1" autocomplete="off">
                <input type="text" class="pin-input" maxlength="1" autocomplete="off">
                <input type="text" class="pin-input" maxlength="1" autocomplete="off">
                <input type="text" class="pin-input" maxlength="1" autocomplete="off">
            </div>

            <button type="submit" class="btn"><i class="fa-solid fa-unlock-keyhole"></i> Buka Layar Kiosk</button>
        </form>
    </div>

    <script>
        const inputs = document.querySelectorAll('.pin-input');
        const hiddenInput = document.getElementById('pin_hidden');

        function updateHiddenInput() {
            hiddenInput.value = Array.from(inputs).map(input => input.value).join('');
        }

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
                updateHiddenInput();
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && e.target.value === '') {
                    if (index > 0) {
                        inputs[index - 1].focus();
                        inputs[index - 1].value = '';
                    }
                }
                updateHiddenInput();
            });
            
            // Handle Paste
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').slice(0, 6).toUpperCase();
                for (let i = 0; i < pasteData.length; i++) {
                    if (inputs[index + i]) {
                        inputs[index + i].value = pasteData[i];
                    }
                }
                updateHiddenInput();
                if (index + pasteData.length < inputs.length) {
                    inputs[index + pasteData.length].focus();
                } else {
                    inputs[inputs.length - 1].focus();
                }
            });
        });
    </script>
</body>
</html>

