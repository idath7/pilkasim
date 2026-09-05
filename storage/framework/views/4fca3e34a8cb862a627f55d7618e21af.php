<?php $__env->startSection('styles'); ?>
<style>
    body {
        margin: 0;
        background-color: #f3f4f6;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .login-header {
        background: linear-gradient(135deg, #1e6e3c 0%, #2f8e52 100%);
        padding: 4rem 1rem 8rem 1rem;
        text-align: center;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .header-icon {
        width: 80px;
        height: 80px;
        background-color: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem auto;
        backdrop-filter: blur(4px);
    }

    .header-icon i {
        font-size: 2.5rem;
        color: #f59e0b;
    }

    .login-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .login-subtitle {
        font-size: 0.9rem;
        opacity: 0.9;
        max-width: 300px;
        margin: 0 auto;
    }

    .login-card-container {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 0 1.5rem;
        margin-top: -5rem;
        margin-bottom: 2rem;
    }

    .login-card {
        background: white;
        border-radius: 20px;
        width: 100%;
        max-width: 400px;
        padding: 2.5rem 2rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
    }

    .form-group-custom {
        margin-bottom: 1.5rem;
        text-align: left;
    }

    .form-group-custom label {
        display: block;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #6b7280;
    }

    .input-wrapper {
        position: relative;
    }

    .input-custom {
        width: 100%;
        background-color: transparent;
        border: none;
        border-bottom: 2px solid #e5e7eb;
        padding: 0.75rem 0;
        border-radius: 0;
        font-size: 0.95rem;
        color: #111827;
        box-sizing: border-box;
        transition: all 0.3s;
    }

    .input-custom:focus {
        outline: none;
        border-bottom-color: #1e6e3c;
        box-shadow: none;
        background-color: transparent;
    }

    .password-toggle {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        cursor: pointer;
        font-size: 1.25rem;
    }

    .forgot-password {
        display: block;
        text-align: right;
        font-size: 0.875rem;
        color: #f59e0b;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 2rem;
    }

    .btn-signin {
        background-color: #1e6e3c;
        color: white;
        width: 100%;
        padding: 1rem;
        border-radius: 100px;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-signin:hover {
        background-color: #15552d;
    }

    .back-btn {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        color: white;
        font-size: 1.25rem;
        text-decoration: none;
        z-index: 10;
    }
    
    /* Desktop adjustments */
    @media (min-width: 768px) {
        .login-wrapper {
            flex-direction: row;
        }
        
        .login-header {
            flex: 1;
            padding: 4rem;
            border-radius: 0 40px 40px 0;
            box-shadow: 10px 0 30px rgba(0,0,0,0.1);
            z-index: 2;
        }
        
        .back-btn {
            top: 2rem;
            left: 2rem;
        }
        
        .login-card-container {
            flex: 1;
            margin-top: 0;
            margin-bottom: 0;
            align-items: center;
            background-color: #f3f4f6;
        }
        
        .login-card {
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            max-width: 450px;
            padding: 3.5rem 3rem;
        }
        
        .login-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .login-subtitle {
            font-size: 1.1rem;
            max-width: 400px;
        }
        
        .header-icon {
            width: 100px;
            height: 100px;
            margin-bottom: 2rem;
        }
        
        .header-icon i {
            font-size: 3rem;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-wrapper animate-fade-in">
    
    <a href="<?php echo e(url('/')); ?>" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>

    <div class="login-header">
        <div class="header-icon">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <h1 class="login-title">Admin Panel</h1>
        <p class="login-subtitle">Hi! Selamat datang kembali, silakan masuk ke akun Anda</p>
    </div>

    <div class="login-card-container">
        <div class="login-card">
            <form action="<?php echo e(route('admin.login')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <div class="form-group-custom">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <input type="text" id="username" name="username" class="input-custom" placeholder="Masukkan username" required autocomplete="off">
                    </div>
                </div>
                
                <div class="form-group-custom">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" class="input-custom" placeholder="••••••••" required>
                        <i class="fa-solid fa-eye-slash password-toggle" id="togglePassword"></i>
                    </div>
                </div>
                
                <a href="#" class="forgot-password" onclick="alert('Silakan hubungi administrator utama untuk mereset password.')">Lupa Password?</a>
                
                <button type="submit" class="btn-signin">Sign In</button>
            </form>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function (e) {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the eye / eye-slash icon
            if (type === 'password') {
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['hideNavbar' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\1Laravel\pilkasim\resources\views\auth\admin_login.blade.php ENDPATH**/ ?>