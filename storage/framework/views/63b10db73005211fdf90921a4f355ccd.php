<?php $__env->startSection('styles'); ?>
<style>
    .header-section {
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .header-section h1 {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }
    
    .candidates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }
    
    .candidate-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        text-align: center;
    }
    
    .candidate-photo {
        width: 100%;
        height: 320px;
        object-fit: cover;
        object-position: top center;
        border-radius: var(--radius) var(--radius) 0 0;
        margin-bottom: 1rem;
        background-color: #E5E7EB;
    }
    
    .candidate-info {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .candidate-name {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .candidate-class {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .candidate-details {
        text-align: left;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        color: var(--text-muted);
    }
    
    .vote-btn {
        margin-top: auto;
        width: 100%;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="header-section animate-fade-in">
    <h1>Pemilihan Kandidat</h1>
    <p>Halo, <strong><?php echo e($voter->name); ?></strong>. Silakan pilih kandidat terbaik menurut Anda.</p>
</div>

<div class="candidates-grid">
    <?php $__currentLoopData = $candidates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $candidate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card candidate-card animate-fade-in" style="padding: 0; animation-delay: <?php echo e($loop->index * 0.1); ?>s">
            <?php
                // Fix legacy image path
                $photoPath = str_replace('../Assets', '/Assets', $candidate->photo);
            ?>
            <img src="<?php echo e($photoPath); ?>" alt="<?php echo e($candidate->name); ?>" class="candidate-photo" onerror="this.src='<?php echo e(asset('Assets/images/default-avatar.svg')); ?>'">
            
            <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column;">
                <div class="candidate-info">
                    <h2 class="candidate-name"><?php echo e($candidate->name); ?></h2>
                    <div class="candidate-class"><?php echo e($candidate->class_name); ?> | <?php echo e($candidate->organization); ?></div>
                    
                    <div class="candidate-details">
                        <strong>Visi:</strong>
                        <div><?php echo $candidate->vision; ?></div>
                        <br>
                        <strong>Misi:</strong>
                        <div><?php echo $candidate->mission; ?></div>
                    </div>
                </div>
                
                <form action="<?php echo e(route('voting.vote', $candidate->id)); ?>" method="POST" class="vote-form">
                    <?php echo csrf_field(); ?>
                    <button type="button" class="btn vote-btn" onclick="confirmVote(this)">PILIH KANDIDAT INI</button>
                </form>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function confirmVote(btn) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengubah pilihan setelah konfirmasi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4F46E5',
            cancelButtonColor: '#EF4444',
            confirmButtonText: 'Ya, Pilih!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                btn.closest('form').submit();
            }
        })
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\1Laravel\pilkasim\resources\views\voting\index.blade.php ENDPATH**/ ?>