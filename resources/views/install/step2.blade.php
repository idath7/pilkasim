@extends('install.layout')

@section('content')
    <h2 style="margin-top: 0; font-size: 1.25rem;">Konfigurasi Database</h2>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Masukkan kredensial koneksi database Anda. Jika Anda belum membuatnya, silakan buat database kosong terlebih dahulu di server Anda (misal via phpMyAdmin).</p>
    
    <form action="{{ route('install.process_database') }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
            <div class="form-group">
                <label>Database Host</label>
                <input type="text" name="db_host" class="form-control" value="127.0.0.1" required>
            </div>
            
            <div class="form-group">
                <label>Database Port</label>
                <input type="text" name="db_port" class="form-control" value="3306" required>
            </div>
        </div>
        
        <div class="form-group">
            <label>Nama Database</label>
            <input type="text" name="db_database" class="form-control" placeholder="pilketos_db" value="{{ old('db_database') }}" required>
        </div>
        
        <div class="form-group">
            <label>Database Username</label>
            <input type="text" name="db_username" class="form-control" placeholder="root" value="{{ old('db_username', 'root') }}" required>
        </div>
        
        <div class="form-group">
            <label>Database Password</label>
            <input type="password" name="db_password" class="form-control" placeholder="Kosongkan jika tidak ada password">
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem;">
            <a href="{{ route('install.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.95rem;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            <button type="submit" class="btn btn-primary" style="width: auto;">Simpan & Lanjutkan <i class="fa-solid fa-arrow-right" style="margin-left: 0.5rem;"></i></button>
        </div>
    </form>
@endsection
