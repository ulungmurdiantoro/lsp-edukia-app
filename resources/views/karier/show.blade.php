@extends('layouts.app')

@section('extra-css')
<style>
.page-hero{background:radial-gradient(700px 400px at 80% -10%,rgba(68,159,229,.25),transparent 60%),radial-gradient(600px 300px at 10% 110%,rgba(244,137,31,.15),transparent 60%),linear-gradient(180deg,rgba(10,37,71,.82) 0%,rgba(6,23,46,.92) 100%),url('/images/hero-informasi.jpg');background-size:auto,auto,auto,cover;background-position:center;color:#fff;position:relative;overflow:hidden;border-top:0;padding:0}
.page-hero::before{content:"";position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);background-size:64px 64px;mask-image:radial-gradient(80% 70% at 50% 30%,#000 30%,transparent 80%)}
.page-hero-inner{padding:80px 0 88px;position:relative}
.badge{display:inline-flex;align-items:center;gap:10px;height:34px;padding:0 14px 0 12px;border-radius:999px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.18);font-size:12.5px;font-weight:600;letter-spacing:0.04em;text-transform:uppercase;margin-bottom:20px}
.page-hero h1{color:#fff;margin-bottom:16px}
.page-hero h1 em{font-family:"Fraunces",serif;font-style:italic;font-weight:500;color:var(--blue)}
.page-hero p.lead{color:rgba(255,255,255,.78);font-size:17px;max-width:56ch;line-height:1.55}
.hero-back{color:rgba(255,255,255,0.7);text-decoration:none;font-size:14px;display:block;width:fit-content;margin-bottom:16px}
.hero-back:hover{color:#fff}
</style>
@endsection

@section('content')
<style>
  .job-detail-metas {
    display: flex;
    gap: 24px;
    margin-top: 20px;
    flex-wrap: wrap;
  }

  .job-detail-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14.5px;
    color: rgba(255, 255, 255, 0.9);
  }

  .job-detail-meta svg {
    width: 20px;
    height: 20px;
  }

  .detail-grid {
    display: flex;
    flex-direction: column;
    gap: 40px;
    padding: 56px 0;
  }

  .requirements-section {
    margin-bottom: 40px;
  }

  .requirements-section h3 {
    font-size: 22px;
    margin-bottom: 20px;
  }

  .requirements-section ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .requirements-section li {
    display: flex;
    gap: 14px;
    margin-bottom: 14px;
    font-size: 14.5px;
    color: var(--ink-2);
    line-height: 1.6;
  }

  .requirements-section li::before {
    content: "✓";
    color: var(--blue-deep);
    font-weight: 700;
    flex-shrink: 0;
  }

  .apply-sidebar {
    width: 100%;
  }

  .apply-form {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 16px;
    padding: 32px;
  }

  /* Wider form: lay the fields out in two columns */
  #applicationForm {
    display: grid;
    grid-template-columns: 1fr 1fr;
    column-gap: 24px;
    align-items: start;
  }

  #applicationForm > .form-group--full,
  #applicationForm > .submit-btn,
  #applicationForm > .info-box {
    grid-column: 1 / -1;
  }

  .form-group {
    margin-bottom: 24px;
  }

  .form-group:last-child {
    margin-bottom: 0;
  }

  .form-group label {
    display: block;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--ink);
    margin-bottom: 8px;
  }

  .form-group label .required {
    color: #e74c3c;
  }

  .form-group input,
  .form-group select,
  .form-group textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid var(--line-2);
    border-radius: 8px;
    font-size: 13.5px;
    color: var(--ink);
    font-family: inherit;
  }

  .form-group textarea {
    resize: vertical;
    min-height: 100px;
  }

  .form-group input:focus,
  .form-group select:focus,
  .form-group textarea:focus {
    outline: none;
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(68, 159, 229, 0.1);
  }

  .file-input-wrapper {
    position: relative;
  }

  .file-input-wrapper input[type="file"] {
    display: none;
  }

  .file-input-label {
    display: block;
    padding: 12px 14px;
    border: 2px dashed var(--line-2);
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 13px;
    color: var(--ink-2);
  }

  .file-input-label:hover {
    border-color: var(--blue);
    background: rgba(68, 159, 229, 0.05);
  }

  .file-input-wrapper.has-file .file-input-label {
    background: var(--blue-50);
    border-color: var(--blue);
    color: var(--blue-deep);
  }

  .file-name {
    display: block;
    font-size: 12px;
    margin-top: 6px;
    color: var(--blue-deep);
    font-weight: 600;
  }

  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  .checkbox-group {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .checkbox-group input[type="checkbox"] {
    width: auto;
  }

  .submit-btn {
    width: 100%;
    padding: 14px;
    background: var(--orange);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14.5px;
    cursor: pointer;
    transition: all 0.2s;
  }

  .submit-btn:hover {
    background: var(--orange-deep);
    transform: translateY(-1px);
  }

  .info-box {
    background: var(--navy-50);
    border-left: 4px solid var(--blue);
    padding: 16px;
    border-radius: 8px;
    margin-top: 20px;
    font-size: 13px;
    color: var(--ink-2);
  }

  .error-message {
    color: #e74c3c;
    font-size: 12px;
    margin-top: 6px;
  }

  @media (max-width: 768px) {
    .detail-grid {
      grid-template-columns: 1fr;
      gap: 24px;
    }

    .apply-sidebar {
      position: static;
    }

    #applicationForm {
      grid-template-columns: 1fr;
    }

    .form-row {
      grid-template-columns: 1fr;
    }

    .page-hero-inner {
      padding: 56px 0 60px;
    }

    .page-hero h1 {
      font-size: 28px;
    }
  }
