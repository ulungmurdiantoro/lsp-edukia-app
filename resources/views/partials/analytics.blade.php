{{-- Verifikasi & analytics (Fase 1). Hanya dirender bila token diisi di .env. --}}
@if ($token = config('site.gsc_verification'))
<meta name="google-site-verification" content="{{ $token }}">
@endif
@if ($token = config('site.bing_verification'))
<meta name="msvalidate.01" content="{{ $token }}">
@endif
@if (($ga = config('site.google_analytics_id')) && ! request()->is('admin*'))
<link rel="preconnect" href="https://www.googletagmanager.com">
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ $ga }}');
</script>
@endif
