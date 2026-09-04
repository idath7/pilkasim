<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Pilkasim | Pemilihan Cerdas</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #4F46E5;
            --primary-hover: #4338CA;
            --secondary: #10B981;
            --background: #F3F4F6;
            --surface: #FFFFFF;
            --text-main: #111827;
            --text-muted: #6B7280;
            --border: #E5E7EB;
            --radius: 12px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--background);
            color: var(--text-main);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            flex: 1;
        }

        /* Forms & Inputs */
        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-main);
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: all 0.2s;
            background-color: #F9FAFB;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
            background-color: var(--surface);
        }

        .btn {
            display: inline-block;
            background-color: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            text-decoration: none;
        }

        .btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .btn-secondary {
            background-color: var(--surface);
            color: var(--text-main);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background-color: #F3F4F6;
        }
        
        .btn-danger {
            background-color: #EF4444;
        }
        
        .btn-danger:hover {
            background-color: #DC2626;
        }

        /* Cards */
        .card {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 2rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Header / Navbar */
        .navbar {
            background: var(--surface);
            box-shadow: var(--shadow);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

    </style>
    @yield('styles')
</head>
<body>
    @if(!isset($hideNavbar))
    <nav class="navbar">
        <a href="#" class="navbar-brand">
            <i class="fa-solid fa-check-to-slot"></i> e-Pilkasim
        </a>
        <div>
            @if(session('voter_id'))
                <form action="{{ route('voter.logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="padding: 0.4rem 1rem; font-size: 0.875rem;">Keluar</button>
                </form>
            @endif
        </div>
    </nav>
    @endif

    <div class="container">
        @yield('content')
    </div>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: {{ session('timer', 3000) }},
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

        @if($errors->any())
            Toast.fire({
                icon: 'error',
                title: '{{ $errors->first() }}'
            });
        @endif

        function showChangePasswordModal() {
            Swal.fire({
                title: 'Ganti Password Admin',
                input: 'password',
                inputLabel: 'Masukkan password baru',
                inputPlaceholder: 'Minimal 4 karakter',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Password tidak boleh kosong!'
                    }
                    if (value.length < 4) {
                        return 'Password minimal 4 karakter!'
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("admin.password.update") }}';
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);

                    const pwd = document.createElement('input');
                    pwd.type = 'hidden';
                    pwd.name = 'new_password';
                    pwd.value = result.value;
                    form.appendChild(pwd);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
    @yield('scripts')
</body>
</html>

