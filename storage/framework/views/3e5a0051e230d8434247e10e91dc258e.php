<?php $__env->startSection('styles'); ?>
<style>
    body {
        background: linear-gradient(135deg, #1e6e3c 0%, #2f8e52 100%);
        <?php if(isset($appSetting) && $appSetting->use_gradient): ?>
            background: linear-gradient(135deg, <?php echo e($appSetting->theme_color_1 ?? '#2db8a6'); ?> 0%, <?php echo e($appSetting->theme_color_2 ?? '#1b9282'); ?> 100%);
        <?php else: ?>
            background-color: <?php echo e($appSetting->theme_color_1 ?? '#2db8a6'); ?>;
        <?php endif; ?>
        margin: 0;
        padding-top: 0 !important;
        height: 100vh;
        overflow: hidden;
    }

    /* Override global layouts.app styles that cause gaps */
    .container {
        padding: 0 !important;
        max-width: 100% !important;
    }

    footer {
        display: none !important;
    }

    .login-container {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        width: 100%;
        <?php if(isset($appSetting) && $appSetting->use_gradient): ?>
            background: linear-gradient(135deg, <?php echo e($appSetting->theme_color_1 ?? '#2db8a6'); ?> 0%, <?php echo e($appSetting->theme_color_2 ?? '#1b9282'); ?> 100%);
        <?php else: ?>
            background-color: <?php echo e($appSetting->theme_color_1 ?? '#2db8a6'); ?>;
        <?php endif; ?>
        padding: 2rem;
        position: relative;
        z-index: 10;
        box-sizing: border-box;
        overflow-x: hidden; /* Ganti dari hidden agar bisa di-scroll secara vertikal (atas-bawah) */
        overflow-y: auto;
        gap: 4rem; /* Jarak antara header kiri dan box kanan */
    }
    
    .header-section {
        display: flex; 
        flex-direction: column; /* Ubah ke column untuk susunan default dari Kiosk */
        align-items: flex-start;
        text-align: left;
        max-width: 500px;
        z-index: 10;
        gap: 1.5rem;
    }

    .header-logo {
        width: 180px;
        flex-shrink: 0;
        max-width: 100%;
    }

    .header-text {
        color: #ffffff; 
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .header-text h1 {
        margin-bottom: 0.25rem; 
        margin-top: 0; 
        font-size: 1.8rem; /* Agak dikecilkan dari 2.2rem */
        font-weight: 800; 
        text-transform: uppercase; 
        letter-spacing: 1px;
    }

    .header-text h2 {
        margin-top: 0; 
        margin-bottom: 0; 
        font-size: 1.3rem; 
        font-weight: 600; 
        line-height: 1.2; /* Dirapatkan */
    }

    .header-text h3 {
        font-size: 1.1rem; 
        font-weight: 600; 
        opacity: 0.9; 
        margin-top: 0; 
        margin-bottom: 0;
        line-height: 1.2; /* Dirapatkan */
    }

    .login-card {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 24px;
        padding: 2.5rem 2rem; /* Padding dikurangi */
        width: 100%;
        max-width: 380px; /* Lebar maksimal dikurangi */
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        position: relative;
        text-align: center;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Mobile Responsiveness */
    @media (max-width: 900px) {
        .login-container {
            flex-direction: column;
            padding: 2rem 1rem; /* Kurangi padding samping */
            padding-top: 5.5rem; /* Diturunkan lebih jauh dari atas layar */
            gap: 1.5rem; /* Dekatkan antara header dan form */
            justify-content: flex-start; /* Tarik semua konten ke ATAS */
        }
        .header-section {
            flex-direction: row; /* Logo dan teks sejajar (kiri-kanan) di HP */
            align-items: center;
            text-align: left; /* Teks rata kiri karena logo ada di kirinya */
            max-width: 100%;
            gap: 1rem;
        }
        .header-logo {
            width: 115px; /* Logo dibesarkan kembali sesuai permintaan */
        }
        .header-text h1 { font-size: 1.3rem; }
        .header-text h2 { font-size: 1rem; }
        
        .login-card {
            padding: 2.5rem 1.5rem;
            min-height: auto; /* Cabut min-height di HP agar tidak terlalu panjang */
        }
    }
    
    .back-btn {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #111827;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .back-btn:hover {
        background-color: #f3f4f6;
    }

    .refresh-btn {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #111827;
        text-decoration: none;
        transition: all 0.2s;
        cursor: pointer;
        background: none;
    }
    
    .refresh-btn:hover {
        background-color: #f3f4f6;
    }

    .login-icon {
        font-size: 3.5rem;
        color: <?php echo e($appSetting->theme_color_3 ?? '#f59e0b'); ?>;
        margin-bottom: 0.5rem;
        margin-top: 1rem;
    }

    .login-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #111827;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .login-subtitle {
        color: #6b7280;
        margin-bottom: 2rem;
        font-size: 0.95rem;
        padding: 0 1rem;
    }
    
    .otp-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* Kembali ke 4 kolom agar kotak bisa membesar */
        gap: 0.8rem;
        margin-bottom: 2rem;
        width: 100%;
        justify-content: center;
    }
    
    .otp-input {
        width: 100% !important;
        max-width: 55px !important; /* Diperbesar */
        margin: 0 auto !important;
        aspect-ratio: 1 !important;
        font-size: 2rem !important; /* Teks diperbesar */
        font-weight: 700 !important;
        text-align: center !important;
        border: 2px solid transparent !important;
        border-radius: 10px !important; /* Lengkungan sedikit ditambah */
        background-color: #f3f4f6 !important;
        color: #111827 !important;
        transition: all 0.2s !important;
        text-transform: uppercase !important;
        padding: 0 !important;
    }
    
    .otp-input:focus {
        outline: none !important;
        background-color: #ffffff !important;
        border-color: <?php echo e($appSetting->theme_color_1 ?? '#2db8a6'); ?> !important;
        box-shadow: 0 0 0 4px rgba(45, 184, 166, 0.1) !important;
    }
    
    .resend-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 1.5rem;
    }
    
    .resend-link {
        color: #f59e0b;
        text-decoration: none;
        font-weight: 600;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, <?php echo e($appSetting->theme_color_1 ?? '#2db8a6'); ?>, <?php echo e($appSetting->theme_color_2 ?? '#1c8c7d'); ?>);
        color: #ffffff;
        border: none;
        padding: 0.65rem 1rem;
        border-radius: 50px;
        width: 100%;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    
    .btn-submit:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
    
    .minimal-group {
        text-align: center; /* Diubah ke tengah */
        margin-bottom: 1.5rem;
    }

    .minimal-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .minimal-input-wrapper {
        position: relative;
    }

    .minimal-input {
        width: 100%;
        padding: 0.75rem 1.5rem; /* Tambah padding agar tidak nabrak lengkungan */
        font-size: 1.1rem !important;
        font-weight: 600;
        color: #0f172a;
        background-color: #f8fafc !important; /* Latar belakang cerah */
        border: 2px solid #cbd5e1 !important; /* Border keliling */
        border-radius: 9999px !important; /* Lengkungan penuh (pill) dipaksa mutlak */
        outline: none;
        transition: all 0.3s;
        box-sizing: border-box;
        text-align: center;
    }

    .minimal-input:focus {
        border-color: <?php echo e($appSetting->theme_color_1 ?? '#2db8a6'); ?> !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 4px rgba(45, 184, 166, 0.1) !important;
    }

    .minimal-input::placeholder {
        color: #94a3b8;
        font-weight: 400 !important; /* Jangan tebal */
    }
    
    .form-input {
        width: 100%;
        border: none;
        background: transparent;
        font-size: 18px !important;
        font-weight: 600;
        color: #0f172a;
        padding: 0.25rem 0;
        outline: none;
        box-sizing: border-box;
    }
    
    .form-input::placeholder {
        color: #cbd5e1;
        font-weight: 500;
    }
    
    .input-action-btn {
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 1.15rem;
        cursor: pointer;
        padding: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.3s ease;
    }
    
    .input-action-btn:hover {
        color: <?php echo e($appSetting->theme_color_1 ?? '#2db8a6'); ?>;
    }
    
    /* Responsive Adjustments for Mobile */
    @media (max-width: 480px) {
        .login-card {
            padding: 2rem 1rem;
        }
        .login-title {
            font-size: 1.5rem;
        }
        .otp-container {
            gap: 0.6rem; /* Jarak disesuaikan */
            margin-bottom: 1.5rem;
        }
        .otp-input {
            max-width: 48px !important; /* Dikecilkan sedikit agar pas */
            font-size: 1.75rem !important; /* Huruf disesuaikan */
            border-radius: 8px !important;
        }
        .login-icon {
            font-size: 2.5rem;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-container">
    <!-- Top Section: Logo and Titles (Like Kiosk) -->
    <div class="header-section animate-fade-in">
        <!-- Logo -->
        <div class="header-logo">
            <?php if(isset($appSetting) && $appSetting->osim_logo): ?>
                <img src="<?php echo e(asset($appSetting->osim_logo)); ?>" alt="Logo OSIM" style="width: 100%; height: auto; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <?php else: ?>
                <div class="logo-placeholder" style="width: 100%; height: auto; aspect-ratio: 1/1; border-radius: 1rem; padding: 0.5rem; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.1);">
                    <i class="fa-solid fa-shield-halved" style="font-size: 5rem; margin: 0; color: rgba(255,255,255,0.8);"></i>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Titles -->
        <div class="header-text">
            <h1><?php echo e($appSetting->header_title ?? 'LOGIN HAK PILIH'); ?></h1>
            <h2><?php echo e($appSetting->election_title ?? 'Pemilihan Ketua OSIS'); ?><br><?php echo e($appSetting->school_name ?? 'Nama Madrasah Belum Diatur'); ?></h2>
            <?php if(!empty($appSetting->period)): ?>
                <h3>Periode <?php echo e($appSetting->period); ?></h3>
            <?php endif; ?>
        </div>
    </div>

    <div class="login-card animate-fade-in tag-login-pemilih">
        <!-- Optional Back Button -->
        <a href="#" class="back-btn" onclick="history.back(); return false;">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        
        <!-- Refresh Button -->
        <a href="javascript:void(0)" class="refresh-btn" onclick="window.location.reload();">
            <i class="fa-solid fa-rotate-right"></i>
        </a>
        <?php
            $loginMethod = $appSetting->login_method ?? 'access_code';
        ?>

        <!-- Vote Icon -->
        <div style="margin-bottom: 1.5rem; color: <?php echo e($appSetting->theme_color_1 ?? '#2db8a6'); ?>;">
            <i class="fa-solid fa-check-to-slot" style="font-size: 3.5rem; filter: drop-shadow(0 4px 6px rgba(45, 184, 166, 0.2));"></i>
        </div>

        <?php if($loginMethod === 'username_password'): ?>
            <p class="login-subtitle">Masukkan Username dan Password Anda.</p>
            
            <form action="<?php echo e(route('voter.login')); ?>" method="POST" id="loginFormUserPass">
                <?php echo csrf_field(); ?>
                
                <div class="minimal-group">
                    <label class="minimal-label">Username</label>
                    <div class="minimal-input-wrapper">
                        <input type="text" name="username" class="minimal-input" placeholder="NIS atau Username" required autofocus>
                    </div>
                </div>
                
                <div class="minimal-group" style="margin-bottom: 2.5rem;">
                    <label class="minimal-label">Password</label>
                    <div class="minimal-input-wrapper">
                        <input type="password" id="passwordInput" name="password" class="minimal-input" placeholder="Password Anda" style="padding-left: 3rem; padding-right: 3rem;" required>
                        <button type="button" id="togglePassword" aria-label="Tampilkan Password" style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; font-size: 1.1rem; cursor: pointer; padding: 0.5rem; transition: color 0.3s;">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit tag-akses-kode">Masuk</button>
            </form>
        <?php else: ?>
            <p class="login-subtitle">Masukkan kode verifikasi unik yang diberikan oleh panitia pemilihan.</p>
            
            <form action="<?php echo e(route('voter.login')); ?>" method="POST" id="loginForm">
                <?php echo csrf_field(); ?>
                
                <input type="hidden" name="access_code" id="accessCodeHidden">
                
                <div class="otp-container">
                    <input type="text" class="otp-input" maxlength="1" autocomplete="off" autofocus>
                    <input type="text" class="otp-input" maxlength="1" autocomplete="off">
                    <input type="text" class="otp-input" maxlength="1" autocomplete="off">
                    <input type="text" class="otp-input" maxlength="1" autocomplete="off">
                    
                    <input type="text" class="otp-input" maxlength="1" autocomplete="off">
                    <input type="text" class="otp-input" maxlength="1" autocomplete="off">
                    <input type="text" class="otp-input" maxlength="1" autocomplete="off">
                    <input type="text" class="otp-input" maxlength="1" autocomplete="off">
                </div>
                
                <p class="resend-text">Kesulitan login? <a href="#" class="resend-link tag-logo-icon">Hubungi Panitia</a></p>
                
                <button type="submit" class="btn-submit tag-akses-kode" id="btnSubmitOTP" disabled>Verifikasi & Masuk</button>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputs = document.querySelectorAll('.otp-input');
        const hiddenInput = document.getElementById('accessCodeHidden');
        const form = document.getElementById('loginForm');

        inputs.forEach((input, index) => {
            // Strict sequential typing: prevent focusing on an input if previous ones are empty
            input.addEventListener('focus', (e) => {
                let firstEmptyIndex = -1;
                for (let i = 0; i < inputs.length; i++) {
                    if (inputs[i].value === '') {
                        firstEmptyIndex = i;
                        break;
                    }
                }
                
                // Redirect focus if trying to skip
                if (firstEmptyIndex !== -1 && index > firstEmptyIndex) {
                    inputs[firstEmptyIndex].focus();
                }
            });

            // Move to next input on typing
            input.addEventListener('input', (e) => {
                // Ensure only uppercase
                e.target.value = e.target.value.toUpperCase();
                
                if (e.target.value.length === 1) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
                updateHiddenInput();
            });

            // Move to previous input on backspace
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && e.target.value === '') {
                    if (index > 0) {
                        inputs[index - 1].focus();
                    }
                }
            });
            
            // Handle pasting the full code
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').toUpperCase().trim();
                
                if (pastedData.length > 0) {
                    for (let i = 0; i < inputs.length; i++) {
                        if (i < pastedData.length) {
                            inputs[i].value = pastedData[i];
                        }
                    }
                    updateHiddenInput();
                    
                    // Focus on the last filled input or the very last input
                    const focusIndex = Math.min(pastedData.length, inputs.length) - 1;
                    inputs[focusIndex].focus();
                }
            });
        });

        function updateHiddenInput() {
            if (!hiddenInput) return;
            let code = '';
            let allFilled = true;
            inputs.forEach(input => {
                code += input.value;
                if (input.value === '') {
                    allFilled = false;
                }
            });
            hiddenInput.value = code;

            const btnSubmit = document.getElementById('btnSubmitOTP');
            if (btnSubmit) {
                if (allFilled && code.length === 8) {
                    btnSubmit.removeAttribute('disabled');
                } else {
                    btnSubmit.setAttribute('disabled', 'disabled');
                }
            }
        }

        if (form) {
            form.addEventListener('submit', function(e) {
                updateHiddenInput();
                if (hiddenInput.value.length < 8) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Kode Tidak Lengkap',
                        text: 'Silakan masukkan 8 digit kode akses Anda.'
                    });
                }
            });
        }
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                const icon = this.querySelector('i');
                if (type === 'password') {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['hideNavbar' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\1Laravel\pilkasim\resources\views/auth/voter_login.blade.php ENDPATH**/ ?>