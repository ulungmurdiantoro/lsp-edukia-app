@php($a = $analysis)
<div style="font-size:13px">
  <div style="display:flex;align-items:center;gap:14px;margin-bottom:14px">
    <div style="position:relative;width:56px;height:56px;flex:0 0 auto;border-radius:50%;
                background:conic-gradient({{ $a['color'] }} {{ $a['score'] * 3.6 }}deg, #e6e9f0 0);
                display:grid;place-items:center">
      <div style="width:42px;height:42px;border-radius:50%;background:#fff;display:grid;place-items:center;
                  font-weight:800;font-size:15px;color:{{ $a['color'] }}">{{ $a['score'] }}</div>
    </div>
    <div>
      <div style="font-weight:700;font-size:15px;color:{{ $a['color'] }}">Skor SEO: {{ $a['label'] }}</div>
      <div style="color:#5a6a85;font-size:12px">Skor {{ $a['score'] }}/100 — perbaiki item merah/oranye di bawah.</div>
    </div>
  </div>

  <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:7px">
    @foreach($a['checks'] as $c)
      @php($dot = ['good' => '#2f8a55', 'ok' => '#d77110', 'bad' => '#c0532e'][$c['status']])
      @php($icon = ['good' => '&check;', 'ok' => '!', 'bad' => '&times;'][$c['status']])
      <li style="display:flex;align-items:flex-start;gap:9px;line-height:1.45">
        <span style="flex:0 0 auto;width:17px;height:17px;border-radius:50%;background:{{ $dot }};color:#fff;
                     font-size:11px;font-weight:800;display:grid;place-items:center;margin-top:1px">{!! $icon !!}</span>
        <span style="color:#2a3a55">{{ $c['text'] }}</span>
      </li>
    @endforeach
  </ul>
</div>
