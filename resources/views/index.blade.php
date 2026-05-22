@extends('layouts.app')
@section('title', 'LSP Edukia — Sertifikasi Kompetensi Profesional')

@section('content')
<!-- HERO -->
<section class="hero" style="border-top:0;padding:0">
  <div class="wrap hero-grid">
    <div>
      <div class="badge"><span class="dot"></span> Berlisensi KAN · LSP-033-IDN</div>
      <h1>Sertifikasi kompetensi <em>profesional</em> berstandar nasional</h1>
      <p class="lead">26 skema sertifikasi untuk bidang Pendidikan Tinggi, Laboratorium, Lifting Engineering, dan Industri. Uji kompetensi daring, sertifikat berlaku 3 tahun.</p>
      <div class="hero-cta">
        <a href="#persyaratan" class="btn btn-primary btn-lg">Lihat persyaratan
          <svg class="icon"><use href="#i-arrow-r"></use></svg>
        </a>
        <a href="{{ route('skema') }}" class="btn btn-ghost btn-lg">Unit kompetensi</a>
      </div>
      <div class="hero-trust">
        <span>DIAKUI KAN</span><span class="line"></span>
        <span>LSP-033-IDN</span><span class="line"></span>
        <span>DP.AK.05 REV.02</span>
      </div>
    </div>
    <div class="stat-grid">
      <div class="stat"><span class="corner">01</span><div class="v">26</div><div class="l">Skema sertifikasi</div></div>
      <div class="stat"><span class="corner">02</span><div class="v">5</div><div class="l">Bidang keahlian</div></div>
      <div class="stat"><span class="corner">03</span><div class="v">3<small>th</small></div><div class="l">Masa berlaku sertifikat</div></div>
      <div class="stat featured"><span class="corner">04</span><div class="v online">Online</div><div class="l">Uji kompetensi fleksibel</div></div>
    </div>
  </div>
</section>

<!-- ALUR SERTIFIKASI -->
<section id="alur">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Alur Sertifikasi</div>
      <h2>Proses sertifikasi dalam 4 tahap</h2>
      <p class="sub">Transparan, objektif, dan sesuai standar KAN. Setiap tahap dipantau asesor independen bersertifikat.</p>
    </div>
    <div class="steps">
      <div class="step">
        <div class="step-num">1</div><div class="step-connector"></div>
        <div class="step-ico"><svg width="22" height="22"><use href="#i-doc"></use></svg></div>
        <h3>Permohonan Sertifikasi</h3>
        <p>Isi formulir FR.APL.01 dan FR.AK.01. Lengkapi dokumen persyaratan sesuai skema yang dipilih.</p>
      </div>
      <div class="step">
        <div class="step-num">2</div><div class="step-connector"></div>
        <div class="step-ico"><svg width="22" height="22"><use href="#i-check-list"></use></svg></div>
        <h3>Pra Asesmen</h3>
        <p>Asesor memverifikasi kelengkapan bukti dokumen — Valid, Asli, Terkini, Memadai (VATM).</p>
      </div>
      <div class="step">
        <div class="step-num">3</div><div class="step-connector"></div>
        <div class="step-ico"><svg width="22" height="22"><use href="#i-monitor"></use></svg></div>
        <h3>Uji Kompetensi</h3>
        <p>Ujian tertulis, lisan, dan/atau keterampilan secara online. Hasil: Kompeten atau Belum Kompeten.</p>
      </div>
      <div class="step">
        <div class="step-num">4</div>
        <div class="step-ico"><svg width="22" height="22"><use href="#i-award"></use></svg></div>
        <h3>Penerbitan Sertifikat</h3>
        <p>Sertifikat disahkan Ketua LSP EDUKIA, berlaku 3 tahun. Jika tidak lulus: remedial atau banding tersedia.</p>
      </div>
    </div>
  </div>
</section>

