@extends('layouts.app')

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
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
            <div style="position: absolute; top: 1rem; right: 1rem; display: flex; gap: 0.5rem; z-index: 10;">
                <button onclick="openEditModal({{ $candidate->id }}, '{{ addslashes($candidate->name) }}', '{{ addslashes($candidate->class_name) }}', '{{ addslashes($candidate->organization) }}', `{{ base64_encode($candidate->vision) }}`, `{{ base64_encode($candidate->mission) }}`)" class="btn btn-secondary" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; background-color: rgba(255,255,255,0.9); color: var(--primary);"><i class="fa-solid fa-pen"></i> Edit</button>
                <form action="{{ route('admin.candidates.destroy', $candidate->id) }}" method="POST" id="delete-form-{{ $candidate->id }}">
                    @csrf
                    <button type="button" onclick="confirmDelete({{ $candidate->id }}, '{{ addslashes($candidate->name) }}')" class="btn" style="padding: 0.25rem 0.75rem; font-size: 0.75rem; background-color: #ef4444; color: white; border: none;"><i class="fa-solid fa-trash"></i> Hapus</button>
                </form>
            </div>
            <img src="{{ $candidate->photo }}" alt="{{ $candidate->name }}" class="candidate-photo">
            
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
    <div class="modal-content">
        <span class="close-btn" onclick="document.getElementById('addCandidateModal').style.display='none'">&times;</span>
        <h3 style="margin-bottom: 1.5rem;">Tambah Kandidat Baru</h3>
        
        <form action="{{ route('admin.candidates.store') }}" method="POST" enctype="multipart/form-data" id="candidateForm">
            @csrf
            <div class="form-group">
                <label>Nama Calon</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="class_name" required>
            </div>
            
            <div class="form-group">
                <label>Organisasi (Opsional)</label>
                <input type="text" name="organization">
            </div>
            
            <div class="form-group">
                <label>Foto Calon</label>
                <input type="file" name="photo" accept="image/*" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: var(--radius);">
            </div>
            
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
            
            <button type="submit" class="btn" style="width: 100%;">Simpan Kandidat</button>
        </form>
    </div>
</div>

<!-- Modal Edit Kandidat -->
<div id="editCandidateModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="document.getElementById('editCandidateModal').style.display='none'">&times;</span>
        <h3 style="margin-bottom: 1.5rem;">Edit Kandidat</h3>
        
        <form action="" method="POST" enctype="multipart/form-data" id="editCandidateForm">
            @csrf
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
            
            <button type="submit" class="btn" style="width: 100%;">Update Kandidat</button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
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
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        var modal = document.getElementById('addCandidateModal');
        var editModal = document.getElementById('editCandidateModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
        if (event.target == editModal) {
            editModal.style.display = "none";
        }
    }
</script>
@endsection
