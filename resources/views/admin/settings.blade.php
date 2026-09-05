@extends('layouts.app')

@section('styles')
<style>
    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .settings-container {
        display: flex;
        gap: 2rem;
        align-items: flex-start;
    }

    .settings-sidebar {
        width: 280px;
        flex-shrink: 0;
        background: var(--surface);
        border-radius: var(--radius);
        padding: 1rem;
        box-shadow: var(--shadow);
    }

    .settings-content {
        flex: 1;
        background: var(--surface);
        border-radius: var(--radius);
        padding: 2.5rem;
        box-shadow: var(--shadow);
    }

    .tab-button {
        display: flex;
        align-items: center;
        gap: 1rem;
        width: 100%;
        padding: 1rem 1.25rem;
        border: none;
        background: transparent;
        text-align: left;
        font-size: 1rem;
        font-weight: 500;
        color: var(--text-muted);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 0.5rem;
    }

    .tab-button:hover {
        background: rgba(79, 70, 229, 0.05);
        color: var(--primary);
    }

    .tab-button.active {
        background: rgba(79, 70, 229, 0.1);
        color: var(--primary);
        font-weight: 600;
    }

    .tab-button i {
        font-size: 1.25rem;
        width: 24px;
        text-align: center;
    }

    .tab-pane {
        display: none;
        animation: fadeIn 0.3s ease-out;
    }

    .tab-pane.active {
        display: block;
    }

    .form-section-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--text-main);
    }
    
    .form-section-subtitle {
        color: var(--text-muted);
        margin-bottom: 2rem;
        font-size: 0.95rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-main);
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid var(--border);
        font-family: inherit;
        background: #F9FAFB;
        transition: all 0.2s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        background: var(--surface);
    }

    .color-picker-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    
    .color-input {
        width: 100%;
        height: 50px;
        padding: 0;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }
    
    .file-preview {
        max-width: 150px;
        max-height: 150px;
        margin-top: 1rem;
        border-radius: 8px;
        border: 1px solid var(--border);
        display: block;
        box-shadow: var(--shadow);
    }
    
    .toggle-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: rgba(79, 70, 229, 0.05);
        border-radius: 8px;
        border: 1px solid rgba(79, 70, 229, 0.1);
    }
    
    .toggle-checkbox {
        width: 20px;
        height: 20px;
        accent-color: var(--primary);
    }
    
    @media (max-width: 768px) {
        .settings-container {
            flex-direction: column;
        }
        .settings-sidebar {
            width: 100%;
            display: flex;
            overflow-x: auto;
            padding: 0.5rem;
        }
        .tab-button {
            width: auto;
            white-space: nowrap;
            margin-bottom: 0;
            margin-right: 0.5rem;
        }
    }
</style>
<link rel="stylesheet" href="{{ asset('Assets/vendor/flatpickr.min.css') }}">
@endsection

