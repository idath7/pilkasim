@extends('layouts.app')

@section('styles')
<link href="{{ asset('Assets/vendor/quill.snow.css') }}" rel="stylesheet">
<style>
    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .candidates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .candidate-card {
        display: flex;
        align-items: stretch;
        padding: 0;
        gap: 0;
        overflow: hidden;
    }
    
    .candidate-photo {
        width: 140px;
        min-height: 120px;
        height: auto;
        object-fit: cover;
        object-position: top center;
        background-color: var(--surface);
        padding: 2px;
        border-radius: 12px 0 0 12px; /* Melengkung di sisi kiri mengikuti kartu */
    }
    
    .candidate-info {
        flex: 1;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
    }
    
    .modal-content {
        background-color: var(--surface);
        margin: 5% auto;
        padding: 2rem;
        border-radius: var(--radius);
        max-width: 600px;
        position: relative;
        box-shadow: var(--shadow-lg);
    }
    
    .close-btn {
        position: absolute;
        top: 1rem;
        right: 1.5rem;
        font-size: 1.5rem;
        font-weight: bold;
        cursor: pointer;
        color: var(--text-muted);
    }
    
    .ql-editor {
        min-height: 120px;
    }
</style>
@endsection

@section('content')
<div class="header-flex animate-fade-in">
    <h2>Kelola Kandidat</h2>
    <div>
        <button onclick="document.getElementById('addCandidateModal').style.display='block'" class="btn"><i class="fa-solid fa-plus"></i> Tambah Kandidat</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    </div>
</div>

<div class="candidates-grid animate-fade-in" style="animation-delay: 0.1s;">
    @foreach($candidates as $candidate)
        <div class="card candidate-card" style="position: relative;">
            <div class="candidate-actions" style="position: absolute; top: 1rem; right: 1rem; display: flex; flex-direction: column; gap: 0.5rem; z-index: 10;">
                <button onclick="openEditModal({{ $candidate->id }}, '{{ addslashes($candidate->name) }}', '{{ addslashes($candidate->class_name) }}', '{{ addslashes($candidate->organization) }}', `{{ base64_encode($candidate->vision) }}`, `{{ base64_encode($candidate->mission) }}`)" class="btn btn-secondary" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; background-color: rgba(255,255,255,0.9); color: var(--primary);"><i class="fa-solid fa-pen"></i> Edit</button>
                <form action="{{ route('admin.candidates.destroy', $candidate->id) }}" method="POST" id="delete-form-{{ $candidate->id }}">
                    @csrf
                    <button type="button" onclick="confirmDelete({{ $candidate->id }}, '{{ addslashes($candidate->name) }}')" class="btn" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; background-color: #ef4444; color: white; border: none;"><i class="fa-solid fa-trash"></i> Hapus</button>
                </form>
            </div>
            @php
                $photoPath = str_replace('../Assets', '/Assets', $candidate->photo);
            @endphp
            <img src="{{ $photoPath }}" alt="{{ $candidate->name }}" class="candidate-photo" onerror="this.src='{{ asset('Assets/images/default-avatar.svg') }}'">
            
            <div class="candidate-info">
                <div style="font-weight: 700; font-size: 1.125rem;">{{ $candidate->name }}</div>
                <div style="color: var(--text-muted); font-size: 0.875rem; margin-bottom: 0.5rem;">{{ $candidate->class_name }} | {{ $candidate->organization }}</div>
                <div><span class="badge" style="background: var(--primary); color: white; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">{{ $candidate->votes }} Suara</span></div>
            </div>
        </div>
    @endforeach
</div>