<!-- PERSYARATAN DASAR -->
<section id="persyaratan" style="background:#fbf9f3">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Bagian 3</div>
      <h2>Persyaratan Dasar Pemohon Sertifikasi</h2>
      <p class="sub">Persyaratan pendidikan, pengalaman, dan sertifikat pelatihan yang harus dipenuhi untuk setiap skema kompetensi.</p>
    </div>
    <div class="chips" id="chips">
      <button class="chip active" data-filter="all">Semua <span class="count">26</span></button>
      <button class="chip" data-filter="pendidikan">Pendidikan Tinggi &amp; SPMI <span class="count">5</span></button>
      <button class="chip" data-filter="laboratorium">Laboratorium &amp; Pengujian <span class="count">9</span></button>
      <button class="chip" data-filter="lifting">Lifting Engineering <span class="count">4</span></button>
      <button class="chip" data-filter="industri">Sistem Manajemen &amp; Industri <span class="count">7</span></button>
      <button class="chip" data-filter="hukum">Hukum Korporasi <span class="count">1</span></button>
    </div>
    <div class="schemes" id="schemes">
      <div class="scheme" data-cat="pendidikan"><span class="scheme-num">Skema 01</span><span class="tag">Pendidikan Tinggi &amp; SPMI</span><h3>Auditor Internal SPMI Terintegrasi ISO 21001:2018</h3><ul class="req-list"><li>Pendidikan minimal S2</li><li>Pengalaman kerja di bidang Perguruan Tinggi</li><li>Memiliki Sertifikat Pelatihan Auditor Internal</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="pendidikan"><span class="scheme-num">Skema 02</span><span class="tag">Pendidikan Tinggi &amp; SPMI</span><h3>Lead Auditor Internal SPMI Terintegrasi ISO 21001:2018</h3><ul class="req-list"><li>Pendidikan minimal S2</li><li>Pengalaman kerja di bidang Perguruan Tinggi</li><li>Memiliki Sertifikat Pelatihan Auditor Internal</li><li>Pengalaman sebagai Ketua Auditor</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="pendidikan"><span class="scheme-num">Skema 03</span><span class="tag">Pendidikan Tinggi &amp; SPMI</span><h3>Lead Implementer SPMI Terintegrasi ISO 21001:2018</h3><ul class="req-list"><li>Pendidikan minimal S2</li><li>Pengalaman kerja di bidang Perguruan Tinggi</li><li>Memiliki Sertifikat Pelatihan SPMI / ISO 21001:2018</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="pendidikan"><span class="scheme-num">Skema 04</span><span class="tag">Pendidikan Tinggi &amp; SPMI</span><h3>Training of Trainer (ToT) Outcome Based Education (OBE)</h3><ul class="req-list"><li>Pendidikan minimal S2</li><li>Pengalaman kerja di bidang Perguruan Tinggi</li><li>Memiliki Sertifikat Pelatihan Kurikulum OBE / Pelatihan yang relevan dengan kurikulum</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="pendidikan"><span class="scheme-num">Skema 05</span><span class="tag">Pendidikan Tinggi &amp; SPMI</span><h3>Implementer Tata Kelola Organisasi Perguruan Tinggi</h3><ul class="req-list"><li>Pendidikan minimal S2</li><li>Pengalaman kerja di bidang Perguruan Tinggi</li><li>Memiliki Sertifikat Pelatihan relevan dengan Tata Kelola Organisasi Perguruan Tinggi</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="laboratorium"><span class="scheme-num">Skema 06</span><span class="tag">Laboratorium &amp; Pengujian</span><h3>Auditor Internal Standar Laboratorium ISO/IEC 17025</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK, pengalaman kerja di bidang Laboratorium minimal 2 tahun</li><li>Memiliki Sertifikat Pelatihan Auditor Internal &amp; ISO 17025:2017</li></ul><div class="req-group-label">Jalur 2 — D3</div><ul class="req-list"><li>Pendidikan minimal D3, pengalaman kerja di bidang Laboratorium</li><li>Memiliki Sertifikat ISO 17025:2017</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="laboratorium"><span class="scheme-num">Skema 07</span><span class="tag">Laboratorium &amp; Pengujian</span><h3>Lead Implementer Standar Laboratorium ISO/IEC 17025</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK, pengalaman kerja di bidang Laboratorium minimal 2 tahun</li><li>Memiliki Sertifikat Pelatihan Auditor Internal &amp; ISO 17025:2017</li></ul><div class="req-group-label">Jalur 2 — D3</div><ul class="req-list"><li>Pendidikan minimal D3, pengalaman kerja di bidang Laboratorium</li><li>Memiliki Sertifikat ISO 17025:2017</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="lifting"><span class="scheme-num">Skema 08</span><span class="tag">Lifting Engineering</span><h3>Lifting Engineer for Medium Lifting</h3><ul class="req-list"><li>Pendidikan minimal D3 Teknik</li><li>Fresh graduated atau pengalaman kerja di bidang Lifting</li><li>Memiliki Sertifikat Pelatihan terkait Lifting Engineer for Medium Lifting</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="lifting"><span class="scheme-num">Skema 09</span><span class="tag">Lifting Engineering</span><h3>Lifting Engineer For Heavy &amp; Critical Lifting</h3><ul class="req-list"><li>Pendidikan minimal D3 Teknik</li><li>Fresh graduated atau pengalaman kerja di bidang Lifting</li><li>Memiliki Sertifikat Competent Person for Medium Lifting Operation</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="lifting"><span class="scheme-num">Skema 10</span><span class="tag">Lifting Engineering</span><h3>2D Lifting Designer</h3><ul class="req-list"><li>Pendidikan minimal SMK/SMA</li><li>Fresh graduated atau pengalaman kerja di bidang CAD Drafter</li><li>Memiliki Sertifikat Pelatihan Lifting Drafter</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="lifting"><span class="scheme-num">Skema 11</span><span class="tag">Lifting Engineering</span><h3>3D Lifting Designer</h3><ul class="req-list"><li>Pendidikan minimal SMK/SMA</li><li>Fresh graduated atau pengalaman kerja di bidang Lifting Drafter</li><li>Memiliki Sertifikat Lifting Drafter</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="laboratorium"><span class="scheme-num">Skema 12</span><span class="tag">Laboratorium &amp; Pengujian</span><h3>Laboratory Quality System Officer ISO/IEC 17025</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK bidang sains atau teknis, pengalaman kerja minimal 2 tahun di laboratorium</li><li>Memiliki Sertifikat Pelatihan ISO/IEC 17025:2017</li></ul><div class="req-group-label">Jalur 2 — D3 Fresh Graduate</div><ul class="req-list"><li>Fresh graduated D3 bidang sains atau teknik</li><li>Magang di laboratorium minimal 3 bulan, atau Sertifikat Pelatihan ISO/IEC 17025:2017</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="laboratorium"><span class="scheme-num">Skema 13</span><span class="tag">Laboratorium &amp; Pengujian</span><h3>Food Safety Management Officer / Petugas Sistem Keamanan Pangan</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK bidang sains atau teknis, pengalaman kerja minimal 2 tahun di laboratorium</li><li>Memiliki Sertifikat Pelatihan HACCP, ISO 22000, CPPOB/GMP</li></ul><div class="req-group-label">Jalur 2 — D3 Fresh Graduate</div><ul class="req-list"><li>Fresh graduated D3 bidang sains</li><li>Magang di bidang produksi/keamanan pangan minimal 3 bulan, atau Sertifikat Pelatihan HACCP / ISO 22000</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="laboratorium"><span class="scheme-num">Skema 14</span><span class="tag">Laboratorium &amp; Pengujian</span><h3>Panelis Terlatih Pengujian Sensori Pangan</h3><ul class="req-list"><li>Pendidikan minimal D3/S1 Teknologi Pangan, Ilmu Gizi, Kimia, Biologi, atau Tek. Hasil Pertanian</li><li>Fresh Graduated dan/atau magang di industri/laboratorium pangan minimal 3 bulan</li><li>Memiliki Sertifikat Pelatihan Pengujian Sensori Pangan</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="laboratorium"><span class="scheme-num">Skema 15</span><span class="tag">Laboratorium &amp; Pengujian</span><h3>GLP Laboratory Technician / Teknisi Laboratorium Berbasis GLP</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK bidang sains atau teknis, pengalaman kerja minimal 2 tahun di laboratorium</li><li>Memiliki Sertifikat Pelatihan ISO/IEC 17025:2017</li></ul><div class="req-group-label">Jalur 2 — D3 Fresh Graduate</div><ul class="req-list"><li>Fresh graduated D3 bidang sains atau Teknik</li><li>Magang di laboratorium minimal 3 bulan, atau Sertifikat Pelatihan ISO/IEC 17025:2017</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="laboratorium"><span class="scheme-num">Skema 16</span><span class="tag">Laboratorium &amp; Pengujian</span><h3>Laboratory HSE Officer / Petugas K3L Laboratorium</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK bidang sains atau teknis, pengalaman kerja minimal 2 tahun di laboratorium</li><li>Memiliki Sertifikat Pelatihan ISO/IEC 17025:2017, ISO 14001, ISO 45001</li></ul><div class="req-group-label">Jalur 2 — D3 Fresh Graduate</div><ul class="req-list"><li>Fresh graduated D3 bidang sains atau Teknik</li><li>Magang di laboratorium minimal 3 bulan, atau Sertifikat Pelatihan ISO/IEC 17025:2017, ISO 14001, ISO 45001</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="laboratorium"><span class="scheme-num">Skema 17</span><span class="tag">Laboratorium &amp; Pengujian</span><h3>Laboratory Operations Officer / Pranata Laboratorium</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK bidang sains atau teknis, pengalaman kerja minimal 2 tahun di laboratorium</li><li>Memiliki Sertifikat Pelatihan ISO/IEC 17025:2017</li></ul><div class="req-group-label">Jalur 2 — D3 Fresh Graduate</div><ul class="req-list"><li>Fresh graduated D3 bidang sains atau Teknik</li><li>Magang di laboratorium minimal 3 bulan, atau Sertifikat Pelatihan ISO/IEC 17025:2017</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="industri"><span class="scheme-num">Skema 18</span><span class="tag">Sistem Manajemen &amp; Industri</span><h3>Quality Management System (ISO 9001) Officer</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK bidang sains atau teknis, pengalaman kerja minimal 2 tahun di laboratorium atau industri</li><li>Memiliki Sertifikat Pelatihan ISO/IEC 9001:2015</li></ul><div class="req-group-label">Jalur 2 — D3 Fresh Graduate</div><ul class="req-list"><li>Fresh graduated D3 bidang sains atau Teknik</li><li>Magang di laboratorium atau industri minimal 3 bulan, atau Sertifikat Pelatihan ISO/IEC 9001:2015</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="laboratorium"><span class="scheme-num">Skema 19</span><span class="tag">Laboratorium &amp; Pengujian</span><h3>QC Laboratory Analyst / Analis QC Laboratorium</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK bidang sains atau teknis, pengalaman kerja minimal 2 tahun di laboratorium</li><li>Memiliki Sertifikat Pelatihan QC / ISO 9001:2015 / ISO 17025:2017</li></ul><div class="req-group-label">Jalur 2 — D3/S1</div><ul class="req-list"><li>Pendidikan minimal D3/S1 Teknik, Ilmu Gizi, Kimia, Biologi, atau Farmasi</li><li>Fresh graduated dan/atau pengalaman kerja di industri atau laboratorium</li><li>Memiliki Sertifikat Pelatihan QC / ISO 9001:2015 / ISO 17025:2017</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="industri"><span class="scheme-num">Skema 20</span><span class="tag">Sistem Manajemen &amp; Industri</span><h3>Quality Assurance Officer</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK bidang sains atau teknis, pengalaman kerja minimal 2 tahun di industri bagian quality assurance</li><li>Memiliki Sertifikat Pelatihan QAQC / ISO 9001 / ISO 17025</li></ul><div class="req-group-label">Jalur 2 — D3/S1</div><ul class="req-list"><li>Pendidikan minimal D3/S1 Teknik, Ilmu Gizi, Kimia, Biologi, atau Farmasi</li><li>Fresh graduated dan/atau pengalaman kerja di industri</li><li>Memiliki Sertifikat Pelatihan QAQC / ISO 9001 / ISO 17025</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="industri"><span class="scheme-num">Skema 21</span><span class="tag">Sistem Manajemen &amp; Industri</span><h3>Research and Development Officer</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK bidang sains atau teknis, pengalaman kerja minimal 2 tahun di laboratorium atau industri</li><li>Memiliki Sertifikat Pelatihan ISO 17025 / GMP (CPPOB, CPAKB, CPOIB)</li></ul><div class="req-group-label">Jalur 2 — D3/S1</div><ul class="req-list"><li>Pendidikan minimal D3/S1 Teknik, Ilmu Gizi, Kimia, Biologi, atau Farmasi</li><li>Fresh graduated dan/atau pengalaman kerja di industri atau laboratorium</li><li>Memiliki Sertifikat Pelatihan ISO 17025 / GMP (CPPOB, CPAKB, CPOIB)</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="industri"><span class="scheme-num">Skema 22</span><span class="tag">Sistem Manajemen &amp; Industri</span><h3>Regulatory Affairs Officer</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK bidang sains atau teknis, pengalaman kerja minimal 2 tahun di industri bagian quality assurance</li><li>Memiliki Sertifikat Pelatihan ISO 9001 / GMP (Good Manufacturing Practices)</li></ul><div class="req-group-label">Jalur 2 — D3/S1</div><ul class="req-list"><li>Pendidikan minimal D3/S1 Teknik, Ilmu Gizi, Kimia, Biologi, atau Farmasi</li><li>Fresh graduated dan/atau pengalaman kerja di industri</li><li>Memiliki Sertifikat Pelatihan ISO 9001 / GMP (Good Manufacturing Practices)</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="industri"><span class="scheme-num">Skema 23</span><span class="tag">Sistem Manajemen &amp; Industri</span><h3>Sustainability Officer</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK bidang sains atau teknis, pengalaman kerja minimal 2 tahun di laboratorium atau industri</li><li>Memiliki Sertifikat Pelatihan Sustainability / ESG / Manajemen Risiko</li></ul><div class="req-group-label">Jalur 2 — D3 Fresh Graduate</div><ul class="req-list"><li>Fresh graduated D3 bidang sains atau Teknik</li><li>Magang di laboratorium atau industri minimal 3 bulan, atau Sertifikat Pelatihan Sustainability / ESG / Manajemen Risiko</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="industri"><span class="scheme-num">Skema 24</span><span class="tag">Sistem Manajemen &amp; Industri</span><h3>ESG Officer</h3><div class="req-group-label">Jalur 1 — SMA/SMK</div><ul class="req-list"><li>Pendidikan minimal SMA/SMK bidang sains atau teknis, pengalaman kerja minimal 2 tahun di laboratorium atau industri</li><li>Memiliki Sertifikat Pelatihan Sustainability / ESG / Manajemen Risiko</li></ul><div class="req-group-label">Jalur 2 — D3 Fresh Graduate</div><ul class="req-list"><li>Fresh graduated D3 bidang sains atau Teknik</li><li>Magang di laboratorium atau industri minimal 3 bulan, atau Sertifikat Pelatihan Sustainability / ESG / Manajemen Risiko</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="industri"><span class="scheme-num">Skema 25</span><span class="tag">Sistem Manajemen &amp; Industri</span><h3>Environmental Management System (ISO 14001) Officer</h3><ul class="req-list"><li>Pendidikan minimal D3/S1 Teknik Lingkungan, Teknik Kimia, Kesehatan Lingkungan, atau bidang terkait</li><li>Fresh graduated atau magang di bidang EMS / pengelolaan lingkungan minimal 3 bulan</li><li>Memiliki Sertifikat Pelatihan ISO 14001:2015 Environmental Management System atau pelatihan terkait</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
      <div class="scheme" data-cat="hukum"><span class="scheme-num">Skema 26</span><span class="tag">Hukum Korporasi</span><h3>Corporate Legal Officer</h3><ul class="req-list"><li>Pendidikan minimal D3/S1 Ilmu Hukum dan Hukum Islam (terbuka untuk disiplin ilmu lain yang berminat di Corporate Legal)</li><li>Fresh graduated dan/atau pengalaman kerja di perusahaan atau korporasi</li><li>Memiliki Sertifikat Pelatihan Corporate Legal Officer</li></ul><div class="scheme-foot"><a class="unit-link" href="{{ route('skema') }}">Unit kompetensi <svg class="icon"><use href="#i-chev-r"></use></svg></a></div></div>
    </div>
  </div>
