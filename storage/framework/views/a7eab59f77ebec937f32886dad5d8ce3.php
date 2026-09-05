<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($faviconSetting->app_name ?? 'E-Pilketos'); ?> | Pemilihan Cerdas</title>
    <?php $faviconSetting = \App\Models\Setting::getCached(); ?>
    <?php if($faviconSetting): ?>
        <?php if($faviconSetting->osim_logo): ?>
            <link rel="icon" href="<?php echo e(asset($faviconSetting->osim_logo)); ?>" type="image/png">
        <?php endif; ?>
        <?php if($faviconSetting->seo_title || $faviconSetting->seo_description): ?>
            <meta name="description" content="<?php echo e($faviconSetting->seo_description ?? 'Aplikasi Pemilihan'); ?>">
            <meta property="og:title" content="<?php echo e($faviconSetting->seo_title ?? ($faviconSetting->app_name ?? 'E-Pilketos')); ?>">
            <meta property="og:description" content="<?php echo e($faviconSetting->seo_description ?? 'Aplikasi Pemilihan'); ?>">
            <?php if($faviconSetting->seo_image): ?>
                <meta property="og:image" content="<?php echo e(url($faviconSetting->seo_image)); ?>">
            <?php endif; ?>
            <meta property="og:type" content="website">
        <?php endif; ?>
    <?php endif; ?>
    <link href="<?php echo e(asset('Assets/vendor/inter.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('Assets/vendor/font-awesome.min.css')); ?>">
    <script src="<?php echo e(asset('Assets/vendor/sweetalert2.min.js')); ?>"></script>
    <?php if(isset($faviconSetting) && is_array($faviconSetting->dynamic_color_tags)): ?>
    <style>
        <?php $__currentLoopData = $faviconSetting->dynamic_color_tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tagData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(!empty($tagData['tag'])): ?>
            .<?php echo e($tagData['tag']); ?> { 
                <?php if(!empty($tagData['is_gradient'])): ?>
                background: linear-gradient(135deg, <?php echo e($tagData['bg_color'] ?? 'transparent'); ?>, <?php echo e($tagData['bg_color_2'] ?? $tagData['bg_color'] ?? 'transparent'); ?>) !important; 
                <?php else: ?>
                background: <?php echo e($tagData['bg_color'] ?? 'transparent'); ?> !important; 
                <?php endif; ?>
                color: <?php echo e($tagData['text_color'] ?? 'inherit'); ?> !important; 
            }
            .text-<?php echo e($tagData['tag']); ?> { color: <?php echo e($tagData['text_color'] ?? 'inherit'); ?> !important; }
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </style>
    <?php endif; ?>
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
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 70px; /* added for fixed navbar */
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
            margin-bottom: 0.75rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-main);
        }

        input[type="text"],
        input[type="password"],
        input[type="number"],
        input[type="email"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 0.5rem 0;
            border: none;
            border-bottom: 2px solid var(--border);
            border-radius: 0;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: transparent;
            box-shadow: none;
            color: var(--text-main);
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-bottom-color: var(--primary);
            box-shadow: none;
            background-color: transparent;
        }

        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239CA3AF%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
            background-repeat: no-repeat;
            background-position: right 0 top 50%;
            background-size: 0.65rem auto;
            padding-right: 1.5rem;
        }

        label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 0.25rem;
            display: block;
        }

        /* Minimalist Modal Fields */
        .modal .card {
            padding: 1.25rem !important;
        }

        .modal h3 {
            margin-bottom: 0.75rem !important;
            font-size: 1.1rem;
        }

        .modal .form-group {
            margin-bottom: 0.75rem !important;
        }
        .modal input[type="text"],
        .modal input[type="password"],
        .modal input[type="number"],
        .modal input[type="file"],
        .modal select,
        .modal textarea {
            width: 100% !important;
            padding: 0.5rem 0 !important;
            border: none !important;
            border-bottom: 2px solid var(--border) !important;
            border-radius: 0 !important;
            font-size: 0.95rem !important;
            transition: all 0.3s ease !important;
            background-color: transparent !important;
            box-shadow: none !important;
            color: var(--text-main);
        }

        .modal input:focus,
        .modal select:focus,
        .modal textarea:focus {
            outline: none !important;
            border-bottom-color: var(--primary) !important;
            box-shadow: none !important;
            background-color: transparent !important;
        }

        .modal select {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%239CA3AF%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 0 top 50% !important;
            background-size: 0.65rem auto !important;
            padding-right: 1.5rem !important;
        }

        .modal label {
            font-size: 0.75rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            color: var(--text-muted) !important;
            font-weight: 600 !important;
            margin-bottom: 0.25rem !important;
            display: block !important;
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
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1000;
            transition: transform 0.3s ease-in-out;
        }
        
        .navbar.nav-hidden {
            transform: translateY(-100%);
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
            font-size: 0.9rem;
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
            font-size: 0.9rem;
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

        .page-container {
            display: flex;
            gap: 2rem;
            align-items: flex-start;
        }

        .page-sidebar {
            width: 280px;
            flex-shrink: 0;
            background: var(--surface);
            border-radius: var(--radius);
            padding: 1rem;
            box-shadow: var(--shadow);
        }

        .page-content {
            flex: 1;
            background: var(--surface);
            border-radius: var(--radius);
            padding: 2.5rem;
            box-shadow: var(--shadow);
            overflow-x: auto;
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
                padding: 1rem 0;
                border-top: 1px solid var(--border);
                margin-top: 0.5rem;
            }
            .topbar-menu.show {
                display: flex !important;
            }
            .nav-link {
                width: 100%;
            }
            .dropdown {
                width: 100%;
            }
            .dropdown-content {
                position: static;
                box-shadow: none;
                border: none;
                padding-left: 1rem;
                background: rgba(0,0,0,0.02);
            }
            
            .page-container {
                flex-direction: column;
            }
            .page-sidebar {
                width: 100%;
                display: flex;
                flex-direction: column;
                padding: 1rem;
            }
            .page-content {
                width: 100%;
                padding: 1rem;
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
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <?php if(!isset($hideNavbar)): ?>
    <nav class="navbar">
        <a href="<?php echo e(auth('admin')->check() ? route('admin.dashboard') : '#'); ?>" class="navbar-brand">
            <i class="fa-solid fa-check-to-slot"></i> <?php echo e($faviconSetting->app_name ?? 'E-Pilketos'); ?>

        </a>
        
        <?php if(auth('admin')->check()): ?>
        <div class="topbar-menu" id="mobile-menu" style="display: flex; gap: 0.5rem; align-items: center;">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
            
            <?php if(auth('admin')->user()->role !== 'pembina'): ?>
                <div class="dropdown">
                    <a href="#" class="nav-link <?php echo e(request()->routeIs('admin.voters') || request()->routeIs('admin.teachers') ? 'active' : ''); ?>" onclick="event.preventDefault(); this.parentElement.classList.toggle('open');"><i class="fa-solid fa-users"></i> Pemilih <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; margin-left: 2px;"></i></a>
                    <div class="dropdown-content">
                        <a href="<?php echo e(route('admin.voters')); ?>"><i class="fa-solid fa-user-graduate" style="width: 20px;"></i> Siswa</a>
                        <a href="<?php echo e(route('admin.teachers')); ?>"><i class="fa-solid fa-chalkboard-user" style="width: 20px;"></i> Guru</a>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.candidates')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.candidates') ? 'active' : ''); ?>"><i class="fa-solid fa-user-tie"></i> Kandidat</a>
            <?php endif; ?>
            
            <?php if(auth('admin')->user()->role === 'admin'): ?>
                <a href="<?php echo e(route('admin.settings')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.settings') ? 'active' : ''); ?>"><i class="fa-solid fa-gear"></i> Pengaturan</a>
                <a href="<?php echo e(route('admin.users')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.users') ? 'active' : ''); ?>"><i class="fa-solid fa-user-shield"></i> Petugas</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <?php if(session('voter_id')): ?>
                <form action="<?php echo e(route('voter.logout')); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;"><i class="fa-solid fa-right-from-bracket"></i> Keluar</button>
                </form>
            <?php elseif(auth('admin')->check()): ?>
                <div class="dropdown">
                    <button class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;" onclick="this.parentElement.classList.toggle('open');">
                        <i class="fa-solid fa-circle-user"></i> <?php echo e(ucfirst(auth('admin')->user()->username)); ?> <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem;"></i>
                    </button>
                    <div class="dropdown-content dropdown-right">
                        <?php if(auth('admin')->user()->role === 'admin'): ?>
                            <a href="#" onclick="showChangePasswordModal()"><i class="fa-solid fa-key" style="width: 20px;"></i> Ganti Password</a>
                        <?php endif; ?>
                        <form action="<?php echo e(route('admin.logout')); ?>" method="POST" style="margin: 0; padding: 0;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 0.75rem 1rem; cursor: pointer; color: #EF4444; font-size: 1rem;"><i class="fa-solid fa-right-from-bracket" style="width: 20px;"></i> Keluar</button>
                        </form>
                    </div>
                </div>
                
                <button class="hamburger-btn" onclick="document.getElementById('mobile-menu').classList.toggle('show')">
                    <i class="fa-solid fa-bars"></i>
                </button>
            <?php endif; ?>
        </div>
    </nav>
    <?php endif; ?>

    <div class="container">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <?php if(!request()->routeIs('kiosk')): ?>
    <footer style="text-align: center; padding: 1.5rem; color: var(--text-muted); font-size: 0.85rem; margin-top: auto;">
        &copy; <?php echo e(date('Y')); ?> <?php echo e($faviconSetting->app_name ?? 'E-Pilketos'); ?>. Dikembangkan oleh <strong>idath Studio</strong>.
    </footer>
    <?php endif; ?>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: <?php echo e(session('timer', 3000)); ?>,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        <?php if(session('success')): ?>
            Toast.fire({
                icon: 'success',
                title: '<?php echo e(session("success")); ?>'
            });
        <?php endif; ?>

        <?php if(session('error')): ?>
            Toast.fire({
                icon: 'error',
                title: '<?php echo e(session("error")); ?>'
            });
        <?php endif; ?>

        <?php if($errors->any()): ?>
            Toast.fire({
                icon: 'error',
                title: '<?php echo e($errors->first()); ?>'
            });
        <?php endif; ?>

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
                    form.action = '<?php echo e(route("admin.password.update")); ?>';
                    
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '<?php echo e(csrf_token()); ?>';
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

        // Smart Sticky Header Logic
        let lastScrollTop = 0;
        const mainNavbar = document.querySelector('.navbar');
        
        window.addEventListener('scroll', function() {
            if (!mainNavbar) return;
            
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // 60 is approx the height of the navbar
            if (scrollTop > lastScrollTop && scrollTop > 60) {
                // Scroll Down
                mainNavbar.classList.add('nav-hidden');
            } else {
                // Scroll Up
                mainNavbar.classList.remove('nav-hidden');
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        }, { passive: true });
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>

<?php /**PATH D:\1Laravel\pilkasim\resources\views\layouts\app.blade.php ENDPATH**/ ?>