<!-- Modal Tambah Kandidat -->
<div id="addCandidateModal" class="modal">
    <div class="modal-content" style="max-width: 800px;">
        <span class="close-btn" onclick="document.getElementById('addCandidateModal').style.display='none'">&times;</span>
        <h3 style="margin-bottom: 1.5rem;">Tambah Kandidat Baru</h3>
        
        <form action="{{ route('admin.candidates.store') }}" method="POST" enctype="multipart/form-data" id="candidateForm">
            @csrf
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem;">
                <!-- Kolom Kiri -->
                <div>
                    <div class="form-group" style="background: #f9fafb; padding: 1rem; border-radius: var(--radius); margin-bottom: 1rem; border: 1px solid var(--border);">
                        <label>Pilih dari Data Pemilih (Opsional)</label>
                        
                        <!-- Custom Searchable Dropdown -->
                        <div class="custom-select-wrapper" style="position: relative; margin-top: 0.5rem;">
                            <div class="custom-select-trigger" onclick="toggleDropdown()" style="padding: 0.75rem; background: white; border: 1px solid var(--border); border-radius: var(--radius); cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                                <span id="custom-select-text">-- Cari atau pilih siswa --</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            
                            <div class="custom-options-container" id="custom-options" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid var(--border); border-radius: var(--radius); margin-top: 0.25rem; box-shadow: var(--shadow-lg); z-index: 100; max-height: 250px; overflow-y: auto;">
                                <div style="padding: 0.5rem; position: sticky; top: 0; background: white; border-bottom: 1px solid var(--border);">
                                    <input type="text" id="voterSearchInput" onkeyup="filterVoters()" placeholder="Ketik nama siswa..." style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: var(--radius);">
                                </div>
                                
                                <div class="custom-option" onclick="selectVoter('', '-- Cari atau pilih siswa --')" style="padding: 0.75rem; cursor: pointer; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: space-between;">
                                    <span>Reset Pilihan / Ketik Manual</span>
                                </div>
                                
                                @foreach($voters as $voter)
                                <div class="custom-option voter-option" data-name="{{ strtolower($voter->name) }}" onclick="selectVoter('{{ addslashes($voter->name) }}|{{ addslashes($voter->class_name) }}', '{{ addslashes($voter->name) }} ({{ addslashes($voter->class_name) }})', this)" style="padding: 0.75rem; cursor: pointer; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; justify-content: space-between; transition: all 0.2s;">
                                    <span>{{ $voter->name }} <small style="color: var(--text-muted);">({{ $voter->class_name }})</small></span>
                                    <i class="fa-solid fa-check check-icon" style="color: var(--primary); display: none;"></i>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- End Custom Searchable Dropdown -->
                        
                        <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">Siswa yang sudah menjadi kandidat tidak akan muncul di daftar ini.</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Nama Calon</label>
                        <input type="text" name="name" id="addName" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="class_name" id="addClassName" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Organisasi (Opsional)</label>
                        <input type="text" name="organization">
                    </div>
                    
                    <div class="form-group">
                        <label>Foto Calon (Opsional)</label>
                        <input type="file" name="photo" accept="image/*" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: var(--radius);">
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div>
                    <div class="form-group">
                        <label>Visi</label>
                        <input type="hidden" name="vision" id="visionInput">
                        <div id="visionEditor"></div>
                    </div>
                    
                    <div class="form-group">
                        <label>Misi</label>
                        <input type="hidden" name="mission" id="missionInput">
                        <div id="missionEditor"></div>
                    </div>
                </div>
            </div>
            
            <div style="margin-top: 1.5rem;">
                <button type="submit" class="btn" style="width: 100%;">Simpan Kandidat</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Kandidat -->
<div id="editCandidateModal" class="modal">
    <div class="modal-content" style="max-width: 800px;">
        <span class="close-btn" onclick="document.getElementById('editCandidateModal').style.display='none'">&times;</span>
        <h3 style="margin-bottom: 1.5rem;">Edit Kandidat</h3>
        
        <form action="" method="POST" enctype="multipart/form-data" id="editCandidateForm">
            @csrf
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 1.5rem;">
                <!-- Kolom Kiri -->
                <div>
                    <div class="form-group">
                        <label>Nama Calon</label>
                        <input type="text" name="name" id="editName" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="class_name" id="editClassName" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Organisasi (Opsional)</label>
                        <input type="text" name="organization" id="editOrganization">
                    </div>
                    
                    <div class="form-group">
                        <label>Foto Calon (Biarkan kosong jika tidak diganti)</label>
                        <input type="file" name="photo" accept="image/*" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: var(--radius);">
                    </div>
                </div>
                
                <!-- Kolom Kanan -->
                <div>
                    <div class="form-group">
                        <label>Visi</label>
                        <input type="hidden" name="vision" id="editVisionInput">
                        <div id="editVisionEditor"></div>
                    </div>
                    
                    <div class="form-group">
                        <label>Misi</label>
                        <input type="hidden" name="mission" id="editMissionInput">
                        <div id="editMissionEditor"></div>
                    </div>
                </div>
            </div>
            
            <div style="margin-top: 1.5rem;">
                <button type="submit" class="btn" style="width: 100%;">Update Kandidat</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('Assets/vendor/quill.js') }}"></script>
