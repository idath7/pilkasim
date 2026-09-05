@extends('layouts.app')

@section('styles')
<style>
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
    }
    
    th, td {
        padding: 0.5rem;
        text-align: left;
        border-bottom: 1px solid var(--border);
    }
    
    th {
        background-color: #F9FAFB;
        font-weight: 600;
        color: var(--text-muted);
    }
    
    tr:hover {
        background-color: #F9FAFB;
    }

    .role-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .role-admin {
        background-color: #DBEAFE;
        color: #1E40AF;
    }

    .role-panitia {
        background-color: #FEF3C7;
        color: #92400E;
    }

    .role-pembina {
        background-color: #D1FAE5;
        color: #065F46;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: white;
        padding: 1.25rem;
        border-radius: var(--radius);
        width: 100%;
        max-width: 500px;
        position: relative;
    }

    .close-modal {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--text-muted);
    }

    .form-group select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        font-size: 1rem;
        background-color: #F9FAFB;
        transition: all 0.2s;
    }

        .form-group select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        background-color: var(--surface);
    }
    
    .select2-container {
        width: 100% !important;
    }
    
    /* Minimalist Select2 Style */
    .select2-container--default .select2-selection--single {
        background-color: transparent !important;
        border: none !important;
        border-bottom: 2px solid var(--border) !important;
        border-radius: 0 !important;
        height: auto !important;
        padding: 0.5rem 0 !important;
    }
    .select2-container--default.select2-container--open .select2-selection--single {
        border-bottom-color: var(--primary) !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--text-main) !important;
        line-height: 1.5 !important;
        padding-left: 0 !important;
        font-size: 0.95rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        right: 0 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #9CA3AF transparent transparent transparent !important;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="header-flex">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <h2 style="margin: 0;">Manajemen Petugas & Admin</h2>
    </div>
    
    <div style="display: flex; gap: 0.75rem;">
        <button onclick="document.getElementById('addUserModal').style.display='flex'" class="btn" style="background-color: transparent; color: var(--primary); border: 1px solid transparent; transition: all 0.2s; font-weight: 500; border-radius: 8px; padding: 0.5rem 1rem; font-size: 0.85rem;" onmouseover="this.style.backgroundColor='#e0e7ff'" onmouseout="this.style.backgroundColor='transparent'"><i class="fa-solid fa-plus" style="margin-right: 0.5rem;"></i> Tambah Akun</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="background-color: transparent; color: var(--text-muted); border: 1px solid transparent; transition: all 0.2s; font-weight: 500; border-radius: 8px; padding: 0.5rem 1rem; font-size: 0.85rem;" onmouseover="this.style.backgroundColor='#f1f5f9'; this.style.color='var(--text-main)'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--text-muted)'"><i class="fa-solid fa-arrow-left" style="margin-right: 0.5rem;"></i> Kembali</a>
    </div>
</div>

