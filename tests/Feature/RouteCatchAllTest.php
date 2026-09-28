<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * Route blog `/{slug}` menangkap semua URL satu segmen, dengan daftar pengecualian manual di
 * routes/web.php. Test ini gagal bila ada halaman statis baru yang lupa ditambahkan ke
 * daftar itu (halamannya akan tertangkap sebagai slug blog → 404).
 */
class RouteCatchAllTest extends TestCase
{
    public function test_every_static_single_segment_get_route_resolves_to_itself(): void
    {
        $routes = Route::getRoutes();

        $statis = collect($routes->getRoutes())
            ->filter(fn ($r) => in_array('GET', $r->methods(), true))
            ->map(fn ($r) => $r->uri())
            ->filter(fn (string $uri) => $uri !== '/' && ! str_contains($uri, '{') && ! str_contains($uri, '/'))
            ->unique()
            ->values();

        $this->assertNotEmpty($statis);

        foreach ($statis as $uri) {
            $cocok = $routes->match(Request::create('/'.$uri, 'GET'));

            $this->assertSame(
                $uri,
                $cocok->uri(),
                "/{$uri} tertangkap oleh route '{$cocok->uri()}'. Tambahkan '{$uri}' ke pengecualian route blog.show di routes/web.php."
            );
        }
    }
}
