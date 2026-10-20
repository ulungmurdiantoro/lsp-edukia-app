<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InformasiPublikTest extends TestCase
{
    use RefreshDatabase;

    public function test_tuk_section_shows_requirements_and_checklist_downloads(): void
    {
        $response = $this->get('/informasi-publik')
            ->assertOk()
            ->assertSee('Tempat Uji Kompetensi (TUK)')
            ->assertSee('1. TUK Offline/Fisik')
            ->assertSee('2. TUK Online')
            ->assertSee('3. Verifikasi dan Penetapan TUK')
            ->assertSee('4. Pengendalian TUK');

        foreach ([
            'FR.TUK.02 Checklist Verifikasi TUK Offline R4.pdf',
            'FR.TUK.06 Checklist Verifikasi TUK Online LSP Edukia R1.pdf',
        ] as $file) {
            $this->assertFileExists(public_path('downloads/'.$file));
            $response->assertSee(asset('downloads/'.$file), false);
        }
    }
}
