@extends('layouts.app')

@section('styles')
<style>
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .stat-icon {
        font-size: 2.5rem;
        color: var(--primary);
        opacity: 0.8;
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        color: var(--text-muted);
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .result-card {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        gap: 1.5rem;
    }
    
    .result-photo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        object-position: top center;
        background-color: #E5E7EB;
    }
    
    .result-info {
        flex: 1;
    }
    
    .result-name {
        font-weight: 700;
        font-size: 1.125rem;
        margin-bottom: 0.25rem;
    }
    
    .progress-bar {
        width: 100%;
        height: 8px;
        background-color: var(--border);
        border-radius: 4px;
        margin-top: 0.75rem;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background-color: var(--primary);
        border-radius: 4px;
        transition: width 1s ease-in-out;
    }

    @media (max-width: 768px) {
        .token-url-row {
            flex-direction: column;
            align-items: stretch !important;
            gap: 0.75rem !important;
        }
        #dynamic-login-link {
            font-size: 0.75rem !important;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        .token-actions {
            display: flex;
            justify-content: center;
            width: 100%;
        }
        .kiosk-buttons {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr);
            width: 100%;
            gap: 0.5rem;
        }
        .kiosk-buttons .btn {
            padding: 0.5rem 0.25rem;
            font-size: 0.7rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            text-align: center;
        }
        .kiosk-buttons .btn i {
            font-size: 1.25rem;
            margin: 0;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-header animate-fade-in">
    <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
        <div>
            <h2 style="margin: 0;">Dashboard Admin</h2>
            <p style="margin: 0.25rem 0 0 0; color: var(--text-muted);">Halo, {{ Auth::guard('admin')->user()->name ?? 'Administrator' }}</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn" style="padding: 0.5rem 1rem;"><i class="fa-solid fa-rotate-right"></i> Refresh</a>
    </div>
</div>

<div class="card animate-fade-in" style="margin-bottom: 2rem; padding: 1.5rem; background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
        <div style="flex: 1;">
            <h3 style="margin-top: 0; color: white;">Link Login & Layar Kiosk</h3>
            <p style="opacity: 0.9; margin-bottom: 0;">Gunakan fitur Kiosk untuk menampilkan QR Code di layar besar, atau salin link login langsung jika diperlukan.</p>
        </div>
        <div class="kiosk-buttons" style="display: flex; gap: 0.5rem; flex-wrap: wrap; justify-content: flex-end;">
            <a href="{{ route('kiosk') }}" target="_blank" class="btn btn-secondary" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.4);">
                <i class="fa-solid fa-desktop"></i> Buka Kiosk
            </a>
            <button onclick="document.getElementById('qrModal').style.display='block'" class="btn btn-secondary" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.4);">
                <i class="fa-solid fa-qrcode"></i> QR Website
            </button>
            <button onclick="copyKioskLink()" class="btn btn-secondary" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.4);">
                <i class="fa-solid fa-link"></i> Salin Kiosk
            </button>
        </div>
    </div>
    
    <div class="token-url-row" style="display: flex; align-items: center; gap: 1rem; margin-top: 1rem; background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 8px;">
        <div style="flex: 1; font-family: monospace; font-size: 0.85rem; font-weight: bold; overflow-x: auto; white-space: nowrap;" id="dynamic-login-link">
            Memuat link...
        </div>
        <div class="token-actions" style="display: flex; align-items: center; gap: 0.5rem;">
            <div style="text-align: center; background: rgba(255,255,255,0.2); border-radius: 8px; width: 72px; height: 72px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <div style="font-size: 1.5rem; font-weight: bold; line-height: 1;" id="dynamic-login-timer">30</div>
                <div style="font-size: 0.75rem; margin-top: 4px;">Detik</div>
            </div>
            <button onclick="copyLoginLink()" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.4); border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; width: 72px; height: 72px; line-height: 1; padding: 0;">
                <div style="font-size: 1.25rem; margin-bottom: 4px;"><i class="fa-solid fa-copy"></i></div>
                <div style="font-size: 0.75rem; font-weight: normal;">Salin</div>
            </button>
        </div>
    </div>
</div>

