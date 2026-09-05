@extends('install.layout')

@section('content')
    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: var(--success); padding: 1rem; border-radius: 8px; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
        <i class="fa-solid fa-check-circle" style="font-size: 1.5rem;"></i>
        <div>
            <strong>Koneksi Database Berhasil!</strong>
            <div style="font-size: 0.85rem; opacity: 0.9;">Sekarang mari kita atur akun Admin pertama Anda.</div>
        </div>
    </div>

    <form action="{{ route('install.process_setup') }}" method="POST" id="setupForm">
        @csrf
        
        <h3 style="margin-top: 0; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Pengaturan Aplikasi</h3>
        
        <div class="form-group">
            <label>Nama Aplikasi</label>
            <input type="text" name="app_name" class="form-control" placeholder="Misal: E-Pilketos" value="{{ old('app_name', 'E-Pilketos') }}" required>
            <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">Anda bisa mengubahnya lagi nanti di Pengaturan Sistem.</div>
        </div>
        
        <h3 style="margin-top: 2rem; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; margin-bottom: 1.5rem;">Akun Administrator</h3>
        
        <div class="form-group">
            <label>Nama Lengkap Admin</label>
            <input type="text" name="admin_name" class="form-control" placeholder="Administrator" value="{{ old('admin_name', 'Administrator') }}" required>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label>Username Login</label>
                <input type="text" name="admin_username" class="form-control" placeholder="admin" value="{{ old('admin_username', 'admin') }}" required>
            </div>
            
            <div class="form-group">
                <label>Password Login</label>
                <input type="password" name="admin_password" class="form-control" required minlength="6">
            </div>
        </div>

        <div style="margin-top: 1.5rem; background: #f8fafc; border: 1px solid var(--border); padding: 1.5rem; border-radius: 8px;">
            <label style="display: flex; align-items: flex-start; gap: 1rem; cursor: pointer;">
                <input type="checkbox" name="dummy_data" value="1" style="margin-top: 0.25rem; width: 1.2rem; height: 1.2rem;">
                <div>
                    <strong style="display: block; margin-bottom: 0.25rem; color: var(--text-main);">Import Data Contoh (Dummy Data)</strong>
                    <span style="font-size: 0.85rem; color: var(--text-muted);">Centang ini jika Anda ingin sistem otomatis membuatkan data kandidat dan pemilih awal untuk keperluan pengujian. Biarkan kosong untuk instalasi bersih.</span>
                </div>
            </label>
        </div>
        
        <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary" style="width: auto;" id="btnSubmit">Selesaikan Instalasi <i class="fa-solid fa-check" style="margin-left: 0.5rem;"></i></button>
        </div>
        
        <div id="loadingText" style="display: none; text-align: right; margin-top: 1rem; font-size: 0.9rem; color: var(--primary);">
            <i class="fa-solid fa-circle-notch fa-spin"></i> Sedang memproses database. Mohon tunggu...
        </div>
    </form>
    
    <script>
        document.getElementById('setupForm').addEventListener('submit', function() {
            document.getElementById('btnSubmit').style.display = 'none';
            document.getElementById('loadingText').style.display = 'block';
        });
    </script>
@endsection
