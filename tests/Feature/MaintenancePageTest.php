<?php

namespace Tests\Feature;

use Tests\TestCase;

class MaintenancePageTest extends TestCase
{
    protected function tearDown(): void
    {
        $this->app->maintenanceMode()->deactivate();

        parent::tearDown();
    }

    public function test_maintenance_mode_shows_custom_page(): void
    {
        $this->app->maintenanceMode()->activate([]);

        $this->get('/')
            ->assertStatus(503)
            ->assertSee('Sedang Pemeliharaan')
            ->assertSee('meningkatkan')
            ->assertSee('https://wa.me/'.config('site.whatsapp'), false)
            ->assertSee(config('site.email'));
    }
}
