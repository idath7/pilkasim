<?php $__env->startSection('content'); ?>
    <h2 style="margin-top: 0; font-size: 1.25rem;">Persyaratan Server</h2>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Pastikan server Anda memenuhi persyaratan berikut sebelum melanjutkan instalasi.</p>
    
    <ul class="list-group">
        <?php $__currentLoopData = $requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req => $passed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="list-group-item">
                <span><?php echo e($req); ?></span>
                <?php if($passed): ?>
                    <span style="color: var(--success);"><i class="fa-solid fa-check-circle"></i> Memenuhi</span>
                <?php else: ?>
                    <span style="color: var(--danger);"><i class="fa-solid fa-times-circle"></i> Tidak Memenuhi</span>
                <?php endif; ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    
    <h2 style="font-size: 1.25rem; margin-top: 2rem;">Izin Direktori</h2>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Pastikan direktori berikut memiliki izin tulis (writable).</p>
    
    <ul class="list-group">
        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dir => $passed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="list-group-item">
                <span><?php echo e($dir); ?></span>
                <?php if($passed): ?>
                    <span style="color: var(--success);"><i class="fa-solid fa-check-circle"></i> Writable</span>
                <?php else: ?>
                    <span style="color: var(--danger);"><i class="fa-solid fa-times-circle"></i> Not Writable</span>
                <?php endif; ?>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    
    <?php if($allRequirementsMet): ?>
        <div style="text-align: right; margin-top: 2rem;">
            <a href="<?php echo e(route('install.database')); ?>" class="btn btn-primary">Lanjutkan <i class="fa-solid fa-arrow-right" style="margin-left: 0.5rem;"></i></a>
        </div>
    <?php else: ?>
        <div class="alert alert-danger" style="margin-top: 2rem;">
            <i class="fa-solid fa-triangle-exclamation"></i> Harap penuhi semua persyaratan di atas sebelum melanjutkan.
        </div>
        <div style="text-align: right;">
            <a href="<?php echo e(route('install.index')); ?>" class="btn" style="background: #e5e7eb; color: #4b5563;">Muat Ulang</a>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('install.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\1Laravel\pilkasim\resources\views\install\step1.blade.php ENDPATH**/ ?>