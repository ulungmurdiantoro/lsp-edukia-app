{{-- Daftar jadwal per bulan. $bulan: "Bulan YYYY" => Collection<JadwalSertifikasi>; $bidangLabels: Skemas::bidangs(). --}}
@foreach($bulan as $label => $items)
<div class="jadwal-group">
  <div class="jadwal-group-head">
    <h2>{{ $label }}</h2>
    <span class="cnt">{{ $items->count() }} jadwal</span>
  </div>
  <div class="jadwal-list">
    @foreach($items as $item)
    @php
      $lewat = $item->tanggal_sertifikasi->lt(now()->startOfDay());
      $tautSkema = ! $lewat && $item->skema_slug;
      $metode = $item->metode ?: 'online';
      $metodeLabel = \App\Models\JadwalSertifikasi::METODE[$metode] ?? ucfirst($metode);
    @endphp
    <div @class(['jadwal-item', 'past' => $lewat, 'linked' => $tautSkema])>
      <div class="jadwal-item-info">
        <p class="jadwal-item-meta">
          {{ $item->tanggal_sertifikasi->translatedFormat('d M Y') }}
          <span class="jadwal-bidang">{{ $bidangLabels[$item->bidang]['label'] ?? $item->bidang }}</span>
          <span @class(['jadwal-metode', $metode])>
            <svg width="12" height="12"><use href="#i-{{ $metode === 'offline' ? 'pin' : 'monitor' }}"></use></svg>
            {{ $metodeLabel }}
          </span>
        </p>
        @if($tautSkema)
          <a class="jadwal-item-skema" href="{{ route('skema.show', $item->skema_slug) }}">{{ $item->skema }}</a>
        @else
          <span class="jadwal-item-skema">{{ $item->skema }}</span>
        @endif
      </div>
      <div class="jadwal-item-action">
        @if($lewat)
          <span class="jadwal-status-done">Selesai</span>
        @else
          <a class="jadwal-btn" href="https://wa.me/{{ config('site.whatsapp') }}?text={{ urlencode('Halo, saya ingin mendaftar sertifikasi ' . $item->skema . ' pada jadwal ' . $item->tanggal_sertifikasi->translatedFormat('d M Y') . ' (' . $metodeLabel . ').') }}" target="_blank" rel="noopener">Daftar</a>
        @endif
      </div>
    </div>
    @endforeach
  </div>
</div>
@endforeach
