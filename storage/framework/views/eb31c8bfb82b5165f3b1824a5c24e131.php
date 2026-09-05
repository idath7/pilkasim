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
        background-color: <?php echo e($appSetting->theme_color_1 ?? '#2db8a6'); ?>;
        padding: 2rem;
        position: relative;
        z-index: 10;
        box-sizing: border-box;
        overflow: hidden;
        gap: 4rem; /* Jarak antara header kiri dan box kanan */
    }
    
    .kiosk-header {
        display: flex;
        flex-direction: column;
        align-items: flex-start; /* Rata kiri */
        text-align: left;
        max-width: 500px;
        color: #ffffff;
    }

    .kiosk-header img {
        width: 200px;
        height: auto;
        margin-bottom: 1.5rem;
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2));
    }
    
    .header-text h1 {
        margin-bottom: 0.5rem; 
        margin-top: 0; 
        font-size: 2.5rem; /* Lebih besar karena di samping */
        font-weight: 800; 
        text-transform: uppercase; 
        letter-spacing: 1px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .header-text h2 {
        margin-top: 0; 
        font-size: 1.5rem; 
        font-weight: 600; 
        line-height: 1.4;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        opacity: 0.95;
    }

    .header-text h3 {
        font-size: 1.1rem; 
        font-weight: 600; 
        opacity: 0.8; 
        margin-top: 0.5rem; 
        margin-bottom: 0;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.98);
        border-radius: 24px;
        padding: 3rem 2.5rem;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        position: relative;
        text-align: center;
        flex-shrink: 0; /* Mencegah card mengecil */
    }

    /* Mobile Responsiveness */
    @media (max-width: 900px) {
        .login-container {
            flex-direction: column;
            padding: 1.5rem;
            gap: 2rem;
            justify-content: flex-start;
        }
        .kiosk-header {
            align-items: center;
            text-align: center;
            margin-top: 2rem;
        }
        .header-text h1 { font-size: 1.8rem; }
        .header-text h2 { font-size: 1.2rem; }
        .login-card {
            padding: 2.5rem 1.5rem;
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
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
        margin-bottom: 2rem;
    }
    
    .otp-input {
        width: 100% !important;
        max-width: 65px !important;
        margin: 0 auto !important;
        aspect-ratio: 1 !important;
        font-size: 2.75rem !important;
        font-weight: 700 !important;
        text-align: center !important;
        border: 2px solid transparent !important;
        border-radius: 12px !important;
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
        padding: 0.85rem 1rem;
        border-radius: 50px;
        width: 100%;
        font-size: 1.1rem;
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
        margin-bottom: 2rem;
        text-align: left;
    }
    
    .minimal-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 0.25rem;
    }

    .minimal-input-wrapper {
        position: relative;
    }

    .minimal-input {
        width: 100%;
        padding: 0.5rem 0; /* No left padding, text starts at edge */
        font-size: 1.1rem !important;
        font-weight: 600;
        color: #0f172a;
        background-color: transparent; /* Transparan */
        border: none;
        border-bottom: 2px solid #cbd5e1; /* Border-bottom saja */
        border-radius: 0;
        outline: none;
        transition: border-color 0.3s;
        box-sizing: border-box;
    }

    .minimal-input::placeholder {
        color: #cbd5e1;
        font-weight: 400;
    }

    .minimal-input:focus {
        border-bottom-color: <?php echo e($appSetting->theme_color_1 ?? '#2db8a6'); ?>;
        /* Tidak ada bayangan/warna latar saat fokus */
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
            gap: 0.5rem;
        }
        .otp-input {
            max-width: 55px;
            font-size: 2.25rem;
            border-radius: 8px;
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
    <div class="header-section animate-fade-in" style="display: flex; align-items: center; justify-content: center; gap: 2rem; flex-wrap: wrap; z-index: 10;">
        <!-- Logo -->
        <div class="header-logo" style="width: 100px; flex-shrink: 0;">
            <?php if(isset($appSetting) && $appSetting->osim_logo): ?>
                <img src="<?php echo e(asset($appSetting->osim_logo)); ?>" alt="Logo OSIM" style="width: 100%; height: auto; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <?php else: ?>
                <div class="logo-placeholder" style="width: 100px; height: 100px; border-radius: 1rem; padding: 0.5rem; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.1);">
                    <i class="fa-solid fa-shield-halved" style="font-size: 3rem; margin: 0; color: rgba(255,255,255,0.8);"></i>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Titles -->
        <div class="header-text" style="text-align: left; color: #ffffff; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">
            <h1 style="margin-bottom: 0.25rem; margin-top: 0; font-size: 1.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;"><?php echo e($appSetting->header_title ?? 'LOGIN HAK PILIH'); ?></h1>
            <h2 style="margin-top: 0; font-size: 1.2rem; font-weight: 600; line-height: 1.3;"><?php echo e($appSetting->election_title ?? 'Pemilihan Ketua OSIS'); ?><br><?php echo e($appSetting->school_name ?? 'Nama Madrasah Belum Diatur'); ?></h2>
            <?php if(!empty($appSetting->period)): ?>
                <h3 style="font-size: 1rem; font-weight: 600; opacity: 0.9; margin-top: 0.25rem; margin-bottom: 0;">Periode <?php echo e($appSetting->period); ?></h3>
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
                        <input type="password" id="passwordInput" name="password" class="minimal-input" placeholder="Password Anda" style="padding-right: 2.5rem;" required>
                        <button type="button" id="togglePassword" aria-label="Tampilkan Password" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; font-size: 1.1rem; cursor: pointer; padding: 0.5rem; transition: color 0.3s;">
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

<?php echo $__env->make('layouts.app', ['hideNavbar' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\1Laravel\pilkasim\resources\views\auth\voter_login.blade.php ENDPATH**/ ?>