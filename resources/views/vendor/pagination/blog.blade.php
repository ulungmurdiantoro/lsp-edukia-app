@if ($paginator->hasPages())
<nav style="display:flex;align-items:center;justify-content:center;gap:6px;flex-wrap:wrap">

  {{-- Prev --}}
  @if ($paginator->onFirstPage())
  <span style="height:40px;padding:0 16px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--muted);font-size:13.5px;font-weight:600;display:inline-flex;align-items:center;gap:6px;opacity:.45;cursor:default">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    Sebelumnya
  </span>
  @else
  <a href="{{ $paginator->previousPageUrl() }}" style="height:40px;padding:0 16px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--ink-2);font-size:13.5px;font-weight:600;display:inline-flex;align-items:center;gap:6px;text-decoration:none;transition:border-color .12s,color .12s" onmouseover="this.style.borderColor='var(--navy-800)';this.style.color='var(--navy-800)'" onmouseout="this.style.borderColor='var(--line)';this.style.color='var(--ink-2)'">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    Sebelumnya
  </a>
  @endif

  {{-- Page numbers --}}
  @foreach ($elements as $element)
    @if (is_string($element))
    <span style="height:40px;width:40px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;color:var(--muted);font-size:14px">…</span>
    @endif

    @if (is_array($element))
      @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <span style="height:40px;min-width:40px;padding:0 12px;border-radius:10px;background:var(--navy-800);color:#fff;font-size:13.5px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;border:1px solid var(--navy-800)">{{ $page }}</span>
        @else
        <a href="{{ $url }}" style="height:40px;min-width:40px;padding:0 12px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--ink-2);font-size:13.5px;font-weight:600;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;transition:border-color .12s,color .12s" onmouseover="this.style.borderColor='var(--navy-800)';this.style.color='var(--navy-800)'" onmouseout="this.style.borderColor='var(--line)';this.style.color='var(--ink-2)'">{{ $page }}</a>
        @endif
      @endforeach
    @endif
  @endforeach

  {{-- Next --}}
  @if ($paginator->hasMorePages())
  <a href="{{ $paginator->nextPageUrl() }}" style="height:40px;padding:0 16px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--ink-2);font-size:13.5px;font-weight:600;display:inline-flex;align-items:center;gap:6px;text-decoration:none;transition:border-color .12s,color .12s" onmouseover="this.style.borderColor='var(--navy-800)';this.style.color='var(--navy-800)'" onmouseout="this.style.borderColor='var(--line)';this.style.color='var(--ink-2)'">
    Berikutnya
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
  </a>
  @else
  <span style="height:40px;padding:0 16px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--muted);font-size:13.5px;font-weight:600;display:inline-flex;align-items:center;gap:6px;opacity:.45;cursor:default">
    Berikutnya
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
  </span>
  @endif

</nav>
@endif
