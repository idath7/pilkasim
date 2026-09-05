@extends('layouts.app')

@section('styles')
<style>
    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .settings-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 2rem;
        box-shadow: var(--shadow);
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
    }
    
    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .form-section-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--primary);
    }
    
    .color-picker-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }
    
    .color-input {
        width: 100%;
        height: 50px;
        padding: 0;
        border: none;
        border-radius: var(--radius);
        cursor: pointer;
    }
    
    .file-preview {
        max-width: 150px;
        max-height: 150px;
        margin-top: 0.5rem;
        border-radius: 8px;
        border: 1px solid var(--border);
        display: block;
    }
    
    .toggle-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .toggle-checkbox {
        width: 20px;
        height: 20px;
    }
    
    .access-code-box {
        font-family: monospace;
        background: #F3F4F6;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-weight: 700;
        letter-spacing: 1px;
    }
</style>
<link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr.min.css') }}">
@endsection

@section('content')
<div class="header-flex animate-fade-in">
    <h2>Pengaturan Aplikasi</h2>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="settings-card animate-fade-in" style="animation-delay: 0.1s;">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Informasi Umum -->
        <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-circle-info"></i> Informasi Umum</div>
            
            <div class="form-group">
                <label>Nama Sekolah</label>
                <input type="text" name="school_name" value="{{ $setting->school_name }}" placeholder="Contoh: SMA Negeri 1 Jakarta">
            </div>
            
            <div class="form-group">
                <label>Instruksi (Cara Memilih)</label>
                <textarea name="instructions" rows="4" placeholder="Tuliskan petunjuk tata cara memilih di halaman depan...">{{ $setting->instructions }}</textarea>
            </div>
        </div>
        
        <!-- Pengaturan Keamanan -->
        <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-shield-halved"></i> Pengaturan Keamanan & Login</div>
            
            <div class="color-picker-grid">
                <div class="form-group">
                    <label>Metode Login Pemilih</label>
                    <select name="login_method" style="width: 100%; padding: 0.75rem; border-radius: var(--radius); border: 1px solid var(--border); font-family: inherit;">
                        <option value="access_code" {{ ($setting->login_method ?? 'access_code') == 'access_code' ? 'selected' : '' }}>Kode Akses Saja</option>
                        <option value="username_password" {{ ($setting->login_method ?? 'access_code') == 'username_password' ? 'selected' : '' }}>Username dan Password</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Durasi Token Kiosk (Detik)</label>
                    <input type="number" name="token_duration" value="{{ $setting->token_duration ?? 30 }}" min="5" max="3600" placeholder="Contoh: 30">
                    <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Berapa lama QR Code / Token Kiosk akan bertahan sebelum berganti secara otomatis. Default: 30 detik.</small>
                </div>
                
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>PIN/Token Keamanan Kiosk (6 Karakter)</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <input type="text" name="kiosk_pin" id="kiosk_pin" value="{{ $setting->kiosk_pin }}" maxlength="6" placeholder="Kosongkan jika tidak ingin dikunci" style="flex: 1; padding: 0.75rem; border-radius: var(--radius); border: 1px solid var(--border); font-family: monospace; font-size: 1.1rem; letter-spacing: 2px;">
                        <button type="button" class="btn" style="background-color: var(--secondary);" onclick="generateKioskPin()"><i class="fa-solid fa-dice"></i> Generate Token</button>
                    </div>
                    <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Jika diisi, layar Kiosk akan terkunci dan meminta PIN ini sebelum bisa menampilkan QR Code.</small>
                </div>
                
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Zona Waktu Sistem (Timezone)</label>
                    <select name="timezone" style="width: 100%; padding: 0.75rem; border-radius: var(--radius); border: 1px solid var(--border); font-family: inherit;">
                        <option value="Asia/Jakarta" {{ ($setting->timezone ?? 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>Waktu Indonesia Barat (WIB)</option>
                        <option value="Asia/Makassar" {{ ($setting->timezone ?? 'Asia/Jakarta') == 'Asia/Makassar' ? 'selected' : '' }}>Waktu Indonesia Tengah (WITA)</option>
                        <option value="Asia/Jayapura" {{ ($setting->timezone ?? 'Asia/Jakarta') == 'Asia/Jayapura' ? 'selected' : '' }}>Waktu Indonesia Timur (WIT)</option>
                    </select>
                    <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Zona waktu akan memengaruhi kapan pemilihan otomatis dibuka dan ditutup sesuai wilayah Anda.</small>
                </div>
            </div>
        </div>
        <!-- Jadwal Pemilihan -->
        <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-clock"></i> Jadwal Pemilihan</div>
            <div class="color-picker-grid">
                <div class="form-group">
                    <label>Waktu Mulai Pemilihan</label>
                    <input type="text" class="flatpickr-datetime" name="voting_start_time" value="{{ $setting->voting_start_time ? $setting->voting_start_time->format('Y-m-d H:i') : '' }}" style="width: 100%; padding: 0.75rem; border-radius: var(--radius); border: 1px solid var(--border); font-family: inherit; background: white;" placeholder="Pilih tanggal & jam">
                    <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Kosongkan jika ingin pemilihan selalu terbuka tanpa batasan awal.</small>
                </div>
                
                <div class="form-group">
                    <label>Waktu Tutup Pemilihan</label>
                    <input type="text" class="flatpickr-datetime" name="voting_end_time" value="{{ $setting->voting_end_time ? $setting->voting_end_time->format('Y-m-d H:i') : '' }}" style="width: 100%; padding: 0.75rem; border-radius: var(--radius); border: 1px solid var(--border); font-family: inherit; background: white;" placeholder="Pilih tanggal & jam">
                    <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Kosongkan jika ingin pemilihan selalu terbuka tanpa batasan akhir.</small>
                </div>
            </div>
        </div>

        <!-- Tema & Warna -->
        <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-palette"></i> Tema & Warna</div>
            
            <div class="toggle-wrapper" style="margin-bottom: 1.5rem;">
                <input type="checkbox" name="use_gradient" id="use_gradient" class="toggle-checkbox" {{ $setting->use_gradient ? 'checked' : '' }} value="1">
                <label for="use_gradient" style="margin: 0; font-weight: 600;">Gunakan Mode Gradien (Gunakan Warna 1 ke Warna 2)</label>
            </div>
            
            <div class="color-picker-grid">
                <div class="form-group">
                    <label>Warna 1 (Utama)</label>
                    <input type="color" name="theme_color_1" value="{{ $setting->theme_color_1 }}" class="color-input">
                </div>
                <div class="form-group">
                    <label>Warna 2 (Gradien)</label>
                    <input type="color" name="theme_color_2" value="{{ $setting->theme_color_2 }}" class="color-input">
                </div>
                <div class="form-group">
                    <label>Warna 3 (Aksen)</label>
                    <input type="color" name="theme_color_3" value="{{ $setting->theme_color_3 }}" class="color-input">
                </div>
                <div class="form-group">
                    <label>Warna 4 (Teks/Lainnya)</label>
                    <input type="color" name="theme_color_4" value="{{ $setting->theme_color_4 }}" class="color-input">
                </div>
                <div class="form-group">
                    <label>Warna 5 (Tombol Gradien 1)</label>
                    <input type="color" name="theme_color_5" value="{{ $setting->theme_color_5 ?? '#f59e0b' }}" class="color-input">
                </div>
                <div class="form-group">
                    <label>Warna 6 (Tombol Gradien 2)</label>
                    <input type="color" name="theme_color_6" value="{{ $setting->theme_color_6 ?? '#d97706' }}" class="color-input">
                </div>
            </div>
        </div>
        
        <!-- Gambar & Logo -->
        <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-images"></i> Gambar & Logo</div>
            
            <div class="color-picker-grid">
                <div class="form-group">
                    <label>Logo Sekolah</label>
                    <input type="file" name="school_logo" accept="image/*">
                    @if($setting->school_logo)
                        <img src="{{ $setting->school_logo }}" class="file-preview" alt="Logo Sekolah">
                    @endif
                </div>
                <div class="form-group">
                    <label>Logo OSIM</label>
                    <input type="file" name="osim_logo" accept="image/*">
                    @if($setting->osim_logo)
                        <img src="{{ $setting->osim_logo }}" class="file-preview" alt="Logo OSIM">
                    @endif
                </div>
                <div class="form-group">
                    <label>Gambar Utama (Dashboard/Login)</label>
                    <input type="file" name="main_image" accept="image/*">
                    @if($setting->main_image)
                        <img src="{{ $setting->main_image }}" class="file-preview" alt="Gambar Utama">
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Meta SEO & OpenGraph -->
        <div class="form-section">
            <div class="form-section-title" style="color: #4F46E5;"><i class="fa-solid fa-magnifying-glass"></i> Meta SEO & OpenGraph</div>
            <p style="font-size: 0.9rem; color: #555; margin-bottom: 1.5rem;">Pengaturan ini akan digunakan oleh mesin pencari (seperti Google) dan saat link aplikasi dibagikan di WhatsApp atau Sosial Media.</p>
            
            <div class="form-group">
                <label style="font-weight: 600; color: #333;">Judul SEO (Title)</label>
                <input type="text" name="seo_title" value="{{ $setting->seo_title }}" placeholder="Contoh: Aplikasi SiPresensi Terbaik" style="width: 100%; padding: 0.75rem; border-radius: var(--radius); border: 1px solid var(--border); font-family: inherit;">
            </div>

            <div class="form-group">
                <label style="font-weight: 600; color: #333;">Deskripsi SEO (Description)</label>
                <textarea name="seo_description" rows="3" placeholder="Deskripsi singkat tentang aplikasi (maksimal 160 karakter)." style="width: 100%; padding: 0.75rem; border-radius: var(--radius); border: 1px solid var(--border); font-family: inherit; resize: vertical;">{{ $setting->seo_description }}</textarea>
            </div>

            <div class="form-group">
                <label style="font-weight: 600; color: #333;">Gambar SEO (OpenGraph Image)</label>
                <div style="border: 1px solid var(--border); padding: 0.5rem; border-radius: var(--radius); display: inline-block; width: 100%; box-sizing: border-box; background: white;">
                    <input type="file" name="seo_image" accept="image/*" style="width: 100%;">
                </div>
                <p style="font-size: 0.85rem; color: #666; margin-top: 0.5rem;">Gambar ini akan muncul saat link dibagikan. Rekomendasi ukuran standar SEO: <strong>1200x630 piksel</strong> (Rasio 1.91:1) dan maksimal ukuran file 5MB.</p>
                @if($setting->seo_image)
                    <div style="margin-top: 1rem;">
                        <img src="{{ Storage::url($setting->seo_image) }}" alt="SEO Image" style="max-width: 300px; border-radius: 8px; border: 1px solid var(--border);">
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Fitur Tag Warna Dinamis -->
        <div class="form-section">
            <div class="form-section-title" style="color: #F59E0B;"><i class="fa-solid fa-tags"></i> Tag Warna Dinamis (Custom)</div>
            <p style="font-size: 0.9rem; color: #555; margin-bottom: 1.5rem;">Tentukan warna kustom untuk elemen spesifik (tag) tanpa mengubah kode sumber. Cukup ketik nama "Tag" (misal: <code>login-pemilih</code> atau <code>akses-kode</code>).</p>
            
            <div id="dynamic-tags-container">
                @php $tags = is_array($setting->dynamic_color_tags) ? $setting->dynamic_color_tags : []; @endphp
                @if(count($tags) > 0)
                    @foreach($tags as $index => $tagData)
                    <div class="dynamic-tag-row" style="display: flex; gap: 1rem; margin-bottom: 1rem; align-items: flex-end; background: #F9FAFB; padding: 1rem; border-radius: var(--radius); border: 1px solid var(--border);">
                        <div style="flex: 2;">
                            <label style="font-size: 0.85rem;">Kata Kunci / Nama Tag</label>
                            <input type="text" name="dynamic_color_tags[{{$index}}][tag]" value="{{ $tagData['tag'] ?? '' }}" placeholder="Misal: login-pemilih" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: var(--radius);">
                        </div>
                        <div style="flex: 1;">
                            <label style="font-size: 0.85rem;">Warna Latar</label>
                            <input type="color" name="dynamic_color_tags[{{$index}}][bg_color]" value="{{ $tagData['bg_color'] ?? '#ffffff' }}" style="width: 100%; height: 38px; border: 1px solid var(--border); border-radius: var(--radius); cursor: pointer; padding: 2px;">
                        </div>
                        <div style="flex: 1;">
                            <label style="font-size: 0.85rem;">Warna Teks</label>
                            <input type="color" name="dynamic_color_tags[{{$index}}][text_color]" value="{{ $tagData['text_color'] ?? '#000000' }}" style="width: 100%; height: 38px; border: 1px solid var(--border); border-radius: var(--radius); cursor: pointer; padding: 2px;">
                        </div>
                        <div>
                            <button type="button" class="btn btn-danger" onclick="this.closest('.dynamic-tag-row').remove()" style="padding: 0.5rem 1rem;"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            
            <button type="button" class="btn btn-secondary" onclick="addDynamicTagRow()" style="margin-top: 0.5rem; background: white;"><i class="fa-solid fa-plus"></i> Tambah Tag Warna</button>
        </div>
        
        <button type="submit" class="btn" style="width: 100%; padding: 1rem; font-size: 1.1rem;"><i class="fa-solid fa-save"></i> Simpan Pengaturan</button>
    </form>

    <!-- Super Speed / Cache -->
    <div class="form-section" style="margin-top: 2rem;">
        <div class="form-section-title" style="color: #10B981;"><i class="fa-solid fa-bolt"></i> Super Speed & Optimalisasi (Cache)</div>
        <p style="font-size: 0.9rem; color: #555; margin-bottom: 1.5rem;">Jika aplikasi terasa lambat setelah melakukan banyak perubahan, klik tombol ini untuk melakukan kompilasi ulang (Caching) agar sistem berjalan super cepat kembali. Fitur ini sangat direkomendasikan jika server Anda sering kepenuhan (overload).</p>
        <form action="{{ route('admin.optimize') }}" method="POST">
            @csrf
            <button type="submit" class="btn" style="background: #10B981; border: none; padding: 0.75rem 1.5rem;"><i class="fa-solid fa-broom"></i> Bersihkan & Optimalkan Cache</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/vendor/flatpickr.min.js') }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
    let tagIndex = {{ is_array($setting->dynamic_color_tags) ? count($setting->dynamic_color_tags) : 0 }};
    function addDynamicTagRow() {
        const container = document.getElementById('dynamic-tags-container');
        const row = document.createElement('div');
        row.className = 'dynamic-tag-row';
        row.style.cssText = 'display: flex; gap: 1rem; margin-bottom: 1rem; align-items: flex-end; background: #F9FAFB; padding: 1rem; border-radius: var(--radius); border: 1px solid var(--border);';
        
        row.innerHTML = `
            <div style="flex: 2;">
                <label style="font-size: 0.85rem;">Kata Kunci / Nama Tag</label>
                <input type="text" name="dynamic_color_tags[${tagIndex}][tag]" placeholder="Misal: login-pemilih" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: var(--radius);">
            </div>
            <div style="flex: 1;">
                <label style="font-size: 0.85rem;">Warna Latar</label>
                <input type="color" name="dynamic_color_tags[${tagIndex}][bg_color]" value="#ffffff" style="width: 100%; height: 38px; border: 1px solid var(--border); border-radius: var(--radius); cursor: pointer; padding: 2px;">
            </div>
            <div style="flex: 1;">
                <label style="font-size: 0.85rem;">Warna Teks</label>
                <input type="color" name="dynamic_color_tags[${tagIndex}][text_color]" value="#000000" style="width: 100%; height: 38px; border: 1px solid var(--border); border-radius: var(--radius); cursor: pointer; padding: 2px;">
            </div>
            <div>
                <button type="button" class="btn btn-danger" onclick="this.closest('.dynamic-tag-row').remove()" style="padding: 0.5rem 1rem;"><i class="fa-solid fa-trash"></i></button>
            </div>
        `;
        container.appendChild(row);
        tagIndex++;
    }

    function generateKioskPin() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = '';
        for (let i = 0; i < 6; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('kiosk_pin').value = result;
    }

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".flatpickr-datetime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            locale: "id", // Bahasa Indonesia
            allowInput: true
        });
    });
</script>
@endsection
