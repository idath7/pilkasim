<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Pilkasim | Pemilihan Cerdas</title>
    @php $faviconSetting = \App\Models\Setting::getCached(); @endphp
    @if($faviconSetting)
        @if($faviconSetting->osim_logo)
            <link rel="icon" href="{{ asset($faviconSetting->osim_logo) }}" type="image/png">
        @endif
        @if($faviconSetting->seo_title || $faviconSetting->seo_description)
            <meta name="description" content="{{ $faviconSetting->seo_description ?? 'Aplikasi Pemilihan' }}">
            <meta property="og:title" content="{{ $faviconSetting->seo_title ?? 'e-Pilkasim' }}">
            <meta property="og:description" content="{{ $faviconSetting->seo_description ?? 'Aplikasi Pemilihan' }}">
            @if($faviconSetting->seo_image)
                <meta property="og:image" content="{{ url($faviconSetting->seo_image) }}">
            @endif
            <meta property="og:type" content="website">
        @endif
    @endif
    <link href="{{ asset('Assets/vendor/inter.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Assets/vendor/font-awesome.min.css') }}">
    <script src="{{ asset('Assets/vendor/sweetalert2.min.js') }}"></script>
    @if(isset($faviconSetting) && is_array($faviconSetting->dynamic_color_tags))
    <style>
        @foreach($faviconSetting->dynamic_color_tags as $tagData)
            @if(!empty($tagData['tag']))
            .{{ $tagData['tag'] }} { 
                @if(!empty($tagData['is_gradient']))
                background: linear-gradient(135deg, {{ $tagData['bg_color'] ?? 'transparent' }}, {{ $tagData['bg_color_2'] ?? $tagData['bg_color'] ?? 'transparent' }}) !important; 
                @else
                background: {{ $tagData['bg_color'] ?? 'transparent' }} !important; 
                @endif
                color: {{ $tagData['text_color'] ?? 'inherit' }} !important; 
            }
            .text-{{ $tagData['tag'] }} { color: {{ $tagData['text_color'] ?? 'inherit' }} !important; }
            @endif
        @endforeach
    </style>
    @endif
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

        .nav-link {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(79, 70, 229, 0.1);
            color: var(--primary);
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: var(--surface);
            min-width: 160px;
            box-shadow: var(--shadow-lg);
            border-radius: 8px;
            z-index: 100;
            top: 100%;
            border: 1px solid var(--border);
            overflow: hidden;
        }
        
        .dropdown-content.dropdown-right {
            right: 0;
        }

        .dropdown-content a {
            color: var(--text-main);
            padding: 0.75rem 1rem;
            text-decoration: none;
            display: block;
            transition: background 0.2s;
        }

        .dropdown-content a:hover {
            background-color: #F9FAFB;
            color: var(--primary);
        }

        .dropdown:hover .dropdown-content,
        .dropdown.open .dropdown-content {
            display: block;
            animation: fadeIn 0.2s ease-out;
        }
        
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-main);
            cursor: pointer;
            padding: 0.5rem;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-wrap: wrap;
                gap: 1rem;
                justify-content: space-between;
                align-items: center;
            }
            .hamburger-btn {
                display: block;
            }
            .topbar-menu {
                width: 100%;
                display: none !important;
                flex-direction: column;
                align-items: stretch !important;
                order: 3;
                gap: 0.25rem !important;
            }
            .topbar-menu.show {
                display: flex !important;
                animation: fadeIn 0.3s ease-out;
            }
            .nav-link {
                white-space: normal;
                display: block;
                width: 100%;
            }
            .dropdown-content {
                position: static;
                box-shadow: none;
                border: none;
                padding-left: 1rem;
                background: rgba(0,0,0,0.02);
            }
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
        <a href="{{ auth('admin')->check() ? route('admin.dashboard') : '#' }}" class="navbar-brand">
            <i class="fa-solid fa-check-to-slot"></i> e-Pilkasim
        </a>
        
        @if(auth('admin')->check())
        <div class="topbar-menu" id="mobile-menu" style="display: flex; gap: 0.5rem; align-items: center;">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
            
            @if(auth('admin')->user()->role !== 'pembina')
                <div class="dropdown">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.voters') || request()->routeIs('admin.teachers') ? 'active' : '' }}" onclick="event.preventDefault(); this.parentElement.classList.toggle('open');"><i class="fa-solid fa-users"></i> Pemilih <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; margin-left: 2px;"></i></a>
                    <div class="dropdown-content">
                        <a href="{{ route('admin.voters') }}"><i class="fa-solid fa-user-graduate" style="width: 20px;"></i> Siswa</a>
                        <a href="{{ route('admin.teachers') }}"><i class="fa-solid fa-chalkboard-user" style="width: 20px;"></i> Guru</a>
                    </div>
                </div>
                <a href="{{ route('admin.candidates') }}" class="nav-link {{ request()->routeIs('admin.candidates') ? 'active' : '' }}"><i class="fa-solid fa-user-tie"></i> Kandidat</a>
            @endif
            
            @if(auth('admin')->user()->role === 'admin')
                <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="fa-solid fa-gear"></i> Pengaturan</a>
                <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}"><i class="fa-solid fa-user-shield"></i> Petugas</a>
            @endif
        </div>
        @endif

        <div style="display: flex; align-items: center; gap: 0.5rem;">
            @if(session('voter_id'))
                <form action="{{ route('voter.logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;"><i class="fa-solid fa-right-from-bracket"></i> Keluar</button>
                </form>
            @elseif(auth('admin')->check())
                <div class="dropdown">
                    <button class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;" onclick="this.parentElement.classList.toggle('open');">
                        <i class="fa-solid fa-circle-user"></i> {{ ucfirst(auth('admin')->user()->username) }} <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i>
                    </button>
                    <div class="dropdown-content dropdown-right">
                        @if(auth('admin')->user()->role === 'admin')
                            <a href="#" onclick="showChangePasswordModal()"><i class="fa-solid fa-key" style="width: 20px;"></i> Ganti Password</a>
                        @endif
                        <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0; padding: 0;">
                            @csrf
                            <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 0.75rem 1rem; cursor: pointer; color: #EF4444; font-size: 1rem;"><i class="fa-solid fa-right-from-bracket" style="width: 20px;"></i> Keluar</button>
                        </form>
                    </div>
                </div>
                
                <button class="hamburger-btn" onclick="document.getElementById('mobile-menu').classList.toggle('show')">
                    <i class="fa-solid fa-bars"></i>
                </button>
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

        function confirmAction(event, message) {
            event.preventDefault();
            const form = event.target;
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
    @yield('scripts')
</body>
</html>

