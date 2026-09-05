@extends('install.layout')

@section('content')
    <h2 style="margin-top: 0; font-size: 1.25rem;">Persyaratan Server</h2>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Pastikan server Anda memenuhi persyaratan berikut sebelum melanjutkan instalasi.</p>
    
    <ul class="list-group">
        @foreach($requirements as $req => $passed)
            <li class="list-group-item">
                <span>{{ $req }}</span>
                @if($passed)
                    <span style="color: var(--success);"><i class="fa-solid fa-check-circle"></i> Memenuhi</span>
                @else
                    <span style="color: var(--danger);"><i class="fa-solid fa-times-circle"></i> Tidak Memenuhi</span>
                @endif
            </li>
        @endforeach
    </ul>
    
    <h2 style="font-size: 1.25rem; margin-top: 2rem;">Izin Direktori</h2>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Pastikan direktori berikut memiliki izin tulis (writable).</p>
    
    <ul class="list-group">
        @foreach($permissions as $dir => $passed)
            <li class="list-group-item">
                <span>{{ $dir }}</span>
                @if($passed)
                    <span style="color: var(--success);"><i class="fa-solid fa-check-circle"></i> Writable</span>
                @else
                    <span style="color: var(--danger);"><i class="fa-solid fa-times-circle"></i> Not Writable</span>
                @endif
            </li>
        @endforeach
    </ul>
    
    @if($allRequirementsMet)
        <div style="text-align: right; margin-top: 2rem;">
            <a href="{{ route('install.database') }}" class="btn btn-primary">Lanjutkan <i class="fa-solid fa-arrow-right" style="margin-left: 0.5rem;"></i></a>
        </div>
    @else
        <div class="alert alert-danger" style="margin-top: 2rem;">
            <i class="fa-solid fa-triangle-exclamation"></i> Harap penuhi semua persyaratan di atas sebelum melanjutkan.
        </div>
        <div style="text-align: right;">
            <a href="{{ route('install.index') }}" class="btn" style="background: #e5e7eb; color: #4b5563;">Muat Ulang</a>
        </div>
    @endif
@endsection