</style>

<div class="page-hero">
  <div class="wrap page-hero-inner">
    <a href="{{ route('karier.index') }}" class="hero-back">
      ← Kembali ke Lowongan
    </a>
    <div class="badge">Karier · {{ $opening['kategori'] }}</div>
    <h1>{{ $opening['judul'] }}</h1>
    <div class="job-detail-metas">
      <div class="job-detail-meta">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
        </svg>
        {{ $opening['lokasi'] }}
      </div>
      <div class="job-detail-meta">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ $opening['tipe'] }}
      </div>
      <div class="job-detail-meta">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2h-3l-4 4z" />
        </svg>
        {{ $opening['kategori'] }}
      </div>
    </div>
  </div>
</div>

<section>
  <div class="wrap detail-grid">
    <!-- Job Details -->
    <div>
      <div class="requirements-section">
        <h3>Tentang Posisi Ini</h3>
        <p style="font-size: 15px; color: var(--ink-2); line-height: 1.7;">{{ $opening['deskripsi'] }}</p>
      </div>

      <div class="requirements-section">
        <h3>Persyaratan</h3>
        <ul>
          @foreach ($opening['requirements'] as $req)
            <li>{{ $req }}</li>
          @endforeach
        </ul>
      </div>

      <div class="requirements-section">
        <h3>Tanggung Jawab</h3>
        <ul>
          @foreach ($opening['responsibilities'] as $resp)
            <li>{{ $resp }}</li>
          @endforeach
        </ul>
      </div>
    </div>

    <!-- Application Form -->
    <div class="apply-sidebar">
      <div class="apply-form">
        <h3 style="margin-bottom: 24px;">Kirimkan Lamaran Anda</h3>

        @if (session('success'))
          <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 14px; border-radius: 8px; margin-bottom: 20px; font-size: 13px;">
            ✓ {{ session('success') }}
          </div>
        @endif

        <form action="{{ route('karier.apply') }}" method="POST" enctype="multipart/form-data" id="applicationForm">
          @csrf
          <input type="hidden" name="posisi" value="{{ $opening['slug'] }}">

          <!-- Nama Lengkap -->
          <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap <span class="required">*</span></label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
            @error('nama_lengkap')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Tempat & Tanggal Lahir -->
          <div class="form-group">
            <label for="tempat_tanggal_lahir">Tempat, Tanggal Lahir <span class="required">*</span></label>
            <input type="text" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" placeholder="Contoh: Jakarta, 15 Januari 1990" value="{{ old('tempat_tanggal_lahir') }}" required>
            @error('tempat_tanggal_lahir')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Nomor WhatsApp -->
          <div class="form-group">
            <label for="nomor_whatsapp">Nomor WhatsApp <span class="required">*</span></label>
            <input type="tel" id="nomor_whatsapp" name="nomor_whatsapp" placeholder="Contoh: 082123456789" value="{{ old('nomor_whatsapp') }}" required>
            @error('nomor_whatsapp')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Domisili -->
          <div class="form-group">
            <label for="domisili">Domisili Saat Ini <span class="required">*</span></label>
            <input type="text" id="domisili" name="domisili" value="{{ old('domisili') }}" required>
            @error('domisili')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Pendidikan Terakhir -->
          <div class="form-group">
            <label for="pendidikan_terakhir">Pendidikan Terakhir <span class="required">*</span></label>
            <select id="pendidikan_terakhir" name="pendidikan_terakhir" required>
              <option value="">-- Pilih --</option>
              <option value="S1" {{ old('pendidikan_terakhir') === 'S1' ? 'selected' : '' }}>S1</option>
              <option value="S2" {{ old('pendidikan_terakhir') === 'S2' ? 'selected' : '' }}>S2</option>
              <option value="S3" {{ old('pendidikan_terakhir') === 'S3' ? 'selected' : '' }}>S3</option>
            </select>
            @error('pendidikan_terakhir')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Jurusan -->
          <div class="form-group">
            <label for="jurusan">Jurusan <span class="required">*</span></label>
            <input type="text" id="jurusan" name="jurusan" value="{{ old('jurusan') }}" required>
            @error('jurusan')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Pengalaman Kerja -->
          <div class="form-group">
            <label for="pengalaman_kerja">Pengalaman Kerja di Bidang Penjaminan Mutu <span class="required">*</span></label>
            <select id="pengalaman_kerja" name="pengalaman_kerja" required>
              <option value="">-- Pilih --</option>
              <option value="<1 tahun" {{ old('pengalaman_kerja') === '<1 tahun' ? 'selected' : '' }}>&lt;1 tahun</option>
              <option value="1-3 tahun" {{ old('pengalaman_kerja') === '1-3 tahun' ? 'selected' : '' }}>1-3 tahun</option>
              <option value="3-5 tahun" {{ old('pengalaman_kerja') === '3-5 tahun' ? 'selected' : '' }}>3-5 tahun</option>
              <option value=">5 tahun" {{ old('pengalaman_kerja') === '>5 tahun' ? 'selected' : '' }}>&gt;5 tahun</option>
            </select>
            @error('pengalaman_kerja')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Sertifikat ISO -->
          <div class="form-group">
            <label for="sertifikat_iso">Apakah Anda memiliki sertifikat kompetensi/pelatihan di bidang ISO 21001 atau ISO 17024? <span class="required">*</span></label>
            <select id="sertifikat_iso" name="sertifikat_iso" required>
              <option value="">-- Pilih --</option>
              <option value="YA" {{ old('sertifikat_iso') === 'YA' ? 'selected' : '' }}>YA</option>
              <option value="TIDAK" {{ old('sertifikat_iso') === 'TIDAK' ? 'selected' : '' }}>TIDAK</option>
            </select>
            @error('sertifikat_iso')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Daftar Sertifikat -->
          <div class="form-group form-group--full">
            <label for="sertifikat_list">Sebutkan Sertifikat yang Anda Miliki <span class="required">*</span></label>
            <textarea id="sertifikat_list" name="sertifikat_list" placeholder="Tuliskan daftar sertifikat yang Anda miliki (jika ada)">{{ old('sertifikat_list') }}</textarea>
            @error('sertifikat_list')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Pengalaman Audit -->
          <div class="form-group form-group--full">
            <label for="pengalaman_audit">Jelaskan Secara Singkat Pengalaman Anda dalam Mengelola Audit Internal atau Sistem Mutu <span class="required">*</span></label>
            <textarea id="pengalaman_audit" name="pengalaman_audit" required>{{ old('pengalaman_audit') }}</textarea>
            @error('pengalaman_audit')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- CV -->
          <div class="form-group">
            <label>Curriculum Vitae (CV) Terbaru <span class="required">*</span></label>
            <div class="file-input-wrapper">
              <input type="file" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
              <label for="cv" class="file-input-label">
                📎 Pilih file (PDF, DOC, DOCX) - Maks 5 MB
              </label>
              <span class="file-name" id="cvFileName"></span>
            </div>
            @error('cv')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Portofolio -->
          <div class="form-group">
            <label>Portofolio / Contoh Dokumen Sistem Mutu (Opsional)</label>
            <div class="file-input-wrapper">
              <input type="file" id="portofolio" name="portofolio" accept=".pdf,.doc,.docx">
              <label for="portofolio" class="file-input-label">
                📎 Pilih file (PDF, DOC, DOCX) - Maks 5 MB
              </label>
              <span class="file-name" id="portfolioFileName"></span>
            </div>
            @error('portofolio')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Ijazah -->
          <div class="form-group">
            <label>Ijazah Terakhir <span class="required">*</span></label>
            <div class="file-input-wrapper">
              <input type="file" id="ijazah" name="ijazah" accept=".pdf,.jpg,.jpeg,.png" required>
              <label for="ijazah" class="file-input-label">
                📎 Pilih file (PDF, JPG, PNG) - Maks 5 MB
              </label>
              <span class="file-name" id="ijazahFileName"></span>
            </div>
            @error('ijazah')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Sertifikat Pelatihan -->
          <div class="form-group">
            <label>Sertifikat Pelatihan/Kompetensi (Gabungkan dalam 1 file PDF) <span class="required">*</span></label>
            <div class="file-input-wrapper">
              <input type="file" id="sertifikat_pelatihan" name="sertifikat_pelatihan" accept=".pdf,.jpg,.jpeg,.png" required>
              <label for="sertifikat_pelatihan" class="file-input-label">
                📎 Pilih file (PDF, JPG, PNG) - Maks 5 MB
              </label>
              <span class="file-name" id="sertifikatFileName"></span>
            </div>
            @error('sertifikat_pelatihan')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Bersedia Full-time -->
          <div class="form-group form-group--full">
            <label>
              <div class="checkbox-group">
                <input type="checkbox" id="bersedia_fulltime" name="bersedia_fulltime" value="1" {{ old('bersedia_fulltime') ? 'checked' : '' }} required>
                <span>Saya bersedia bekerja secara penuh waktu (full-time) di {{ $opening['lokasi'] }} <span class="required">*</span></span>
              </div>
            </label>
            @error('bersedia_fulltime')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <!-- Pernyataan Kebenaran -->
          <div class="form-group form-group--full" style="background: var(--cream-2); padding: 14px; border-radius: 8px;">
            <label>
              <div class="checkbox-group">
                <input type="checkbox" id="pernyataan" name="pernyataan" value="1" required>
                <span>Saya menyatakan bahwa semua informasi yang saya berikan dalam formulir ini adalah benar dan dapat dipertanggungjawabkan. <span class="required">*</span></span>
              </div>
            </label>
            @error('pernyataan')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="submit-btn">Kirimkan Lamaran</button>

          <div class="info-box">
            💡 Kami akan meninjau lamaran Anda dan menghubungi Anda melalui WhatsApp dalam waktu 3-5 hari kerja.
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
  // Handle file input changes
  ['cv', 'portofolio', 'ijazah', 'sertifikat_pelatihan'].forEach(fileInputName => {
    const fileInput = document.getElementById(fileInputName);
    const fileNameDisplay = document.getElementById(fileInputName + 'FileName');
    
    if (fileInput) {
      fileInput.addEventListener('change', function() {
        const wrapper = this.parentElement;
        const fileName = this.files[0]?.name || '';
        
        if (fileName) {
          wrapper.classList.add('has-file');
          fileNameDisplay.textContent = '✓ ' + fileName + ' dipilih';
        } else {
          wrapper.classList.remove('has-file');
          fileNameDisplay.textContent = '';
        }
      });
    }
  });
</script>
@endsection