<div class="stat-grid animate-fade-in" style="animation-delay: 0.1s">
    <div class="card stat-card">
        <i class="fa-solid fa-users stat-icon"></i>
        <div>
            <div class="stat-value">{{ $totalStudentVoters + $totalTeacherVoters }}</div>
            <div class="stat-label">Total Pemilih ({{ $totalStudentVoters }} Siswa, {{ $totalTeacherVoters }} Guru)</div>
        </div>
    </div>
    
    <div class="card stat-card">
        <i class="fa-solid fa-check-to-slot stat-icon" style="color: var(--secondary)"></i>
        <div>
            <div class="stat-value">{{ $votedStudentCount + $votedTeacherCount }}</div>
            <div class="stat-label">Sudah Memilih ({{ $votedStudentCount }} Siswa, {{ $votedTeacherCount }} Guru)</div>
        </div>
    </div>
    
    <div class="card stat-card">
        <i class="fa-solid fa-clock-rotate-left stat-icon" style="color: #F59E0B"></i>
        <div>
            <div class="stat-value">{{ $unvotedStudentCount + $unvotedTeacherCount }}</div>
            <div class="stat-label">Belum Memilih ({{ $unvotedStudentCount }} Siswa, {{ $unvotedTeacherCount }} Guru)</div>
        </div>
    </div>
</div>

<h3 style="margin-bottom: 1rem;" class="animate-fade-in">Perolehan Suara Real-time</h3>

<div class="results-grid animate-fade-in" style="animation-delay: 0.2s">
    @foreach($candidates->sortByDesc('votes') as $candidate)
        <div class="card result-card">
            @php
                $photoPath = str_replace('../Assets', '/Assets', $candidate->photo);
                $percentage = $votedCount > 0 ? round(($candidate->votes / $votedCount) * 100, 1) : 0;
            @endphp
            <img src="{{ $photoPath }}" alt="{{ $candidate->name }}" class="result-photo" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($candidate->name) }}&background=4F46E5&color=fff'">
            
            <div class="result-info">
                <div class="result-name">{{ $candidate->name }}</div>
                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <span style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">{{ $candidate->votes }} Suara</span>
                    <span style="font-weight: 600; color: var(--text-muted);">{{ $percentage }}%</span>
                </div>
                
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 0%;" data-width="{{ $percentage }}%"></div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="animate-fade-in" style="animation-delay: 0.3s; margin-top: 3rem;">
    <div style="display: flex; align-items: center; text-align: center; color: var(--text-muted); margin-bottom: 2rem;">
        <div style="flex: 1; border-bottom: 1px dashed var(--border);"></div>
        <span style="padding: 0 1rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-size: 0.85rem;"><i class="fa-solid fa-compass"></i> Menu Navigasi Admin</span>
        <div style="flex: 1; border-bottom: 1px dashed var(--border);"></div>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <a href="{{ route('admin.voters') }}" class="card" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem 1rem; text-decoration: none; transition: all 0.3s ease; text-align: center; border: 1px solid var(--border);">
            <div style="width: 60px; height: 60px; background: rgba(79, 70, 229, 0.1); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin-bottom: 1rem;">
                <i class="fa-solid fa-users"></i>
            </div>
            <h4 style="margin: 0; color: var(--text);">Kelola Pemilih (Siswa)</h4>
            <p style="margin: 0.5rem 0 0 0; font-size: 0.85rem; color: var(--text-muted);">Data siswa & cetak kartu</p>
        </a>
        
        <a href="{{ route('admin.teachers') }}" class="card" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem 1rem; text-decoration: none; transition: all 0.3s ease; text-align: center; border: 1px solid var(--border);">
            <div style="width: 60px; height: 60px; background: rgba(16, 185, 129, 0.1); color: #10B981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin-bottom: 1rem;">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <h4 style="margin: 0; color: var(--text);">Kelola Pemilih (Guru)</h4>
            <p style="margin: 0.5rem 0 0 0; font-size: 0.85rem; color: var(--text-muted);">Data guru & hak suara</p>
        </a>
        
        <a href="{{ route('admin.candidates') }}" class="card" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem 1rem; text-decoration: none; transition: all 0.3s ease; text-align: center; border: 1px solid var(--border);">
            <div style="width: 60px; height: 60px; background: rgba(245, 158, 11, 0.1); color: #F59E0B; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin-bottom: 1rem;">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <h4 style="margin: 0; color: var(--text);">Kandidat Ketua</h4>
            <p style="margin: 0.5rem 0 0 0; font-size: 0.85rem; color: var(--text-muted);">Visi, misi, dan foto calon</p>
        </a>
        
        <a href="{{ route('admin.settings') }}" class="card" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem 1rem; text-decoration: none; transition: all 0.3s ease; text-align: center; border: 1px solid var(--border);">
            <div style="width: 60px; height: 60px; background: rgba(107, 114, 128, 0.1); color: #6B7280; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin-bottom: 1rem;">
                <i class="fa-solid fa-gear"></i>
            </div>
            <h4 style="margin: 0; color: var(--text);">Pengaturan Sistem</h4>
            <p style="margin: 0.5rem 0 0 0; font-size: 0.85rem; color: var(--text-muted);">Tema, jadwal, dan SEO</p>
        </a>
    </div>

    <div style="margin-top: 2rem; display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
        <button type="button" class="btn btn-secondary" onclick="showChangePasswordModal()"><i class="fa-solid fa-key"></i> Ganti Password</button>
        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger" style="border: none; color: white;"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
        </form>
    </div>
