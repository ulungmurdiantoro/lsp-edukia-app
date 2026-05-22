@props(['name'])

@php
$paths = [
  'building' => 'M3 21h18M5 21V7l7-4 7 4v14M9 9h.01M13 9h.01M9 13h.01M13 13h.01M9 17h6',
  'beaker'   => 'M9 3v6L4 19a2 2 0 002 3h12a2 2 0 002-3l-5-10V3M9 3h6M7 14h10',
  'crane'    => 'M3 21h18M6 21V8M6 8h13M6 8L4 6M6 8v3l4 4M19 8v2h-3',
  'factory'  => 'M3 21h18M5 21V11l5 3V11l5 3V8l4-3v16',
  'scale'    => 'M12 3v18M5 7h14M7 21h10M5 7l-3 7h6L5 7zM19 7l-3 7h6l-3-7z',
];
@endphp

<svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'none',
                            'stroke' => 'currentColor', 'stroke-width' => '1.6',
                            'stroke-linejoin' => 'round', 'stroke-linecap' => 'round']) }}>
  <path d="{{ $paths[$name] ?? '' }}" />
</svg>