<div class="card" style="overflow-x: auto;">
    <table>
        <thead>
            <tr>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td style="font-weight: 500;">{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="role-badge role-{{ $user->role }}">
                        {{ strtoupper($user->role) }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <button onclick="editUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->username) }}', '{{ addslashes($user->email) }}', '{{ $user->role }}')" class="btn" style="padding: 0; font-size: 0.875rem; background-color: transparent; color: var(--primary); border: 1px solid transparent; transition: all 0.2s; border-radius: 6px; display: flex; justify-content: center; align-items: center; width: 32px; height: 32px;" title="Edit" onmouseover="this.style.backgroundColor='#e0e7ff'" onmouseout="this.style.backgroundColor='transparent'">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        @if(auth('admin')->id() !== $user->id)
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="confirmAction(event, 'Apakah Anda yakin ingin menghapus akun ini?');" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn" style="padding: 0; font-size: 0.875rem; background-color: transparent; color: #ef4444; border: 1px solid transparent; transition: all 0.2s; border-radius: 6px; display: flex; justify-content: center; align-items: center; width: 32px; height: 32px;" title="Hapus" onmouseover="this.style.backgroundColor='#fee2e2'" onmouseout="this.style.backgroundColor='transparent'">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Akun -->
<div id="addUserModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="document.getElementById('addUserModal').style.display='none'">&times;</span>
        <h3 style="margin-top: 0; margin-bottom: 1.5rem;">Tambah Akun Baru</h3>
        
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" required placeholder="Contoh: Budi Santoso">
            </div>
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required placeholder="Contoh: budi123">
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="Contoh: budi@sekolah.com">
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Minimal 4 karakter">
            </div>

            <div class="form-group">
                <label>Hak Akses (Role)</label>
                <select name="role" id="roleSelect" onchange="handleRoleChange()" required>
                    <option value="panitia">PANITIA (Kelola Pemilih & Kandidat)</option>
                    <option value="pembina">PEMBINA (Hanya Lihat Hasil)</option>
                    <option value="admin">ADMIN (Akses Penuh)</option>
                </select>
            </div>

            <div class="form-group" id="importStudentGroup">
                <label style="color: var(--primary);"><i class="fa-solid fa-users"></i> Ambil dari Data Siswa (Opsional)</label>
                <select id="studentSelect" onchange="fillUserData(this)" class="select2-search">
                    <option value="">-- Ketik untuk mencari siswa --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->name }}" data-username="{{ $student->username }}">{{ $student->name }} ({{ $student->nis ?? $student->username }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="importTeacherGroup" style="display:none;">
                <label style="color: var(--primary);"><i class="fa-solid fa-chalkboard-user"></i> Ambil dari Data Guru (Opsional)</label>
                <select id="teacherSelect" onchange="fillUserData(this)" class="select2-search">
                    <option value="">-- Ketik untuk mencari guru --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->name }}" data-username="{{ $teacher->username }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="btn" style="width: 100%; border-radius: 8px; font-weight: 600; padding: 0.75rem; border: none; transition: all 0.2s; background-color: var(--primary); color: white; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 8px -1px rgba(79, 70, 229, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(79, 70, 229, 0.2)'">Simpan Akun</button>
        </form>
    </div>
</div>

<!-- Modal Edit Akun -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="document.getElementById('editUserModal').style.display='none'">&times;</span>
        <h3 style="margin-top: 0; margin-bottom: 1.5rem;">Edit Akun</h3>
        
        <form id="editUserForm" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" id="edit_name" required>
            </div>
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="edit_username" required>
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="edit_email" required>
            </div>
            
            <div class="form-group">
                <label>Password Baru <span style="color:var(--text-muted); font-size:0.8rem;">(Kosongkan jika tidak ingin diubah)</span></label>
                <input type="password" name="password" placeholder="Minimal 4 karakter">
            </div>

            <div class="form-group">
                <label>Hak Akses (Role)</label>
                <select name="role" id="edit_role" required>
                    <option value="panitia">PANITIA (Kelola Pemilih & Kandidat)</option>
                    <option value="pembina">PEMBINA (Hanya Lihat Hasil)</option>
                    <option value="admin">ADMIN (Akses Penuh)</option>
                </select>
            </div>
            
            <button type="submit" class="btn" style="width: 100%; border-radius: 8px; font-weight: 600; padding: 0.75rem; border: none; transition: all 0.2s; background-color: var(--primary); color: white; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 8px -1px rgba(79, 70, 229, 0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(79, 70, 229, 0.2)'">Perbarui Akun</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-search').select2({
            dropdownParent: $('#addUserModal')
        });
        
        // Sembunyikan default ketika select2 di-init
        handleRoleChange();
    });

    function handleRoleChange() {
        const role = document.getElementById('roleSelect').value;
        const studentGroup = document.getElementById('importStudentGroup');
        const teacherGroup = document.getElementById('importTeacherGroup');
        
        if (role === 'panitia') {
            studentGroup.style.display = 'block';
            teacherGroup.style.display = 'none';
        } else if (role === 'pembina') {
            studentGroup.style.display = 'none';
            teacherGroup.style.display = 'block';
        } else {
            studentGroup.style.display = 'none';
            teacherGroup.style.display = 'none';
        }
    }

    function fillUserData(selectElement) {
        if (!selectElement.value) return;
        
        const name = selectElement.value;
        const option = selectElement.options[selectElement.selectedIndex];
        const username = option.getAttribute('data-username');
        
        document.querySelector('input[name="name"]').value = name;
        
        const usernameInput = document.querySelector('input[name="username"]');
        if (username && username !== 'null' && username !== '') {
            usernameInput.value = username;
        } else {
            usernameInput.value = name.toLowerCase().replace(/[^a-z0-9]/g, '').substring(0, 10) + Math.floor(Math.random() * 100);
        }
        
        const emailInput = document.querySelector('input[name="email"]');
        if (!emailInput.value) {
            emailInput.value = usernameInput.value + '@sekolah.com';
        }
    }

    function editUser(id, name, username, email, role) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_username').value = username;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;
        
        document.getElementById('editUserForm').action = '/admin/users/' + id + '/update';
        document.getElementById('editUserModal').style.display = 'flex';
    }
</script>
@endsection
