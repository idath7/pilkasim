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
    
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .status-voted {
        background-color: #D1FAE5;
        color: #065F46;
    }
    
    .status-pending {
        background-color: #FEF3C7;
        color: #92400E;
    }
    
    .access-code-box {
        font-family: monospace;
        background: #F3F4F6;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 250px;
        box-shadow: var(--shadow-lg);
        z-index: 1;
        border-radius: var(--radius);
        overflow: hidden;
        right: 0;
        top: 100%;
        margin-top: 0.5rem;
        border: 1px solid var(--border);
    }

    .dropdown-content form {
        display: block;
    }

    .dropdown-content button {
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

    .dropdown-content button:hover {
        background-color: #f3f4f6;
    }

    .dropdown:hover .dropdown-content, .dropdown:focus-within .dropdown-content {
        display: block;
    }
</style>
@endsection

@section('content')
<div class="header-flex animate-fade-in">
    <h2>Daftar Pemilih (Siswa) & Kode Akses</h2>
    <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; justify-content: flex-end;">
        <div class="dropdown">
            <button class="btn" style="background-color: #10B981;"><i class="fa-solid fa-key"></i> Generate Kode</button>
            <div class="dropdown-content">
                <form action="{{ route('admin.voters.generate_codes') }}" method="POST" onsubmit="confirmAction(event, 'Generate kode akses otomatis untuk pemilih yang belum punya?');">
                    @csrf
                    <input type="hidden" name="type" value="student">
                    <button type="submit"><i class="fa-solid fa-magic"></i> Generate untuk yang kosong</button>
                </form>
                <form action="{{ route('admin.voters.generate_codes') }}" method="POST" onsubmit="confirmAction(event, 'PERINGATAN: Ini akan mereset dan mengganti SEMUA kode akses siswa menjadi baru. Lanjutkan?');">
                    @csrf
                    <input type="hidden" name="type" value="student">
                    <input type="hidden" name="force_all" value="1">
                    <button type="submit" style="color: #DC2626;"><i class="fa-solid fa-rotate"></i> Regenerate Semua Kode</button>
                </form>
            </div>
        </div>
        <button onclick="document.getElementById('addModal').style.display='block'" class="btn"><i class="fa-solid fa-plus"></i> Tambah</button>
        <button onclick="document.getElementById('importModal').style.display='block'" class="btn" style="background-color: var(--secondary);"><i class="fa-solid fa-file-excel"></i> Import</button>
        <a href="{{ route('admin.voters.print', ['type' => 'student']) }}" target="_blank" class="btn" style="background-color: #6366f1;"><i class="fa-solid fa-print"></i> Cetak Kartu</a>
        <form action="{{ route('admin.voters.reset_votes') }}" method="POST" onsubmit="confirmAction(event, 'Hasil perolehan suara akan dikosongkan dan status memilih siswa akan direset. Anda yakin?');" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger" style="background-color: #f59e0b;"><i class="fa-solid fa-rotate-left"></i> Reset Suara</button>
        </form>
        <form action="{{ route('admin.voters.reset_all') }}" method="POST" onsubmit="confirmAction(event, 'Peringatan: Seluruh data pemilih akan dihapus dari database! Anda yakin?');" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Hapus Semua</button>
        </form>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="card animate-fade-in" style="animation-delay: 0.1s; overflow-x: auto;">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Lengkap</th>
                <th>Kelas</th>
                <th>L/P</th>
                <th>Username</th>
                <th>Kode Akses</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($voters as $index => $voter)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $voter->nis ?? '-' }}</td>
                <td style="font-weight: 500;">{{ $voter->name }}</td>
                <td>{{ $voter->class_name }}</td>
                <td>{{ $voter->gender }}</td>
                <td>{{ $voter->username ?? '-' }}</td>
                <td>
                    <span class="access-code-box">{{ $voter->access_code }}</span>
                </td>
                <td>
                    @if($voter->has_voted)
                        <span class="status-badge status-voted"><i class="fa-solid fa-check"></i> Sudah Memilih</span>
                    @else
                        <span class="status-badge status-pending"><i class="fa-solid fa-clock"></i> Belum</span>
                    @endif
                </td>
                <td style="display: flex; gap: 0.25rem;">
                    <form action="{{ route('admin.voters.reset', $voter->id) }}" method="POST" onsubmit="confirmAction(event, 'Reset status pemilihan siswa ini?');">
                        @csrf
                        <button type="submit" class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;"><i class="fa-solid fa-rotate-left"></i> Reset Status</button>
                    </form>
                    <form action="{{ route('admin.voters.regenerate_single', $voter->id) }}" method="POST" onsubmit="confirmAction(event, 'Generate ulang kode akses untuk siswa ini?');">
                        @csrf
                        <button type="submit" class="btn" style="padding: 0.25rem 0.5rem; font-size: 0.75rem; background-color: #10B981;"><i class="fa-solid fa-key"></i> Generate</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Manual -->
<div id="addModal" class="modal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div class="card" style="margin: 5% auto; width: 90%; max-width: 500px; position:relative;">
        <span onclick="document.getElementById('addModal').style.display='none'" style="position:absolute; right:1.5rem; top:1.5rem; cursor:pointer; font-size:1.5rem;">&times;</span>
        <h3 style="margin-bottom: 1.5rem;">Tambah Pemilih Manual</h3>
        <form action="{{ route('admin.voters.store') }}" method="POST">
            @csrf
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
            <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">Simpan Data</button>
        </form>
    </div>
</div>

<!-- Modal Upload Excel -->
<div id="importModal" class="modal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">
    <div class="card" style="margin: 5% auto; width: 90%; max-width: 500px; position:relative;">
        <span onclick="document.getElementById('importModal').style.display='none'" style="position:absolute; right:1.5rem; top:1.5rem; cursor:pointer; font-size:1.5rem;">&times;</span>
        <h3 style="margin-bottom: 1.5rem;">Import Data Excel</h3>
        
        <div style="margin-bottom: 1.5rem; padding: 1rem; background: #F3F4F6; border-radius: var(--radius); text-align: center;">
            <p style="margin-bottom: 0.5rem; font-size: 0.875rem;">Gunakan format template yang telah disediakan sebelum mengunggah.</p>
            <a href="{{ route('admin.voters.template') }}" class="btn btn-secondary" style="font-size: 0.875rem;"><i class="fa-solid fa-download"></i> Unduh Template</a>
        </div>

        <form action="{{ route('admin.voters.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Pilih File Excel (.xlsx)</label>
                <input type="file" name="file" accept=".xlsx, .xls" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: var(--radius);">
            </div>
            <button type="submit" class="btn" style="width: 100%;">Upload & Proses</button>
        </form>
    </div>
</div>

@endsection