</div>
@endsection

<!-- Modal QR Code -->
<div id="qrModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
    <div class="modal-content" style="background-color: var(--surface); margin: 10% auto; padding: 2rem; border-radius: var(--radius); max-width: 400px; position: relative; box-shadow: var(--shadow-lg); text-align: center;">
        <span class="close-btn" onclick="document.getElementById('qrModal').style.display='none'" style="position: absolute; top: 1rem; right: 1.5rem; font-size: 1.5rem; font-weight: bold; cursor: pointer; color: var(--text-muted);">&times;</span>
        <h3 style="margin-bottom: 1rem;">QR Code Website</h3>
        <p style="margin-bottom: 1.5rem; color: var(--text-muted);">Siswa dapat men-scan QR Code ini dari HP mereka untuk langsung membuka website pemilihan.</p>
        
        <div style="background: white; padding: 1rem; display: inline-block; border-radius: 8px; margin-bottom: 1rem; border: 1px solid var(--border);">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode(url('/')) }}" alt="QR Code" style="width: 250px; height: 250px; display: block;">
        </div>
        
        <div style="font-family: monospace; font-size: 1rem; font-weight: bold; word-break: break-all; background: #f3f4f6; padding: 0.75rem; border-radius: var(--radius);">
            {{ url('/') }}
        </div>
    </div>
</div>

@section('scripts')
<script>
    let currentLinkUrl = '';
    let tokenTimer;
    
    function fetchCurrentToken() {
        fetch('{{ route("kiosk.token") }}')
            .then(res => res.json())
            .then(data => {
                document.getElementById('dynamic-login-link').innerText = data.url;
                currentLinkUrl = data.url;
                startTimer(data.remaining);
            })
            .catch(err => console.error('Gagal mengambil token', err));
    }

    function startTimer(seconds) {
        clearInterval(tokenTimer);
        let remaining = seconds;
        document.getElementById('dynamic-login-timer').innerText = remaining;
        
        tokenTimer = setInterval(() => {
            remaining--;
            if (remaining <= 0) {
                clearInterval(tokenTimer);
                document.getElementById('dynamic-login-timer').innerText = 0;
                fetchCurrentToken();
            } else {
                document.getElementById('dynamic-login-timer').innerText = remaining;
            }
        }, 1000);
    }

    function copyLoginLink() {
        if (currentLinkUrl) {
            navigator.clipboard.writeText(currentLinkUrl);
            alert('Link login berhasil disalin!');
        }
    }

    function copyKioskLink() {
        const kioskUrl = '{{ route("kiosk") }}';
        navigator.clipboard.writeText(kioskUrl);
        alert('URL Kiosk berhasil disalin: ' + kioskUrl);
    }

    document.addEventListener("DOMContentLoaded", function() {
        fetchCurrentToken();
        
        // Animate progress bars
        setTimeout(() => {
            document.querySelectorAll('.progress-fill').forEach(bar => {
                bar.style.width = bar.getAttribute('data-width');
            });
        }, 300);
    });
</script>
@endsection
