/* global React, ReactDOM */

function Canvas() {
  return (
    <window.DesignCanvas>
      {/* -------------------------------------------------- */}
      <window.DCSection
        id="foundations"
        title="Fondasi visual"
        subtitle="Brand colors & typography yang dipertahankan, plus ringkasan dua arah desain.">
        <window.DCArtboard id="foundations" label="Brand foundations" width={1400} height={780}>
          <window.Foundations />
        </window.DCArtboard>
      </window.DCSection>

      {/* -------------------------------------------------- */}
      <window.DCSection
        id="skema-cards"
        title="Card Skema Kompetensi — refine variant B"
        subtitle="4 micro-variations dari arah B. Pilih master atau campur per konteks.">
        <window.DCArtboard id="skema-micro" label="4 Micro-variations · B1–B4" width={1640} height={1240}>
          <window.SkemaCardMicroVariants />
        </window.DCArtboard>
        <window.DCArtboard id="skema-before-after" label="Before · A · B (context)" width={1320} height={840}>
          <window.SkemaCardCompare />
        </window.DCArtboard>
      </window.DCSection>

      {/* -------------------------------------------------- */}
      <window.DCSection
        id="home"
        title="Beranda — Variant B"
        subtitle="Hero, alur sertifikasi, daftar skema, aktivitas, CTA, footer.">
        <window.DCArtboard id="home-b" label="Desktop · 1440" width={1440} height={3680}>
          <window.PageHome variant="b" />
        </window.DCArtboard>
      </window.DCSection>

      {/* -------------------------------------------------- */}
      <window.DCSection
        id="skema-page"
        title="Halaman Skema Kompetensi"
        subtitle="Header, page hero, filter chips, grid skema, CTA, footer.">
        <window.DCArtboard id="skema-page-b" label="Desktop · 1440" width={1440} height={2600}>
          <window.PageSkema variant="b" />
        </window.DCArtboard>
      </window.DCSection>

      {/* -------------------------------------------------- */}
      <window.DCSection
        id="tentang"
        title="Tentang Kami"
        subtitle="Profil lembaga, visi, misi, nilai, komitmen mutu, struktur organisasi.">
        <window.DCArtboard id="tentang-b" label="Desktop · 1440" width={1440} height={4420}>
          <window.PageTentang variant="b" />
        </window.DCArtboard>
      </window.DCSection>

      {/* -------------------------------------------------- */}
      <window.DCSection
        id="sertifikat"
        title="Daftar Penerima Sertifikat"
        subtitle="Tabel pemegang sertifikat dengan search, filter bidang & status, pagination.">
        <window.DCArtboard id="sertifikat-list" label="Desktop · 1440 (list + search)" width={1440} height={2400}>
          <window.PageSertifikatList />
        </window.DCArtboard>
      </window.DCSection>

      {/* -------------------------------------------------- */}
      <window.DCSection
        id="informasi"
        title="Informasi Publik"
        subtitle="Hak & kewajiban, proses sertifikasi, pembekuan, resertifikasi, keluhan & banding.">
        <window.DCArtboard id="informasi-b" label="Desktop · 1440" width={1440} height={4400}>
          <window.PageInformasi />
        </window.DCArtboard>
      </window.DCSection>

      {/* -------------------------------------------------- */}
      <window.DCSection
        id="blog"
        title="Blog — list & detail"
        subtitle="Halaman index artikel dan halaman baca artikel.">
        <window.DCArtboard id="blog-list" label="Index · 1440" width={1440} height={1850}>
          <window.PageBlog variant="b" />
        </window.DCArtboard>
        <window.DCArtboard id="blog-detail" label="Detail · 1440 (article reader)" width={1440} height={2900}>
          <window.PageBlogDetail />
        </window.DCArtboard>
      </window.DCSection>

      {/* -------------------------------------------------- */}
      <window.DCSection
        id="mobile"
        title="Mobile views · 390px"
        subtitle="Pratinjau responsive untuk halaman-halaman utama. Drag artboard untuk merapikan urutan.">
        <window.DCArtboard id="mob-home" label="Beranda · 390" width={390} height={1480}>
          <window.MobileHome />
        </window.DCArtboard>
        <window.DCArtboard id="mob-skema" label="Skema · 390" width={390} height={1450}>
          <window.MobileSkema />
        </window.DCArtboard>
        <window.DCArtboard id="mob-sertifikat" label="Sertifikat · 390" width={390} height={1300}>
          <window.MobileSertifikat />
        </window.DCArtboard>
        <window.DCArtboard id="mob-tentang" label="Tentang · 390" width={390} height={1500}>
          <window.MobileTentang />
        </window.DCArtboard>
      </window.DCSection>
    </window.DesignCanvas>
  );
}

ReactDOM.createRoot(document.getElementById('root')).render(<Canvas />);
