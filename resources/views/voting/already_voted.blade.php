@extends('layouts.app')

@section('styles')
<style>
    .message-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 100px);
    }
    
    .message-card {
        width: 100%;
        max-width: 500px;
        text-align: center;
    }
    
    .message-icon {
        font-size: 4rem;
        color: var(--secondary);
        margin-bottom: 1.5rem;
    }
    
    .message-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .message-subtitle {
        color: var(--text-muted);
        margin-bottom: 2rem;
    }
</style>
@endsection

@section('content')
<div class="message-container">
    <div class="card message-card animate-fade-in">
        <i class="fa-solid fa-circle-check message-icon"></i>
        <h1 class="message-title">Terima Kasih, {{ $voter->name }}!</h1>
        <p class="message-subtitle">Anda telah menggunakan hak suara Anda dalam pemilihan ini. Suara Anda sangat berarti.</p>
        
        <p id="countdown-text" style="font-weight: 600; color: #d97706; margin-bottom: 1.5rem;">Sistem akan logout otomatis dalam <span id="countdown-number">7</span> detik...</p>
        
        <form action="{{ route('voter.logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="submit" class="btn btn-secondary">Logout Sekarang</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let seconds = 7;
        const countdownEl = document.getElementById('countdown-number');
        const formEl = document.getElementById('logout-form');
        
        const interval = setInterval(function() {
            seconds--;
            countdownEl.innerText = seconds;
            
            if (seconds <= 0) {
                clearInterval(interval);
                formEl.submit();
            }
        }, 1000);
    });
</script>
@endsection
