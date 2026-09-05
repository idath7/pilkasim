<!DOCTYPE html>
<html>
<head>
  <base target="_top">
  <title>Cetak Kartu Pemilih - <?php echo e($appSetting->app_name ?? 'E-Pilketos'); ?></title>
  <?php $faviconSetting = \App\Models\Setting::getCached(); ?>
  <?php if($faviconSetting && $faviconSetting->osim_logo): ?>
      <link rel="icon" href="<?php echo e(asset($faviconSetting->osim_logo)); ?>" type="image/x-icon">
  <?php endif; ?>
  <style id="page-style">
    /* Default: Kertas Folio (F4) 215.9mm x 330.2mm */
    @page {
      size: 215.9mm 330.2mm;
      margin: 6mm; 
    }
  </style>
  <style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #e0e0e0; }
    
    /* Area Kontrol & Filter (Disembunyikan saat Print) */
    .no-print { 
      text-align: center; padding: 15px 20px; background: #fff; 
      border-bottom: 1px solid #ccc; margin-bottom: 10px; 
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    button { background: #4F46E5; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; font-weight: bold; font-size: 14px; margin-bottom: 10px; }
    button:hover { background: #4338CA; }

    /* Desain Kotak Filter */
    .filter-container {
      display: flex; justify-content: center; gap: 15px; margin-top: 10px; align-items: center;
    }
    .filter-box {
      padding: 8px; border: 1px solid #999; border-radius: 4px; font-size: 14px; width: 250px;
    }
    #info-jumlah { font-size: 12px; font-weight: bold; color: #1b7339; margin-top: 10px; }

    /* Grid 2 Kolom x 5 Baris (10 Kartu per lembar) */
    #card-container {
      display: grid;
      grid-template-columns: repeat(2, 98mm);
      grid-auto-rows: 62mm;
      gap: 4mm;
      justify-content: center;
    }

    /* Desain Kartu Lanskap */
    .kartu {
      background: white;
      border: 1px solid #999;
      border-radius: 8px;
      padding: 8px 12px;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      justify-content: space-between; 
      box-shadow: 2px 2px 6px rgba(0,0,0,0.05);
      page-break-inside: avoid;
    }

    /* Header & Footer */
    .header { text-align: center; padding-bottom: 4px; border-bottom: 1.5px solid #333; }
    .header h1 { font-size: 13px; margin: 0; color: #111; letter-spacing: 1px; font-weight: 900;}
    .header h2 { font-size: 10px; margin: 2px 0 0 0; color: #444; font-weight: 700; }

    .footer { text-align: center; padding-top: 4px; border-bottom: 1.5px solid #333; font-size: 9px; font-weight: bold; color: #333; margin-top: 4px; }
    .footer-bottom { text-align: center; font-size: 8px; color: #555; padding-top: 2px; }

    /* Layout Konten Utama */
    .main-body { display: flex; flex: 1; align-items: center; padding: 4px 0; }

    /* Panel Kiri: QR Web & Ruang */
    .left-panel { width: 65px; display: flex; flex-direction: column; align-items: center; justify-content: center;}
    .qr-web { width: 55px; height: 55px; border: 1px solid #ccc; padding: 2px; border-radius: 4px; box-sizing: border-box; }
    .ruang-badge { margin-top: 6px; font-size: 9px; font-weight: bold; color: #111; background: transparent; padding: 2px 0; border: 1px solid #111; border-radius: 4px; text-align: center; width: 100%; box-sizing: border-box; word-break: break-all; line-height: 1.2; }

    /* Panel Tengah: Data Peserta */
    .data-panel { flex: 1; padding: 0 10px; display: flex; flex-direction: column; justify-content: center; }
    .data-row { border-bottom: 1px solid #888; padding-bottom: 1px; margin-bottom: 4px; }
    .data-row.inline { display: flex; justify-content: space-between; align-items: flex-end; }
    .label { font-size: 8px; color: #555; }
    .value { font-size: 11px; font-weight: bold; color: #111; }
    .value.nama { font-size: 12px; }
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 10px; }

    /* Panel Kanan: QR Code Username */
    .right-panel { width: 55px; display: flex; justify-content: center; align-items: center; }
    .right-panel img { width: 45px; height: 45px; border: 1px solid #ddd; padding: 2px; border-radius: 6px; box-sizing: border-box; }

    /* Pesan Data Kosong */
    .data-kosong { text-align: center; grid-column: 1 / -1; padding: 20px; font-weight: bold; color: #666; }

    /* Aturan Print */
    @media print {
      body { background: white; }
      .no-print { display: none; }
      #card-container { padding: 0; }
    }
  </style>
</head>
<body>

  <div class="no-print">
    <button onclick="window.print()">🖨️ CETAK KARTU</button>
    <p id="info-kertas-text" style="font-size: 11px; margin: 0; color: #666;">Pastikan Setting Paper Size: <strong>Folio/F4</strong> | Margins: <strong>None</strong></p>
    
    <div class="filter-container">
      <select id="filter-kertas" class="filter-box" onchange="ubahUkuranKertas()" style="width: 150px; background: #eef2ff; font-weight: bold; border-color: #4F46E5;">
        <option value="F4">Kertas Folio / F4</option>
        <option value="A4">Kertas A4</option>
      </select>
      <input type="text" id="filter-nama" class="filter-box" placeholder="Cari Nama Pemilih..." onkeyup="terapkanFilter()">
      <select id="filter-kelas" class="filter-box" onchange="terapkanFilter()">
        <option value="">-- Tampilkan Semua <?php echo e($type == 'teacher' ? 'Jabatan/Mapel' : 'Kelas'); ?> --</option>
      </select>
    </div>
    <div id="info-jumlah">Memuat data dari server...</div>
  </div>

  <div id="card-container"></div>

  <script>
    // Menyuntikkan data dari Laravel Controller ke dalam array JS
    let dataPesertaMaster = <?php echo json_encode($voters, 15, 512) ?>;
    const type = "<?php echo e($type); ?>";
    const appName = "<?php echo e($appSetting->school_name ?? 'PILKASIM 2026'); ?>";
    const loginMethod = "<?php echo e($appSetting->login_method ?? 'access_code'); ?>";
    
    // QR Web = URL root website kita (agar siswa bisa langsung scan ke halaman awal)
    const websiteUrl = "<?php echo e(url('/')); ?>";
    const qrWebUrl = "https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=" + encodeURIComponent(websiteUrl);

    // Jalankan fungsi saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
      buatDropdownKelas(dataPesertaMaster);
      tampilkanKartu(dataPesertaMaster);
    });

    // Fungsi mengubah ukuran kertas
    function ubahUkuranKertas() {
      const ukuran = document.getElementById('filter-kertas').value;
      const pageStyle = document.getElementById('page-style');
      const infoText = document.getElementById('info-kertas-text');
      
      if (ukuran === 'F4') {
        pageStyle.innerHTML = '@page { size: 215.9mm 330.2mm; margin: 6mm; }';
        infoText.innerHTML = 'Pastikan Setting Paper Size: <strong>Folio/F4</strong> | Margins: <strong>None</strong>';
      } else {
        pageStyle.innerHTML = '@page { size: 210mm 297mm; margin: 6mm; }';
        infoText.innerHTML = 'Pastikan Setting Paper Size: <strong>A4</strong> | Margins: <strong>None</strong>';
      }
    }

    // Fungsi otomatis mengekstrak daftar kelas dari database
    function buatDropdownKelas(data) {
      const selectKelas = document.getElementById('filter-kelas');
      // Mengambil nama kelas yang unik agar tidak ganda di dropdown
      const kelasUnik = [...new Set(data.map(item => item.class_name))].sort();
      
      kelasUnik.forEach(kelas => {
        if(kelas) {
          let opt = document.createElement('option');
          opt.value = kelas;
          opt.innerHTML = kelas;
          selectKelas.appendChild(opt);
        }
      });
    }

    // Fungsi eksekusi filter saat diketik/dipilih
    function terapkanFilter() {
      const kataKunci = document.getElementById('filter-nama').value.toLowerCase();
      const kelasPilihan = document.getElementById('filter-kelas').value;

      const dataTersaring = dataPesertaMaster.filter(peserta => {
        const cocokNama = peserta.name.toLowerCase().includes(kataKunci);
        const cocokKelas = (kelasPilihan === "") || (peserta.class_name === kelasPilihan);
        return cocokNama && cocokKelas;
      });

      tampilkanKartu(dataTersaring);
    }

    // Fungsi menampilkan HTML Kartu
    function tampilkanKartu(data) {
      const container = document.getElementById('card-container');
      const infoJumlah = document.getElementById('info-jumlah');
      let html = '';

      infoJumlah.innerHTML = `Menampilkan ${data.length} Kartu Pemilih`;

      if (data.length === 0) {
        container.innerHTML = '<div class="data-kosong">Data tidak ditemukan. Silakan sesuaikan filter Anda.</div>';
        return;
      }

      data.forEach(peserta => {
        let qrData = loginMethod === 'username_password' ? (peserta.username || '-') : peserta.access_code;
        let qrUserUrl = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" + encodeURIComponent(qrData);
        
        let idLabel = type === 'teacher' ? 'NIP' : 'NIS';
        let idValue = peserta.nis || '-';
        let classLabel = type === 'teacher' ? 'JABATAN' : 'KELAS';
        
        let loginInfoHtml = '';
        let footerNote = '';

        if (loginMethod === 'username_password') {
            loginInfoHtml = `
                <div class="data-row inline"><span class="label">USERNAME</span><span class="value" style="${(peserta.username || '').length > 10 ? 'font-size:9px;' : ''}">${peserta.username || '-'}</span></div>
                <div class="data-row inline"><span class="label">PASSWORD</span><span class="value">********</span></div>
            `;
            footerNote = '* Jaga kerahasiaan Akun Anda.';
        } else {
            loginInfoHtml = `
                <div class="data-row inline" style="grid-column: 1 / -1;"><span class="label">KODE AKSES LOGIN</span><span class="value" style="font-size: 13px; letter-spacing: 2px;">${peserta.access_code}</span></div>
            `;
            footerNote = '* Jaga kerahasiaan Kode Akses Anda.';
        }
        
        html += `
        <div class="kartu">
          <div class="header">
            <h1>KARTU PEMILIH E-VOTING</h1>
            <h2>${appName.toUpperCase()}</h2>
          </div>

          <div class="main-body">
            <div class="left-panel">
              <img src="${qrWebUrl}" class="qr-web" alt="QR Web">
              <div class="ruang-badge">SCAN WEB</div>
            </div>
            
            <div class="data-panel">
              <div class="data-row">
                <span class="label">NAMA PEMILIH</span><br>
                <span class="value nama" style="${peserta.name.length > 25 ? 'font-size:10px;' : ''}">${peserta.name.toUpperCase()}</span>
              </div>

              <div class="info-grid">
                <div class="data-row inline"><span class="label">${idLabel}</span><span class="value">${idValue}</span></div>
                <div class="data-row inline"><span class="label">${classLabel}</span><span class="value" style="${peserta.class_name.length > 12 ? 'font-size:9px;' : ''}">${peserta.class_name}</span></div>
                ${loginInfoHtml}
              </div>
            </div>

            <div class="right-panel">
              <img src="${qrUserUrl}" alt="QR User">
            </div>
          </div>

          <div class="footer">
            KARTU INI BERSIFAT RAHASIA
          </div>
          <div class="footer-bottom">
            ${footerNote}
          </div>
        </div>
        `;
      });

      container.innerHTML = html;
    }
  </script>
</body>
</html>

<?php /**PATH D:\1Laravel\pilkasim\resources\views\admin\print_cards.blade.php ENDPATH**/ ?>