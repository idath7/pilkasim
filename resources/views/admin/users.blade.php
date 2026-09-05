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
        padding: 1rem;
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
        padding: 2rem;
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
</style>
@endsection

@section('content')
<div class="header-flex">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="padding: 0.5rem 1rem;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h2 style="margin: 0;">Manajemen Petugas & Admin</h2>
    </div>
    
    <button onclick="document.getElementById('addUserModal').style.display='flex'" class="btn">
        <i class="fa-solid fa-plus"></i> Tambah Akun
    </button>
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
                        <button onclick="editUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->username) }}', '{{ addslashes($user->email) }}', '{{ $user->role }}')" class="btn btn-secondary" style="padding: 0.4rem 0.75rem; font-size: 0.875rem;">
                            <i class="fa-solid fa-edit"></i>
                        </button>
                        @if(auth('admin')->id() !== $user->id)
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="confirmAction(event, 'Apakah Anda yakin ingin menghapus akun ini?');">
                            @csrf
                            <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.75rem; font-size: 0.875rem;">
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
                <select name="role" required>
                    <option value="panitia">PANITIA (Kelola Pemilih & Kandidat)</option>
                    <option value="pembina">PEMBINA (Hanya Lihat Hasil)</option>
                    <option value="admin">ADMIN (Akses Penuh)</option>
                </select>
            </div>
            
            <button type="submit" class="btn" style="width: 100%;">Simpan Akun</button>
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
            
            <button type="submit" class="btn" style="width: 100%;">Perbarui Akun</button>
        </form>
    </div>
</div>

<script>
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