</section>

<!-- AKTIVITAS TERKINI — dinamis dari database -->
<section id="aktivitas">
  <div class="wrap">
    <div class="sec-head">
      <div class="eyebrow">Aktivitas Terkini</div>
      <h2>Kegiatan &amp; Dokumentasi LSP Edukia</h2>
      <p class="sub">Dokumentasi pelatihan, asesmen, dan kegiatan sertifikasi terbaru dari LSP Edukasi Global Cendekia.</p>
    </div>
    @if($kegiatan->count() > 0)
    <div class="slider-wrap">
      <div class="slider-viewport">
        <div class="slider-track" id="sliderTrack">
          @foreach($kegiatan as $item)
          <div class="slide">
            <div class="slide-img">
              <img src="{{ $item->foto_url }}" alt="{{ $item->judul }}" loading="lazy">
            </div>
            <div class="slide-body">
              <div class="slide-cat">{{ $item->tanggal->translatedFormat('d M Y') }}</div>
              <h4>{{ $item->judul }}</h4>
              @if($item->deskripsi)
              <p>{{ Str::limit($item->deskripsi, 100) }}</p>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="slider-nav">
        <button class="slider-btn" id="prevBtn" aria-label="Sebelumnya"><svg width="18" height="18"><use href="#i-arrow-l"></use></svg></button>
        <div class="slider-dots" id="sliderDots"></div>
        <button class="slider-btn" id="nextBtn" aria-label="Berikutnya"><svg width="18" height="18"><use href="#i-arrow-r"></use></svg></button>
      </div>
    </div>
    @else
    <p style="color:var(--muted);text-align:center;padding:48px 0">Belum ada kegiatan. Tambahkan di <a href="/admin/kegiatans" style="color:var(--blue)">panel admin</a>.</p>
    @endif
    <div style="text-align:center;margin-top:32px">
      <a href="{{ route('kegiatan.index') }}" class="btn btn-outline">Lihat semua kegiatan <svg class="icon"><use href="#i-arrow-r"></use></svg></a>
    </div>
  </div>