@section('content')
<div class="header-flex animate-fade-in">
    <div>
        <h2 style="margin: 0;">Pengaturan Sistem</h2>
        <p style="margin: 0.25rem 0 0 0; color: var(--text-muted);">Konfigurasi utama aplikasi e-Pilkasim</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <form action="{{ route('admin.optimize') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn btn-secondary" title="Bersihkan Cache & Optimalkan">
                <i class="fa-solid fa-bolt" style="color: #F59E0B;"></i>
            </button>
        </form>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="settings-container animate-fade-in" style="animation-delay: 0.1s;">
    <!-- Sidebar Menu -->
    <div class="settings-sidebar">
        <button class="tab-button active" onclick="openTab(event, 'tab-umum')">
            <i class="fa-solid fa-info-circle"></i> Informasi Umum
        </button>
        <button class="tab-button" onclick="openTab(event, 'tab-keamanan')">
            <i class="fa-solid fa-shield-halved"></i> Keamanan & Login
        </button>
        <button class="tab-button" onclick="openTab(event, 'tab-jadwal')">
            <i class="fa-solid fa-clock"></i> Jadwal Pemilihan
        </button>
        <button class="tab-button" onclick="openTab(event, 'tab-tema')">
            <i class="fa-solid fa-palette"></i> Tema & Warna
        </button>
        <button class="tab-button" onclick="openTab(event, 'tab-gambar')">
            <i class="fa-solid fa-images"></i> Gambar & Logo
        </button>
        <button class="tab-button" onclick="openTab(event, 'tab-seo')">
            <i class="fa-solid fa-magnifying-glass"></i> Meta SEO
        </button>
        <button class="tab-button" onclick="openTab(event, 'tab-tag')">
            <i class="fa-solid fa-tags"></i> Tag Dinamis
        </button>
    </div>

    <!-- Content Area -->
    <div class="settings-content">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
            @csrf
            
            <!-- INFORMASI UMUM -->
            <div id="tab-umum" class="tab-pane active">
                <div class="form-section-title">Informasi Umum</div>
                <div class="form-section-subtitle">Sesuaikan detail identitas sekolah dan instruksi pada halaman depan.</div>
                
                <div class="form-group">
                    <label>Nama Sekolah / Instansi</label>
                    <input type="text" name="school_name" class="form-control" value="{{ $setting->school_name }}" placeholder="Contoh: SMA Negeri 1 Jakarta">
                </div>
                
                <div class="form-group">
                    <label>Instruksi (Cara Memilih)</label>
                    <textarea name="instructions" class="form-control" rows="5" placeholder="Tuliskan petunjuk tata cara memilih di halaman depan...">{{ $setting->instructions }}</textarea>
                </div>
            </div>
            
            <!-- KEAMANAN & LOGIN -->
            <div id="tab-keamanan" class="tab-pane">
                <div class="form-section-title">Keamanan & Login</div>
                <div class="form-section-subtitle">Atur metode masuk pemilih dan proteksi layar Kiosk.</div>
                
                <div class="color-picker-grid">
                    <div class="form-group">
                        <label>Metode Login Pemilih</label>
                        <select name="login_method" class="form-control">
                            <option value="access_code" {{ ($setting->login_method ?? 'access_code') == 'access_code' ? 'selected' : '' }}>Kode Akses Saja</option>
                            <option value="username_password" {{ ($setting->login_method ?? 'access_code') == 'username_password' ? 'selected' : '' }}>Username dan Password</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Zona Waktu (Timezone)</label>
                        <select name="timezone" class="form-control">
                            <option value="Asia/Jakarta" {{ ($setting->timezone ?? 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (Jakarta)</option>
                            <option value="Asia/Makassar" {{ ($setting->timezone ?? 'Asia/Jakarta') == 'Asia/Makassar' ? 'selected' : '' }}>WITA (Makassar)</option>
                            <option value="Asia/Jayapura" {{ ($setting->timezone ?? 'Asia/Jakarta') == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (Jayapura)</option>
                        </select>
                    </div>
                </div>

                <div style="padding: 1.5rem; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; margin-top: 1rem;">
                    <h4 style="margin-top: 0; color: #0F172A;"><i class="fa-solid fa-desktop" style="margin-right: 0.5rem; color: var(--primary);"></i> Pengaturan Kiosk (Layar Monitor)</h4>
                    <div class="form-group" style="margin-top: 1rem;">
                        <label>PIN/Token Kunci Kiosk (6 Karakter)</label>
                        <div style="display: flex; gap: 0.5rem;">
                            <input type="text" name="kiosk_pin" id="kiosk_pin" value="{{ $setting->kiosk_pin }}" maxlength="6" class="form-control" placeholder="Kosongkan jika tidak ingin dikunci" style="font-family: monospace; font-size: 1.25rem; letter-spacing: 4px; font-weight: bold; text-align: center;">
                            <button type="button" class="btn btn-secondary" onclick="generateKioskPin()"><i class="fa-solid fa-dice"></i></button>
                        </div>
                        <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Jika diisi, Kiosk akan terkunci dan meminta PIN ini sebelum bisa menampilkan QR Code.</small>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Durasi Putaran Token QR (Detik)</label>
                        <input type="number" name="token_duration" value="{{ $setting->token_duration ?? 30 }}" min="5" max="3600" class="form-control" style="max-width: 150px;">
                    </div>
                </div>
            </div>
            
            <!-- JADWAL PEMILIHAN -->
            <div id="tab-jadwal" class="tab-pane">
                <div class="form-section-title">Jadwal Pemilihan</div>
                <div class="form-section-subtitle">Tentukan kapan sistem akan otomatis terbuka dan tertutup untuk pemilih.</div>
                
                <div class="color-picker-grid">
                    <div class="form-group">
                        <label>Waktu Buka / Mulai</label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-calendar-check" style="position: absolute; left: 1rem; top: 1rem; color: var(--primary);"></i>
                            <input type="text" class="flatpickr-datetime form-control" name="voting_start_time" value="{{ $setting->voting_start_time ? $setting->voting_start_time->format('Y-m-d H:i') : '' }}" style="padding-left: 2.5rem;" placeholder="Pilih tanggal & jam">
                        </div>
                        <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Kosongkan jika sistem ingin langsung dibuka sekarang.</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Waktu Tutup / Selesai</label>
                        <div style="position: relative;">
                            <i class="fa-solid fa-calendar-xmark" style="position: absolute; left: 1rem; top: 1rem; color: #EF4444;"></i>
                            <input type="text" class="flatpickr-datetime form-control" name="voting_end_time" value="{{ $setting->voting_end_time ? $setting->voting_end_time->format('Y-m-d H:i') : '' }}" style="padding-left: 2.5rem;" placeholder="Pilih tanggal & jam">
                        </div>
                        <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Kosongkan jika tidak ada batasan waktu penutupan otomatis.</small>
                    </div>
                </div>
            </div>
            
            <!-- TEMA & WARNA -->
            <div id="tab-tema" class="tab-pane">
                <div class="form-section-title">Tema & Warna</div>
                <div class="form-section-subtitle">Personalisasi warna antarmuka aplikasi.</div>
                
                <div class="toggle-wrapper" style="margin-bottom: 2rem;">
                    <input type="checkbox" name="use_gradient" id="use_gradient" class="toggle-checkbox" {{ $setting->use_gradient ? 'checked' : '' }} value="1">
                    <label for="use_gradient" style="margin: 0; font-weight: 600;">Gunakan Mode Gradien Halus (Warna 1 ke Warna 2)</label>
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
                        <label>Warna 5 (Tombol 1)</label>
                        <input type="color" name="theme_color_5" value="{{ $setting->theme_color_5 ?? '#f59e0b' }}" class="color-input">
                    </div>
                    <div class="form-group">
                        <label>Warna 6 (Tombol 2)</label>
                        <input type="color" name="theme_color_6" value="{{ $setting->theme_color_6 ?? '#d97706' }}" class="color-input">
                    </div>
                </div>
            </div>
            
            <!-- GAMBAR & LOGO -->
            <div id="tab-gambar" class="tab-pane">
                <div class="form-section-title">Gambar & Logo</div>
                <div class="form-section-subtitle">Unggah logo dan gambar sampul utama. Gunakan PNG dengan latar transparan untuk hasil terbaik.</div>
                
                <div class="color-picker-grid">
                    <div class="form-group">
                        <label>Logo Sekolah</label>
                        <input type="file" name="school_logo" accept="image/*" class="form-control">
                        @if($setting->school_logo)
                            <img src="{{ $setting->school_logo }}" class="file-preview" alt="Logo Sekolah">
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Logo OSIM</label>
                        <input type="file" name="osim_logo" accept="image/*" class="form-control">
                        @if($setting->osim_logo)
                            <img src="{{ $setting->osim_logo }}" class="file-preview" alt="Logo OSIM">
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Banner Utama (Dashboard/Login)</label>
                        <input type="file" name="main_image" accept="image/*" class="form-control">
                        @if($setting->main_image)
                            <img src="{{ $setting->main_image }}" class="file-preview" alt="Gambar Utama">
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- META SEO -->
            <div id="tab-seo" class="tab-pane">
                <div class="form-section-title">Meta SEO & OpenGraph</div>
                <div class="form-section-subtitle">Pengaturan ini akan digunakan oleh mesin pencari (seperti Google) dan saat link aplikasi dibagikan di WhatsApp atau platform sosial media lainnya.</div>
                
                <div class="form-group">
                    <label>Judul Tautan (Title)</label>
                    <input type="text" name="seo_title" value="{{ $setting->seo_title }}" placeholder="Contoh: Aplikasi Pilketos Terbaik" class="form-control">
                </div>

                <div class="form-group">
                    <label>Deskripsi (Description)</label>
                    <textarea name="seo_description" rows="3" class="form-control" placeholder="Deskripsi singkat tentang aplikasi (maksimal 160 karakter).">{{ $setting->seo_description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Gambar Cuplikan (OpenGraph Image)</label>
                    <input type="file" name="seo_image" accept="image/*" class="form-control">
                    <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Rekomendasi ukuran standar SEO: <strong>1200x630 piksel</strong>.</small>
                    @if($setting->seo_image)
                        <img src="{{ asset($setting->seo_image) }}" class="file-preview" alt="SEO Image" style="max-width: 300px; max-height: 200px;">
                    @endif
                </div>
            </div>
            
            <!-- TAG DINAMIS -->
            <div id="tab-tag" class="tab-pane">
                <div class="form-section-title">Tag Warna Dinamis</div>
                <div class="form-section-subtitle">Gunakan fitur ini jika Anda ingin mewarnai komponen tertentu. Anda bisa menggunakan kode warna HEX (contoh: <code>#ff0000</code>), warna transparan/opasitas (contoh: <code>rgba(255,0,0,0.5)</code>), atau warna gradien (contoh: <code>linear-gradient(to right, red, blue)</code>).</div>
                
                <div id="dynamic-tags-container">
                    @php $tags = is_array($setting->dynamic_color_tags) ? $setting->dynamic_color_tags : []; @endphp
                    @if(count($tags) > 0)
                        @foreach($tags as $index => $tagData)
                        <div class="dynamic-tag-row" style="display: flex; gap: 1rem; margin-bottom: 1rem; align-items: flex-end; background: #F8FAFC; padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border);">
                            <div style="flex: 2;">
                                <label style="font-size: 0.85rem;">Kata Kunci / Nama CSS Class</label>
                                <input type="text" name="dynamic_color_tags[{{$index}}][tag]" value="{{ $tagData['tag'] ?? '' }}" placeholder="Misal: btn-custom" class="form-control">
                            </div>
                            <div style="flex: 2;" class="bg-container-parent">
                                <label style="font-size: 0.85rem; display: flex; justify-content: space-between;">
                                    Warna Latar (BG)
                                    <span style="font-weight: normal; font-size: 0.75rem;">
                                        <input type="checkbox" name="dynamic_color_tags[{{$index}}][is_gradient]" value="1" {{ !empty($tagData['is_gradient']) ? 'checked' : '' }} onchange="this.closest('.bg-container-parent').querySelector('.gradient-options').style.display = this.checked ? 'flex' : 'none'"> Gradien
                                    </span>
                                </label>
                                <div style="display: flex; gap: 0.5rem; margin-bottom: 0.25rem; align-items: center;">
                                    <input type="color" style="height: 42px; width: 42px; padding: 0; border: 1px solid var(--border); border-radius: 4px; cursor: pointer; flex-shrink: 0;" value="{{ (isset($tagData['bg_color']) && preg_match('/^#[a-f0-9]{6,8}$/i', $tagData['bg_color'])) ? substr($tagData['bg_color'], 0, 7) : '#ffffff' }}" oninput="updateOpacityWithHex(this)">
                                    <input type="range" min="0" max="100" value="{{ (isset($tagData['bg_color']) && preg_match('/^#[a-f0-9]{8}$/i', $tagData['bg_color'])) ? round((hexdec(substr($tagData['bg_color'], 7, 2)) / 255) * 100) : 100 }}" style="width: 60px; flex-shrink: 0;" title="Opasitas" oninput="updateOpacityWithHex(this)">
                                    <input type="text" name="dynamic_color_tags[{{$index}}][bg_color]" value="{{ $tagData['bg_color'] ?? '#ffffff' }}" class="form-control" placeholder="#HEX / rgba()">
                                </div>
                                <div class="gradient-options" style="display: {{ !empty($tagData['is_gradient']) ? 'flex' : 'none' }}; gap: 0.5rem; align-items: center;">
                                    <input type="color" style="height: 42px; width: 42px; padding: 0; border: 1px solid var(--border); border-radius: 4px; cursor: pointer; flex-shrink: 0;" value="{{ (isset($tagData['bg_color_2']) && preg_match('/^#[a-f0-9]{6,8}$/i', $tagData['bg_color_2'])) ? substr($tagData['bg_color_2'], 0, 7) : '#ffffff' }}" oninput="updateOpacityWithHex(this)">
                                    <input type="range" min="0" max="100" value="{{ (isset($tagData['bg_color_2']) && preg_match('/^#[a-f0-9]{8}$/i', $tagData['bg_color_2'])) ? round((hexdec(substr($tagData['bg_color_2'], 7, 2)) / 255) * 100) : 100 }}" style="width: 60px; flex-shrink: 0;" title="Opasitas" oninput="updateOpacityWithHex(this)">
                                    <input type="text" name="dynamic_color_tags[{{$index}}][bg_color_2]" value="{{ $tagData['bg_color_2'] ?? '#ffffff' }}" class="form-control" placeholder="Warna 2">
                                </div>
                            </div>
                            <div style="flex: 2;">
                                <label style="font-size: 0.85rem;">Warna Teks</label>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input type="color" style="height: 42px; width: 42px; padding: 0; border: 1px solid var(--border); border-radius: 4px; cursor: pointer; flex-shrink: 0;" value="{{ (isset($tagData['text_color']) && preg_match('/^#[a-f0-9]{6,8}$/i', $tagData['text_color'])) ? substr($tagData['text_color'], 0, 7) : '#000000' }}" oninput="updateOpacityWithHex(this)">
                                    <input type="range" min="0" max="100" value="{{ (isset($tagData['text_color']) && preg_match('/^#[a-f0-9]{8}$/i', $tagData['text_color'])) ? round((hexdec(substr($tagData['text_color'], 7, 2)) / 255) * 100) : 100 }}" style="width: 60px; flex-shrink: 0;" title="Opasitas" oninput="updateOpacityWithHex(this)">
                                    <input type="text" name="dynamic_color_tags[{{$index}}][text_color]" value="{{ $tagData['text_color'] ?? '#000000' }}" class="form-control" placeholder="#HEX / rgba()">
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-danger" onclick="this.closest('.dynamic-tag-row').remove()" style="padding: 0.65rem 1rem;"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
                
                <button type="button" class="btn btn-secondary" onclick="addDynamicTagRow()" style="background: white;"><i class="fa-solid fa-plus"></i> Tambah Tag</button>
            </div>
            
            <hr style="border: none; border-top: 1px solid var(--border); margin: 2rem 0;">
            <button type="submit" class="btn" style="width: 100%; padding: 1rem; font-size: 1.1rem; border-radius: 8px;"><i class="fa-solid fa-save"></i> Simpan Semua Pengaturan</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('Assets/vendor/flatpickr.min.js') }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
    function openTab(evt, tabId) {
        // Hide all tab panes
        let tabPanes = document.getElementsByClassName("tab-pane");
        for (let i = 0; i < tabPanes.length; i++) {
            tabPanes[i].classList.remove("active");
        }

        // Remove active class from all tab buttons
        let tabButtons = document.getElementsByClassName("tab-button");
        for (let i = 0; i < tabButtons.length; i++) {
            tabButtons[i].classList.remove("active");
        }

        // Show current tab pane and add active class to clicked button
        document.getElementById(tabId).classList.add("active");
        if (evt) {
            evt.currentTarget.classList.add("active");
        } else {
            let btn = document.querySelector(`button[onclick*="${tabId}"]`);
            if (btn) btn.classList.add("active");
        }
        
        sessionStorage.setItem('activeSettingsTab', tabId);
    }

    let tagIndex = {{ is_array($setting->dynamic_color_tags) ? count($setting->dynamic_color_tags) : 0 }};
    function addDynamicTagRow() {
        const container = document.getElementById('dynamic-tags-container');
        const row = document.createElement('div');
        row.className = 'dynamic-tag-row';
        row.style.cssText = 'display: flex; gap: 1rem; margin-bottom: 1rem; align-items: flex-end; background: #F8FAFC; padding: 1.5rem; border-radius: 8px; border: 1px solid var(--border);';
        
        row.innerHTML = `
            <div style="flex: 2;">
                <label style="font-size: 0.85rem;">Kata Kunci / Nama CSS Class</label>
                <input type="text" name="dynamic_color_tags[${tagIndex}][tag]" placeholder="Misal: btn-custom" class="form-control">
            </div>
            <div style="flex: 2;" class="bg-container-parent">
                <label style="font-size: 0.85rem; display: flex; justify-content: space-between;">
                    Warna Latar (BG)
                    <span style="font-weight: normal; font-size: 0.75rem;">
                        <input type="checkbox" name="dynamic_color_tags[${tagIndex}][is_gradient]" value="1" onchange="this.closest('.bg-container-parent').querySelector('.gradient-options').style.display = this.checked ? 'flex' : 'none'"> Gradien
                    </span>
                </label>
                <div style="display: flex; gap: 0.5rem; margin-bottom: 0.25rem; align-items: center;">
                    <input type="color" style="height: 42px; width: 42px; padding: 0; border: 1px solid var(--border); border-radius: 4px; cursor: pointer; flex-shrink: 0;" value="#ffffff" oninput="updateOpacityWithHex(this)">
                    <input type="range" min="0" max="100" value="100" style="width: 60px; flex-shrink: 0;" title="Opasitas" oninput="updateOpacityWithHex(this)">
                    <input type="text" name="dynamic_color_tags[${tagIndex}][bg_color]" value="#ffffff" class="form-control" placeholder="#HEX / rgba()">
                </div>
                <div class="gradient-options" style="display: none; gap: 0.5rem; align-items: center;">
                    <input type="color" style="height: 42px; width: 42px; padding: 0; border: 1px solid var(--border); border-radius: 4px; cursor: pointer; flex-shrink: 0;" value="#ffffff" oninput="updateOpacityWithHex(this)">
                    <input type="range" min="0" max="100" value="100" style="width: 60px; flex-shrink: 0;" title="Opasitas" oninput="updateOpacityWithHex(this)">
                    <input type="text" name="dynamic_color_tags[${tagIndex}][bg_color_2]" value="#ffffff" class="form-control" placeholder="Warna 2">
                </div>
            </div>
            <div style="flex: 2;">
                <label style="font-size: 0.85rem;">Warna Teks</label>
                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <input type="color" style="height: 42px; width: 42px; padding: 0; border: 1px solid var(--border); border-radius: 4px; cursor: pointer; flex-shrink: 0;" value="#000000" oninput="updateOpacityWithHex(this)">
                    <input type="range" min="0" max="100" value="100" style="width: 60px; flex-shrink: 0;" title="Opasitas" oninput="updateOpacityWithHex(this)">
                    <input type="text" name="dynamic_color_tags[${tagIndex}][text_color]" value="#000000" class="form-control" placeholder="#HEX / rgba()">
                </div>
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
        let activeTab = sessionStorage.getItem('activeSettingsTab');
        if (activeTab && document.getElementById(activeTab)) {
            openTab(null, activeTab);
        }
        
        flatpickr(".flatpickr-datetime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            locale: "id", // Bahasa Indonesia
            allowInput: true
        });
    });
    
    function updateOpacityWithHex(el) {
        let container = el.parentElement;
        let colorPicker = container.querySelector('input[type="color"]');
        let range = container.querySelector('input[type="range"]');
        let text = container.querySelector('input[type="text"]');
        
        if (!colorPicker || !range || !text) return;
        
        let hex = colorPicker.value;
        let opacity = parseInt(range.value);
        if (opacity < 100) {
            let alpha = Math.round((opacity / 100) * 255).toString(16).padStart(2, '0');
            text.value = hex + alpha;
        } else {
            text.value = hex;
        }
    }
</script>
@endsection