<script>
    var toolbarOptions = [
        ['bold', 'italic', 'underline'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['clean']
    ];

    var visionEditor = new Quill('#visionEditor', {
        theme: 'snow',
        modules: { toolbar: toolbarOptions }
    });
    
    var missionEditor = new Quill('#missionEditor', {
        theme: 'snow',
        modules: { toolbar: toolbarOptions }
    });

    var editVisionEditor = new Quill('#editVisionEditor', {
        theme: 'snow',
        modules: { toolbar: toolbarOptions }
    });
    
    var editMissionEditor = new Quill('#editMissionEditor', {
        theme: 'snow',
        modules: { toolbar: toolbarOptions }
    });

    document.getElementById('candidateForm').onsubmit = function() {
        var visionHtml = visionEditor.root.innerHTML;
        var missionHtml = missionEditor.root.innerHTML;
        
        if (visionEditor.getText().trim().length === 0) visionHtml = '';
        if (missionEditor.getText().trim().length === 0) missionHtml = '';
        
        document.getElementById('visionInput').value = visionHtml;
        document.getElementById('missionInput').value = missionHtml;
        
        if(visionHtml == '' || missionHtml == '') {
            alert('Visi dan Misi harus diisi!');
            return false;
        }
        return true;
    };
    
    document.getElementById('editCandidateForm').onsubmit = function() {
        var visionHtml = editVisionEditor.root.innerHTML;
        var missionHtml = editMissionEditor.root.innerHTML;
        
        if (editVisionEditor.getText().trim().length === 0) visionHtml = '';
        if (editMissionEditor.getText().trim().length === 0) missionHtml = '';
        
        document.getElementById('editVisionInput').value = visionHtml;
        document.getElementById('editMissionInput').value = missionHtml;
        
        if(visionHtml == '' || missionHtml == '') {
            alert('Visi dan Misi harus diisi!');
            return false;
        }
        return true;
    };
    
    function openEditModal(id, name, className, organization, visionBase64, missionBase64) {
        document.getElementById('editCandidateForm').action = "/admin/candidates/" + id + "/update";
        document.getElementById('editName').value = name;
        document.getElementById('editClassName').value = className;
        document.getElementById('editOrganization').value = organization;
        
        editVisionEditor.root.innerHTML = atob(visionBase64);
        editMissionEditor.root.innerHTML = atob(missionBase64);
        
        document.getElementById('editCandidateModal').style.display = 'block';
    }

    function toggleDropdown() {
        var options = document.getElementById('custom-options');
        options.style.display = options.style.display === 'block' ? 'none' : 'block';
        if(options.style.display === 'block') {
            document.getElementById('voterSearchInput').focus();
        }
    }

    function filterVoters() {
        var input = document.getElementById('voterSearchInput').value.toLowerCase();
        var options = document.getElementsByClassName('voter-option');
        
        for (var i = 0; i < options.length; i++) {
            var name = options[i].getAttribute('data-name');
            if (name.includes(input)) {
                options[i].style.display = "flex";
            } else {
                options[i].style.display = "none";
            }
        }
    }

    function selectVoter(val, displayText, element = null) {
        // Reset all backgrounds and checkmarks
        var allOptions = document.getElementsByClassName('voter-option');
        for (var i = 0; i < allOptions.length; i++) {
            allOptions[i].style.backgroundColor = "transparent";
            var icon = allOptions[i].querySelector('.check-icon');
            if(icon) icon.style.display = "none";
        }
        
        // Set text
        document.getElementById('custom-select-text').innerText = displayText;
        
        // Auto fill logic
        if(val) {
            var parts = val.split('|');
            document.getElementById('addName').value = parts[0];
            document.getElementById('addClassName').value = parts[1];
            
            // Set active styles
            if(element) {
                element.style.backgroundColor = "#e0f2fe"; // Light blue active bg
                var icon = element.querySelector('.check-icon');
                if(icon) icon.style.display = "block";
            }
        } else {
            document.getElementById('addName').value = '';
            document.getElementById('addClassName').value = '';
        }
        
        // Close dropdown
        document.getElementById('custom-options').style.display = 'none';
        document.getElementById('voterSearchInput').value = '';
        filterVoters(); // reset filter
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        var wrapper = document.querySelector('.custom-select-wrapper');
        if (wrapper && !wrapper.contains(event.target)) {
            document.getElementById('custom-options').style.display = 'none';
        }
    });
</script>
@endsection
