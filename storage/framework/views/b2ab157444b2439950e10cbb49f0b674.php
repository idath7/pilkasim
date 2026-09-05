<?php $__env->startSection('content'); ?>
    <div style="text-align: center; padding: 2rem 0;">
        <div style="width: 80px; height: 80px; background: var(--success); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 1.5rem auto; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);">
            <i class="fa-solid fa-check"></i>
        </div>
        
        <h2 style="margin-top: 0; font-size: 1.5rem; color: var(--text-main);">Instalasi Selesai!</h2>
        <p style="color: var(--text-muted); font-size: 1rem; margin-bottom: 2rem; max-width: 400px; margin-left: auto; margin-right: auto;">Aplikasi E-Pilketos telah berhasil dipasang di server Anda. Sistem sekarang siap digunakan.</p>
        
        <div style="background: #f8fafc; border: 1px dashed var(--border); padding: 1.5rem; border-radius: 8px; max-width: 400px; margin: 0 auto 2rem auto; text-align: left;">
            <p style="margin: 0 0 0.5rem 0; font-size: 0.9rem; color: var(--text-muted);">Silakan login ke panel admin menggunakan:</p>
            <div style="font-weight: 600; font-size: 1rem; color: var(--text-main);">
                <i class="fa-solid fa-user-shield" style="width: 24px; color: var(--primary);"></i> Username yang baru dibuat<br>
                <i class="fa-solid fa-key" style="width: 24px; color: var(--primary); margin-top: 0.5rem;"></i> Password yang baru dibuat
            </div>
        </div>
        
        <a href="<?php echo e(route('admin.login')); ?>" class="btn btn-primary" style="width: auto; padding-left: 2.5rem; padding-right: 2.5rem; font-size: 1.1rem; border-radius: 100px;">
            Masuk ke Dashboard <i class="fa-solid fa-arrow-right" style="margin-left: 0.5rem;"></i>
        </a>
        
        <div style="margin-top: 1.5rem; font-size: 0.8rem; color: var(--text-muted);">
            <i class="fa-solid fa-shield-halved"></i> Demi keamanan, akses ke halaman instalasi ini telah diblokir secara otomatis.
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('install.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\1Laravel\pilkasim\resources\views\install\complete.blade.php ENDPATH**/ ?>