</section>

<!-- CTA -->
<section style="padding:0 0 96px;border-top:0">
  <div class="wrap">
    <div class="cta">
      <div class="cta-body">
        <h3>Siap memulai sertifikasi Anda?</h3>
        <p>Konsultasi GRATIS dengan tim kami — hubungi via WhatsApp sekarang.</p>
      </div>
      <a class="btn btn-primary btn-lg" href="{{ route('skema') }}">
        <svg class="icon"><use href="#i-doc"></use></svg> Lihat unit kompetensi
      </a>
      <a class="wa" href="https://wa.me/6285175479385">
        <svg class="icon" style="color:#7ee0a3"><use href="#i-wa"></use></svg>
        +62 851-7547-9385
      </a>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
const chips = document.querySelectorAll('#chips .chip');
const cards = document.querySelectorAll('#schemes .scheme');
chips.forEach(chip => {
  chip.addEventListener('click', () => {
    chips.forEach(c => c.classList.remove('active'));
    chip.classList.add('active');
    const filter = chip.dataset.filter;
    cards.forEach(card => {
      card.classList.toggle('hidden', filter !== 'all' && card.dataset.cat !== filter);
    });
  });
});

(function() {
  const track = document.getElementById('sliderTrack');
  if (!track) return;
  const dotsContainer = document.getElementById('sliderDots');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const slides = track.querySelectorAll('.slide');
  const total = slides.length;
  function getSlidesPerView() { return window.innerWidth < 960 ? 1 : 3; }
  let current = 0;
  let perView = getSlidesPerView();
  const maxIndex = () => Math.max(0, total - perView);
  function buildDots() {
    dotsContainer.innerHTML = '';
    for (let i = 0; i <= maxIndex(); i++) {
      const d = document.createElement('button');
      d.className = 'dot' + (i === 0 ? ' active' : '');
      d.setAttribute('aria-label', 'Slide ' + (i + 1));
      d.addEventListener('click', () => goTo(i));
      dotsContainer.appendChild(d);
    }
  }
  function goTo(idx) {
    current = Math.max(0, Math.min(idx, maxIndex()));
    const slideWidth = slides[0].getBoundingClientRect().width + 20;
    track.style.transform = 'translateX(-' + (current * slideWidth) + 'px)';
    dotsContainer.querySelectorAll('.dot').forEach((d, i) => d.classList.toggle('active', i === current));
    prevBtn.disabled = current === 0;
    nextBtn.disabled = current >= maxIndex();
  }
  prevBtn.addEventListener('click', () => goTo(current - 1));
  nextBtn.addEventListener('click', () => goTo(current + 1));
  function init() { perView = getSlidesPerView(); buildDots(); goTo(0); }
  window.addEventListener('resize', init);
  init();
})();
</script>
@endsection
