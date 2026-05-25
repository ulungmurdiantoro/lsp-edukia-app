<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

  @foreach($staticPages as $page)
  <url>
    <loc>{{ $page['url'] }}</loc>
    <changefreq>{{ $page['changefreq'] }}</changefreq>
    <priority>{{ $page['priority'] }}</priority>
  </url>
  @endforeach

  @foreach($posts as $post)
  <url>
    <loc>{{ route('blog.show', $post->slug) }}</loc>
    <lastmod>{{ $post->updated_at->toAtomString() }}</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.6</priority>
    @if($post->thumbnail && !str_starts_with($post->thumbnail, 'http'))
    <image:image>
      <image:loc>{{ asset('storage/' . $post->thumbnail) }}</image:loc>
    </image:image>
    @elseif($post->thumbnail && str_starts_with($post->thumbnail, 'http'))
    <image:image>
      <image:loc>{{ $post->thumbnail }}</image:loc>
    </image:image>
    @endif
  </url>
  @endforeach

</urlset>
