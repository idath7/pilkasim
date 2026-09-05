<?php $__env->startSection('styles'); ?>
<style>
    .container {
        max-width: 100% !important;
        padding: 2rem 3rem !important; /* Adjust padding for fullwidth */
    }

    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
        font-size: 14px; /* Ukuran font 14px sesuai permintaan */
    }
    
    th, td {
        padding: 0.4rem 0.5rem;
        text-align: left;
        border-bottom: 1px solid var(--border);
    }
    
    th {
        background-color: transparent; /* Minimalis */
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.05em;
        border-bottom: 2px solid var(--border);
    }
    
    tr:hover {
        background-color: #F9FAFB;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.65rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    
    .status-voted {
        background: linear-gradient(135deg, #10B981, #059669);
        color: white;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }
    
    .status-pending {
        background: linear-gradient(135deg, #F59E0B, #D97706);
        color: white;
        box-shadow: 0 2px 4px rgba(245, 158, 11, 0.2);
    }
    
    .table-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .action-btn {
        padding: 0.4rem 0.75rem;
        font-size: 0.75rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-weight: 600;
        transition: all 0.2s;
        cursor: pointer;
        text-decoration: none;
    }
    
    .action-btn-edit {
        background-color: rgba(59, 130, 246, 0.1);
        color: #3B82F6;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }
    .action-btn-edit:hover {
        background-color: #3B82F6;
        color: white;
    }
    
    .action-btn-reset {
        background-color: rgba(239, 68, 68, 0.1);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }
    
    .action-btn-reset:hover {
        background-color: #EF4444;
        color: white;
    }
    
    .action-btn-generate {
        background-color: rgba(16, 185, 129, 0.1);
        color: #10B981;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }
    
    .action-btn-generate:hover {
        background-color: #10B981;
        color: white;
    }
    
    .access-code-box {
        font-family: monospace;
        background: #F3F4F6;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .action-dropdown {
        position: relative;
        display: inline-block;
    }

    .action-dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 250px;
        box-shadow: var(--shadow-lg);
        z-index: 10;
        border-radius: var(--radius);
        overflow: hidden;
        right: 0;
        top: 100%;
        margin-top: 0.5rem;
        border: 1px solid var(--border);
    }

    .action-dropdown-content form {
        display: block;
    }

    .action-dropdown-content button {
        color: var(--text-main);
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        width: 100%;
        text-align: left;
        border: none;
        background: none;
        cursor: pointer;
        font-family: inherit;
        font-size: 0.9rem;
        transition: background 0.2s;
    }

    .action-dropdown-content button:hover {
        background-color: #f3f4f6;
    }

    .action-dropdown:hover .action-dropdown-content, .action-dropdown:focus-within .action-dropdown-content {
        display: block;
    }
    
    .action-dropdown:hover .fa-chevron-down {
        transform: rotate(0deg) !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="header-flex animate-fade-in">
    <div>
        <h2 style="margin: 0;">Daftar Pemilih (Siswa)</h2>
        <p style="margin: 0.25rem 0 0 0; color: var(--text-muted);">Kelola data siswa dan kode akses pemilihan</p>
    </div>
    
    <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
        <form method="GET" id="filterForm" style="margin: 0; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <input type="hidden" name="sort" value="<?php echo e($sort); ?>">
            <input type="hidden" name="direction" value="<?php echo e($direction); ?>">
            
            <!-- Search -->
            <div style="position: relative;">
                <i class="fa-solid fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.85rem;"></i>
                <input type="text" name="search" value="<?php echo e($search); ?>" placeholder="Cari nama, NIS, username..." class="form-control" style="padding: 0.4rem 1rem 0.4rem 2.25rem; width: 250px; font-size: 0.85rem; border-radius: 20px; border: 1px solid var(--border);">
            </div>

            <!-- Per Page -->
            <div style="display: flex; align-items: center; gap: 0.5rem; background: #fff; padding: 0.2rem; border-radius: 20px; border: 1px solid var(--border);">
                <label style="margin: 0 0 0 0.5rem; font-size: 0.75rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase;">Tampilkan:</label>
                <select name="per_page" class="form-control" style="width: auto; padding: 0.25rem 1.5rem 0.25rem 0.5rem; min-height: 0; font-size: 0.85rem; border: none; background: transparent; cursor: pointer; font-weight: 500;" onchange="document.getElementById('filterForm').submit()">
                    <option value="10" <?php echo e($perPage == 10 ? 'selected' : ''); ?>>10 Baris</option>
                    <option value="25" <?php echo e($perPage == 25 ? 'selected' : ''); ?>>25 Baris</option>
                    <option value="50" <?php echo e($perPage == 50 ? 'selected' : ''); ?>>50 Baris</option>
                    <option value="100" <?php echo e($perPage == 100 ? 'selected' : ''); ?>>100 Baris</option>
                    <option value="all" <?php echo e($perPage === 'all' ? 'selected' : ''); ?>>Semua</option>
                </select>
            </div>
            
            <button type="submit" style="display: none;"></button>
        </form>
    </div>
</div>

<div class="page-container animate-fade-in" style="animation-delay: 0.1s;">
    <!-- Floating Sidebar Aksi -->
    <div id="floatingActionSidebar" style="position: fixed; top: 50%; left: -300px; transform: translateY(-50%); width: 280px; background: #fff; padding: 1.5rem; border-radius: 0 12px 12px 0; border: 1px solid var(--border); border-left: none; box-shadow: 5px 0 25px rgba(0,0,0,0.1); z-index: 100; transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
        
        <!-- Tab Toggle Vertikal -->
        <div onclick="toggleActionSidebar()" style="position: absolute; right: -40px; top: 50%; transform: translateY(-50%); background: var(--primary); color: white; padding: 1rem 0; width: 40px; height: 160px; border-radius: 0 12px 12px 0; cursor: pointer; writing-mode: vertical-rl; font-weight: 600; font-size: 0.9rem; letter-spacing: 1px; box-shadow: 4px 0 10px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: background 0.2s; user-select: none;">
            <i class="fa-solid fa-chevron-right" id="actionSidebarIcon" style="transition: transform 0.3s; font-size: 0.8rem; margin-bottom: 0.5rem; transform: rotate(0deg);"></i>
            Aksi Pemilih
        </div>
        
        <h3 style="font-size: 1.1rem; margin: 0 0 1.25rem 0; color: var(--text-main); font-weight: 700;"><i class="fa-solid fa-layer-group" style="color: var(--primary); margin-right: 0.5rem;"></i> Menu Aksi</h3>
        
        <div id="actionSidebarContent" style="display: flex; flex-direction: column; gap: 0.75rem;">
            <div class="action-dropdown" style="width: 100%;">
            <button class="btn" style="background-color: transparent; color: var(--text-main); width: 100%; display: flex; justify-content: flex-start; align-items: center; gap: 0.75rem; border-radius: 8px; font-weight: 500; border: 1px solid transparent; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='transparent'"><i class="fa-solid fa-key" style="width: 20px; color: #10B981;"></i> Generate Kode <i class="fa-solid fa-chevron-down" style="margin-left: auto; font-size: 0.7rem; color: var(--text-muted); transition: transform 0.3s; transform: rotate(-90deg);"></i></button>
            <div class="action-dropdown-content" style="width: 100%; top: 100%; margin-top: 0.5rem; border-radius: 8px; border: 1px solid var(--border); box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                <form action="<?php echo e(route('admin.voters.generate_codes')); ?>" method="POST" onsubmit="confirmAction(event, 'Generate kode akses otomatis untuk pemilih yang belum punya?');">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="type" value="student">
                    <button type="submit" style="width: 100%; text-align: left; padding: 0.75rem 1rem; border-bottom: 1px solid var(--border); background: transparent; border-top: none; border-left: none; border-right: none; color: var(--text-main); cursor: pointer; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'"><i class="fa-solid fa-magic" style="width: 20px; color: var(--text-muted);"></i> Generate Kosong</button>
                </form>
                <form action="<?php echo e(route('admin.voters.generate_codes')); ?>" method="POST" onsubmit="confirmAction(event, 'PERINGATAN: Ini akan mereset dan mengganti SEMUA kode akses siswa menjadi baru. Lanjutkan?');">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="type" value="student">
                    <input type="hidden" name="force_all" value="1">
                    <button type="submit" style="width: 100%; text-align: left; color: #DC2626; padding: 0.75rem 1rem; background: transparent; border: none; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#fee2e2'" onmouseout="this.style.backgroundColor='transparent'"><i class="fa-solid fa-rotate" style="width: 20px;"></i> Reset Semua Kode</button>
                </form>
            </div>
        </div>
        
        <button onclick="document.getElementById('addModal').style.display='block'" class="btn" style="background-color: transparent; color: var(--text-main); width: 100%; display: flex; justify-content: flex-start; align-items: center; gap: 0.75rem; border-radius: 8px; font-weight: 500; border: 1px solid transparent; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='transparent'"><i class="fa-solid fa-plus" style="width: 20px; color: var(--primary);"></i> Tambah Siswa</button>
        <button onclick="document.getElementById('importModal').style.display='block'" class="btn" style="background-color: transparent; color: var(--text-main); width: 100%; display: flex; justify-content: flex-start; align-items: center; gap: 0.75rem; border-radius: 8px; font-weight: 500; border: 1px solid transparent; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='transparent'"><i class="fa-solid fa-file-excel" style="width: 20px; color: #10B981;"></i> Import Excel</button>
        <a href="<?php echo e(route('admin.voters.print', ['type' => 'student'])); ?>" target="_blank" class="btn" style="background-color: transparent; color: var(--text-main); width: 100%; display: flex; justify-content: flex-start; align-items: center; gap: 0.75rem; border-radius: 8px; font-weight: 500; border: 1px solid transparent; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#f1f5f9'" onmouseout="this.style.backgroundColor='transparent'"><i class="fa-solid fa-print" style="width: 20px; color: #6366f1;"></i> Cetak Kartu</a>
        
        <hr style="border: none; border-top: 1px dashed var(--border); margin: 0.25rem 0;">
        
        <form action="<?php echo e(route('admin.voters.reset_votes')); ?>" method="POST" onsubmit="confirmAction(event, 'Hasil perolehan suara akan dikosongkan dan status memilih siswa akan direset. Anda yakin?');" style="margin: 0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn" style="background-color: transparent; color: var(--text-main); width: 100%; display: flex; justify-content: flex-start; align-items: center; gap: 0.75rem; border-radius: 8px; font-weight: 500; border: 1px solid transparent; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#fef3c7'; this.style.color='#d97706'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--text-main)'"><i class="fa-solid fa-rotate-left" style="width: 20px; color: #f59e0b;"></i> Reset Suara</button>
        </form>
        <form action="<?php echo e(route('admin.voters.reset_all')); ?>" method="POST" onsubmit="confirmAction(event, 'Peringatan: Seluruh data pemilih akan dihapus dari database! Anda yakin?');" style="margin: 0;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn" style="background-color: transparent; color: var(--text-main); width: 100%; display: flex; justify-content: flex-start; align-items: center; gap: 0.75rem; border-radius: 8px; font-weight: 500; border: 1px solid transparent; transition: all 0.2s;" onmouseover="this.style.backgroundColor='#fee2e2'; this.style.color='#dc2626'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--text-main)'"><i class="fa-solid fa-trash" style="width: 20px; color: #ef4444;"></i> Hapus Semua</button>
        </form>
        </div>
    </div>

    <!-- Konten Tabel -->
    <div class="page-content" style="padding: 1.5rem; overflow-x: auto;">
        <table style="width: 100%; min-width: 800px;">
        <thead>
            <tr id="defaultHeaders">
                <th style="width: 40px; text-align: center;"><input type="checkbox" id="selectAll" onclick="toggleAllCheckboxes(this)"></th>
                <th style="width: 50px;">No</th>
                <th><a href="?search=<?php echo e($search); ?>&per_page=<?php echo e($perPage); ?>&sort=nis&direction=<?php echo e($sort == 'nis' && $direction == 'asc' ? 'desc' : 'asc'); ?>" style="color: inherit; text-decoration: none;">NIS <?php echo $sort == 'nis' ? ($direction == 'asc' ? '↑' : '↓') : ''; ?></a></th>
                <th><a href="?search=<?php echo e($search); ?>&per_page=<?php echo e($perPage); ?>&sort=name&direction=<?php echo e($sort == 'name' && $direction == 'asc' ? 'desc' : 'asc'); ?>" style="color: inherit; text-decoration: none;">Nama Lengkap <?php echo $sort == 'name' ? ($direction == 'asc' ? '↑' : '↓') : ''; ?></a></th>
                <th><a href="?search=<?php echo e($search); ?>&per_page=<?php echo e($perPage); ?>&sort=class_name&direction=<?php echo e($sort == 'class_name' && $direction == 'asc' ? 'desc' : 'asc'); ?>" style="color: inherit; text-decoration: none;">Kelas <?php echo $sort == 'class_name' ? ($direction == 'asc' ? '↑' : '↓') : ''; ?></a></th>
                <th><a href="?search=<?php echo e($search); ?>&per_page=<?php echo e($perPage); ?>&sort=gender&direction=<?php echo e($sort == 'gender' && $direction == 'asc' ? 'desc' : 'asc'); ?>" style="color: inherit; text-decoration: none;">L/P <?php echo $sort == 'gender' ? ($direction == 'asc' ? '↑' : '↓') : ''; ?></a></th>
                <th><a href="?search=<?php echo e($search); ?>&per_page=<?php echo e($perPage); ?>&sort=username&direction=<?php echo e($sort == 'username' && $direction == 'asc' ? 'desc' : 'asc'); ?>" style="color: inherit; text-decoration: none;">Username <?php echo $sort == 'username' ? ($direction == 'asc' ? '↑' : '↓') : ''; ?></a></th>
                <th>Kode Akses</th>
                <th><a href="?search=<?php echo e($search); ?>&per_page=<?php echo e($perPage); ?>&sort=has_voted&direction=<?php echo e($sort == 'has_voted' && $direction == 'asc' ? 'desc' : 'asc'); ?>" style="color: inherit; text-decoration: none;">Status <?php echo $sort == 'has_voted' ? ($direction == 'asc' ? '↑' : '↓') : ''; ?></a></th>
            </tr>
            <tr id="bulkActionHeaders" style="display: none; background-color: #f8fafc; border-bottom: 1px solid var(--border);">
                <th style="width: 40px; text-align: center; border-bottom: none;"><input type="checkbox" id="selectAllAction" onclick="toggleAllCheckboxes(this)" checked></th>
                <th colspan="8" style="padding: 0.4rem 1rem; border-bottom: none;">
                    <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; width: 100%;">
                        <span id="selectedCount" style="font-weight: 600; color: var(--primary); font-size: 0.85rem; margin-right: 0.5rem;">0 Terpilih</span>
                        <div style="height: 18px; width: 1px; background: #cbd5e1; margin-right: 0.5rem;"></div>
                        
                        <button type="button" id="btnEditSelected" style="background: transparent; border: none; color: var(--text-main); display: flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.75rem; border-radius: 6px; font-weight: 500; font-size: 0.85rem; transition: background 0.2s; cursor: pointer;" onmouseover="this.style.backgroundColor='#e2e8f0'" onmouseout="this.style.backgroundColor='transparent'" onclick="editSelectedRow()"><i class="fa-solid fa-pen" style="color: var(--text-muted);"></i> Edit</button>
                        
                        <button type="button" style="background: transparent; border: none; color: var(--text-main); display: flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.75rem; border-radius: 6px; font-weight: 500; font-size: 0.85rem; transition: background 0.2s; cursor: pointer;" onmouseover="this.style.backgroundColor='#e2e8f0'" onmouseout="this.style.backgroundColor='transparent'" onclick="submitBulkAction('<?php echo e(route('admin.voters.bulk_regenerate')); ?>', 'Generate ulang kode akses untuk data yang diceklis?')"><i class="fa-solid fa-key" style="color: var(--text-muted);"></i> Generate Kode</button>
                        
                        <button type="button" style="background: transparent; border: none; color: var(--text-main); display: flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.75rem; border-radius: 6px; font-weight: 500; font-size: 0.85rem; transition: background 0.2s; cursor: pointer;" onmouseover="this.style.backgroundColor='#e2e8f0'" onmouseout="this.style.backgroundColor='transparent'" onclick="submitBulkAction('<?php echo e(route('admin.voters.bulk_reset')); ?>', 'Reset status pemilihan untuk data yang diceklis?')"><i class="fa-solid fa-rotate-left" style="color: var(--text-muted);"></i> Reset Status</button>
                        
                        <button type="button" style="background: transparent; border: none; color: #dc2626; display: flex; align-items: center; gap: 0.4rem; padding: 0.4rem 0.75rem; border-radius: 6px; font-weight: 500; font-size: 0.85rem; transition: background 0.2s; margin-left: auto; cursor: pointer;" onmouseover="this.style.backgroundColor='#fee2e2'" onmouseout="this.style.backgroundColor='transparent'" onclick="submitBulkAction('<?php echo e(route('admin.voters.bulk_destroy')); ?>', 'Hapus permanen data yang diceklis?')"><i class="fa-solid fa-trash"></i> Hapus</button>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $voters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $voter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td style="text-align: center;"><input type="checkbox" class="row-checkbox" value="<?php echo e($voter->id); ?>" data-nis="<?php echo e($voter->nis); ?>" data-name="<?php echo e($voter->name); ?>" data-class="<?php echo e($voter->class_name); ?>" data-gender="<?php echo e($voter->gender); ?>" data-username="<?php echo e($voter->username); ?>"></td>
                <td><?php echo e($perPage === 'all' ? $index + 1 : ($voters->currentPage() - 1) * $voters->perPage() + $index + 1); ?></td>
                <td><?php echo e($voter->nis ?? '-'); ?></td>
                <td style="font-weight: 500;"><?php echo e($voter->name); ?></td>
                <td><?php echo e($voter->class_name); ?></td>
                <td><?php echo e($voter->gender); ?></td>
                <td><?php echo e($voter->username ?? '-'); ?></td>
                <td>
                    <span class="access-code-box"><?php echo e($voter->access_code); ?></span>
                </td>
                <td>
                    <?php if($voter->has_voted): ?>
                        <span class="status-badge status-voted"><i class="fa-solid fa-check"></i> Sudah Memilih</span>
                    <?php else: ?>
                        <span class="status-badge status-pending"><i class="fa-solid fa-clock"></i> Belum</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    
    <?php if($voters->hasPages()): ?>
    <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border);">
        <?php echo e($voters->links('vendor.pagination.custom')); ?>

    </div>
    <?php endif; ?>
</div>
</div>

<!-- Modal Tambah Manual -->
<div id="addModal" class="modal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div class="card" style="margin: 2rem auto; width: 90%; max-width: 500px; position:relative;">
        <span onclick="document.getElementById('addModal').style.display='none'" style="position:absolute; right:1.5rem; top:1.5rem; cursor:pointer; font-size:1.5rem;">&times;</span>
        <h3 style="margin-bottom: 1.5rem;">Tambah Pemilih Manual</h3>
        <form action="<?php echo e(route('admin.voters.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group"><label>NIS</label><input type="text" name="nis"></div>
            <div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" required></div>
            <div class="form-group"><label>Kelas</label><input type="text" name="class_name" required></div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="gender" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius);">
                    <option value="L">Laki-laki (L)</option>
                    <option value="P">Perempuan (P)</option>
                </select>
            </div>
            <div style="margin-top: 1.5rem; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; border-top: 1px solid var(--border); padding-top: 1rem;">Opsi Login</div>
            <div class="form-group">
                <label>Kode Akses (Opsional)</label>
                <input type="text" name="access_code" placeholder="Kosongkan untuk generate otomatis">
            </div>
            <div class="form-group">
                <label>Username (Opsional)</label>
                <input type="text" name="username" placeholder="Kosongkan jika tidak dipakai">
            </div>
            <div class="form-group">
                <label>Password (Opsional)</label>
                <input type="text" name="password" placeholder="Kosongkan jika tidak dipakai">
            </div>
            <button type="submit" class="btn" style="width: 100%; margin-top: 1rem; border-radius: 8px; font-weight: 600; padding: 0.75rem; border: none; transition: all 0.2s; background-color: var(--primary); color: white; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 8px -1px rgba(79, 70, 229, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(79, 70, 229, 0.2)'">Simpan Data</button>
        </form>
    </div>
</div>

<!-- Modal Edit Manual -->
<div id="editModal" class="modal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div class="card" style="margin: 2rem auto; width: 90%; max-width: 500px; position:relative;">
        <span onclick="document.getElementById('editModal').style.display='none'" style="position:absolute; right:1.5rem; top:1.5rem; cursor:pointer; font-size:1.5rem;">&times;</span>
        <h3 style="margin-bottom: 1.5rem;">Edit Data Pemilih</h3>
        <form id="editForm" action="" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group"><label>NIS</label><input type="text" name="nis" id="edit_nis"></div>
            <div class="form-group"><label>Nama Lengkap</label><input type="text" name="name" id="edit_name" required></div>
            <div class="form-group"><label>Kelas</label><input type="text" name="class_name" id="edit_class" required></div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="gender" id="edit_gender" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius);">
                    <option value="L">Laki-laki (L)</option>
                    <option value="P">Perempuan (P)</option>
                </select>
            </div>
            <div style="margin-top: 1.5rem; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; border-top: 1px solid var(--border); padding-top: 1rem;">Opsi Login</div>
            <div class="form-group">
                <label>Kode Akses</label>
                <input type="text" name="access_code" placeholder="Kosongkan jika tidak ingin mengubah kode">
                <small style="color: var(--text-muted);">Biarkan kosong jika tidak ingin mengganti kode akses saat ini.</small>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="edit_username" placeholder="Kosongkan jika tidak dipakai">
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ganti password">
            </div>
            
            <button type="submit" class="btn" style="width: 100%; margin-top: 1rem; border-radius: 8px; font-weight: 600; padding: 0.75rem; border: none; transition: all 0.2s; background-color: var(--primary); color: white; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 8px -1px rgba(79, 70, 229, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(79, 70, 229, 0.2)'"><i class="fa-solid fa-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>

<!-- Modal Import -->
<div id="importModal" class="modal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div class="card" style="margin: 2rem auto; width: 90%; max-width: 500px; position:relative;">
        <span onclick="document.getElementById('importModal').style.display='none'" style="position:absolute; right:1.5rem; top:1.5rem; cursor:pointer; font-size:1.5rem;">&times;</span>
        <h3 style="margin-bottom: 1.5rem;">Import Data Excel</h3>
        
        <div style="margin-bottom: 1.5rem; padding: 1rem; background: #F3F4F6; border-radius: var(--radius); text-align: center;">
            <p style="margin-bottom: 0.5rem; font-size: 0.875rem;">Gunakan format template yang telah disediakan sebelum mengunggah.</p>
            <a href="<?php echo e(route('admin.voters.template')); ?>" class="btn btn-secondary" style="font-size: 0.875rem;"><i class="fa-solid fa-download"></i> Unduh Template</a>
        </div>

        <form action="<?php echo e(route('admin.voters.import')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label>Pilih File Excel (.xlsx)</label>
                <input type="file" name="file" accept=".xlsx, .xls" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: var(--radius);">
            </div>
            <button type="submit" class="btn" style="width: 100%; border-radius: 8px; font-weight: 600; padding: 0.75rem; border: none; transition: all 0.2s; background-color: var(--primary); color: white; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 8px -1px rgba(79, 70, 229, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(79, 70, 229, 0.2)'"><i class="fa-solid fa-upload"></i> Proses Import</button>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function updateBulkActionBar() {
        const selected = document.querySelectorAll('.row-checkbox:checked');
        const defaultHeaders = document.getElementById('defaultHeaders');
        const actionHeaders = document.getElementById('bulkActionHeaders');
        const countSpan = document.getElementById('selectedCount');
        const btnEdit = document.getElementById('btnEditSelected');
        const selectAllCb = document.getElementById('selectAll');
        const selectAllActionCb = document.getElementById('selectAllAction');
        
        const allCheckboxes = document.querySelectorAll('.row-checkbox');
        const isAllChecked = allCheckboxes.length > 0 && selected.length === allCheckboxes.length;
        
        if(selectAllCb) selectAllCb.checked = isAllChecked;
        if(selectAllActionCb) selectAllActionCb.checked = isAllChecked;
        
        if (selected.length > 0) {
            if(defaultHeaders) defaultHeaders.style.display = 'none';
            if(actionHeaders) actionHeaders.style.display = 'table-row';
            if(countSpan) countSpan.textContent = selected.length + ' Terpilih';
            
            if (selected.length === 1) {
                if(btnEdit) btnEdit.style.display = 'flex';
            } else {
                if(btnEdit) btnEdit.style.display = 'none';
            }
        } else {
            if(defaultHeaders) defaultHeaders.style.display = 'table-row';
            if(actionHeaders) actionHeaders.style.display = 'none';
        }
    }

    function toggleAllCheckboxes(source) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        for(let i=0, n=checkboxes.length; i<n; i++) {
            checkboxes[i].checked = source.checked;
        }
        updateBulkActionBar();
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateBulkActionBar);
        });
    });

    function editSelectedRow() {
        const selected = document.querySelectorAll('.row-checkbox:checked');
        if (selected.length === 1) {
            const cb = selected[0];
            openEditModal(cb.value, cb.dataset.nis, cb.dataset.name, cb.dataset.class, cb.dataset.gender, cb.dataset.username);
        }
    }

    function submitBulkAction(actionRoute, confirmMessage) {
        const selected = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
        if (selected.length === 0) {
            Swal.fire('Pilih Data', 'Pilih setidaknya satu data terlebih dahulu!', 'warning');
            return;
        }
        
        Swal.fire({
            title: 'Konfirmasi Aksi Massal',
            text: confirmMessage + " (" + selected.length + " data dipilih)",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = actionRoute;
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '<?php echo e(csrf_token()); ?>';
                form.appendChild(csrf);
                
                const ids = document.createElement('input');
                ids.type = 'hidden';
                ids.name = 'ids';
                ids.value = JSON.stringify(selected);
                form.appendChild(ids);
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    function toggleActionSidebar() {
        const sidebar = document.getElementById('floatingActionSidebar');
        const icon = document.getElementById('actionSidebarIcon');
        
        if (sidebar.style.left === '-300px' || sidebar.style.left === '') {
            sidebar.style.left = '0px';
            icon.style.transform = 'rotate(180deg)';
        } else {
            sidebar.style.left = '-300px';
            icon.style.transform = 'rotate(0deg)';
        }
    }

    function openEditModal(id, nis, name, className, gender, username) {
        document.getElementById('editForm').action = "<?php echo e(url('/admin/voters')); ?>/" + id + "/update";
        document.getElementById('edit_nis').value = nis;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_class').value = className;
        document.getElementById('edit_gender').value = gender;
        document.getElementById('edit_username').value = username;
        document.getElementById('editModal').style.display = 'block';
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\1Laravel\pilkasim\resources\views\admin\voters.blade.php ENDPATH**/ ?>