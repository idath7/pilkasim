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
</style>
@endsection

@section('content')
<div class="dashboard-header animate-fade-in">
    <h2>Dashboard Admin</h2>
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <a href="{{ route('admin.voters') }}" class="btn btn-secondary"><i class="fa-solid fa-users"></i> Pemilih</a>
        <a href="{{ route('admin.candidates') }}" class="btn btn-secondary"><i class="fa-solid fa-user-tie"></i> Kandidat</a>
        <a href="{{ route('admin.settings') }}" class="btn btn-secondary"><i class="fa-solid fa-gear"></i> Pengaturan</a>
        <a href="{{ route('admin.dashboard') }}" class="btn"><i class="fa-solid fa-rotate-right"></i> Refresh</a>
    </div>
</div>

<div class="card animate-fade-in" style="margin-bottom: 2rem; padding: 1.5rem; background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
        <div style="flex: 1;">
            <h3 style="margin-top: 0; color: white;">Link Login & Layar Kiosk</h3>
            <p style="opacity: 0.9; margin-bottom: 0;">Gunakan fitur Kiosk untuk menampilkan QR Code di layar besar, atau salin link login langsung jika diperlukan.</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('kiosk') }}" target="_blank" class="btn btn-secondary" style="background: white; color: var(--primary); border: none;">
                <i class="fa-solid fa-desktop"></i> Buka Kiosk
            </a>
            <button onclick="copyKioskLink()" class="btn btn-secondary" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.4);">
                <i class="fa-solid fa-link"></i> Salin URL Kiosk
            </button>
        </div>
    </div>
    
    <div style="display: flex; align-items: center; gap: 1rem; margin-top: 1rem; background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 8px;">
        <div style="flex: 1; font-family: monospace; font-size: 1.25rem; font-weight: bold; overflow-x: auto; white-space: nowrap;" id="dynamic-login-link">
            Memuat link...
        </div>
        <div style="text-align: center; background: rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 8px;">
            <div style="font-size: 1.5rem; font-weight: bold;" id="dynamic-login-timer">30</div>
            <div style="font-size: 0.75rem;">Detik</div>
        </div>
        <button onclick="copyLoginLink()" class="btn btn-secondary" style="background: white; color: var(--primary); border: none; white-space: nowrap;">
            <i class="fa-solid fa-copy"></i> Salin
        </button>
    </div>
</div>

<div class="stat-grid animate-fade-in" style="animation-delay: 0.1s">
    <div class="card stat-card">
        <i class="fa-solid fa-users stat-icon"></i>
        <div>
            <div class="stat-value">{{ $totalVoters }}</div>
            <div class="stat-label">Total Pemilih</div>
        </div>
    </div>
    
    <div class="card stat-card">
        <i class="fa-solid fa-check-to-slot stat-icon" style="color: var(--secondary)"></i>
        <div>
            <div class="stat-value">{{ $votedCount }}</div>
            <div class="stat-label">Sudah Memilih</div>
        </div>
    </div>
    
    <div class="card stat-card">
        <i class="fa-solid fa-clock-rotate-left stat-icon" style="color: #F59E0B"></i>
        <div>
            <div class="stat-value">{{ $unvotedCount }}</div>
            <div class="stat-label">Belum Memilih</div>
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
@endsection

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
