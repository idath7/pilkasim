<?php $__env->startSection('styles'); ?>
<style>
    .message-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 100px);
    }
    
    .message-card {
        width: 100%;
        max-width: 500px;
        text-align: center;
    }
    
    .message-icon {
        font-size: 4rem;
        color: var(--secondary);
        margin-bottom: 1.5rem;
    }
    
    .message-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .message-subtitle {
        color: var(--text-muted);
        margin-bottom: 2rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="message-container">
    <div class="card message-card animate-fade-in">
        <i class="fa-solid fa-circle-check message-icon"></i>
        <h1 class="message-title">Terima Kasih, <?php echo e($voter->name); ?>!</h1>
        <p class="message-subtitle">Anda telah menggunakan hak suara Anda dalam pemilihan ini. Suara Anda sangat berarti.</p>
        
        <p id="countdown-text" style="font-weight: 600; color: #d97706; margin-bottom: 1.5rem;">Sistem akan logout otomatis dalam <span id="countdown-number">7</span> detik...</p>
        
        <form action="<?php echo e(route('voter.logout')); ?>" method="POST" id="logout-form">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-secondary">Logout Sekarang</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let seconds = 7;
        const countdownEl = document.getElementById('countdown-number');
        const formEl = document.getElementById('logout-form');
        
        const interval = setInterval(function() {
            seconds--;
            countdownEl.innerText = seconds;
            
            if (seconds <= 0) {
                clearInterval(interval);
                formEl.submit();
            }
        }, 1000);
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\1Laravel\pilkasim\resources\views\voting\already_voted.blade.php ENDPATH**/ ?>