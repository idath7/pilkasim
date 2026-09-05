@extends('layouts.app', ['hideNavbar' => true])

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #1e6e3c 0%, #2f8e52 100%);
        @if(isset($appSetting) && $appSetting->use_gradient)
            background: linear-gradient(135deg, {{ $appSetting->theme_color_1 ?? '#2db8a6' }} 0%, {{ $appSetting->theme_color_2 ?? '#1b9282' }} 100%);
        @else
            background-color: {{ $appSetting->theme_color_1 ?? '#2db8a6' }};
        @endif
        margin: 0;
        height: 100vh;
        overflow: hidden;
    }

    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 1rem;
    }
    
    .login-card {
        width: 100%;
        max-width: 480px;
        background: #ffffff;
        border-radius: 24px;
        padding: 2.5rem 2rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
        position: relative;
        text-align: center;
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
        color: {{ $appSetting->theme_color_3 ?? '#f59e0b' }};
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
        border-color: {{ $appSetting->theme_color_1 ?? '#2db8a6' }} !important;
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
        width: 100%;
        padding: 1rem;
        @if(isset($appSetting) && $appSetting->use_gradient)
            background: linear-gradient(135deg, {{ $appSetting->theme_color_5 ?? '#f59e0b' }} 0%, {{ $appSetting->theme_color_6 ?? '#d97706' }} 100%);
        @else
            background-color: {{ $appSetting->theme_color_5 ?? '#f59e0b' }};
        @endif
        color: #1e293b;
        border: none;
        border-radius: 100px;
        font-size: 1.1rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .btn-submit:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
    
    .hidden-input {
        display: none;
    }

    .form-group {
        margin-bottom: 1.5rem;
        text-align: left;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.25rem;
        font-weight: 600;
        color: #6b7280;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 0;
        font-size: 1rem;
        border: none;
        border-bottom: 2px solid #e5e7eb;
        border-radius: 0;
        background-color: transparent;
        color: #111827;
        transition: all 0.3s;
        box-sizing: border-box;
    }

    .form-input:focus {
        outline: none;
        background-color: transparent;
        border-bottom-color: {{ $appSetting->theme_color_1 ?? '#2db8a6' }};
        box-shadow: none;
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
@endsection

@section('content')
<div class="login-container">
    <div class="login-card animate-fade-in tag-login-pemilih">
        <!-- Optional Back Button -->
        <a href="#" class="back-btn" onclick="history.back(); return false;">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        
        <!-- Refresh Button -->
        <a href="javascript:void(0)" class="refresh-btn" onclick="window.location.reload();">
            <i class="fa-solid fa-rotate-right"></i>
        </a>
        
        <i class="fa-solid fa-check-to-slot login-icon tag-logo-icon"></i>

        @php
            $loginMethod = $appSetting->login_method ?? 'access_code';
        @endphp

        @if($loginMethod === 'username_password')
            <h1 class="login-title">{{ $appSetting->header_title ?? 'LOGIN HAK PILIH' }}</h1>
            <p class="login-subtitle">Masukkan Username dan Password Anda.</p>
            
            <form action="{{ route('voter.login') }}" method="POST" id="loginFormUserPass">
                @csrf
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-input" required autofocus>
                </div>
                <div class="form-group" style="margin-bottom: 2rem;">
                    <label>Password</label>
                    <input type="password" name="password" class="form-input" required>
                </div>
                
                <button type="submit" class="btn-submit tag-akses-kode">Masuk</button>
            </form>
        @else
            <h1 class="login-title">{{ $appSetting->header_title ?? 'LOGIN HAK PILIH' }}</h1>
            <p class="login-subtitle">Masukkan kode verifikasi unik yang diberikan oleh panitia pemilihan.</p>
            
            <form action="{{ route('voter.login') }}" method="POST" id="loginForm">
                @csrf
                
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
        @endif
    </div>
</div>
@endsection

@section('scripts')
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
    });
</script>
@endsection
