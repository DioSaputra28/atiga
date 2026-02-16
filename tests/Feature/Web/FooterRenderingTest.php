<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FooterRenderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_footer_renders_on_homepage(): void
    {
        $response = $this->get('/');

        $response->assertSuccessful();

        $response->assertSee('Konsultan Pajak & Kepatuhan Bisnis', false);
        $response->assertSee('Hubungi Kami');
    }

    public function test_footer_uses_mobile_first_grid_and_spacing_classes(): void
    {
        $response = $this->get('/');

        $response->assertSuccessful();

        $response->assertSee('px-3 py-8 sm:px-4 sm:py-10 lg:py-12', false);
        $response->assertSee('grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-8 lg:grid-cols-4', false);
        $response->assertSee('text-base font-extrabold sm:text-lg', false);
    }

    public function test_footer_links_and_contact_blocks_scale_for_small_screens(): void
    {
        $response = $this->get('/');

        $response->assertSuccessful();

        $response->assertSee('space-y-1.5 text-sm leading-6 text-white/70 sm:space-y-2', false);
        $response->assertSee('block px-1 py-2 hover:text-accent sm:px-0', false);
        $response->assertSee('space-y-3 text-sm leading-6 text-white/70', false);
        $response->assertSee('flex items-start gap-2.5 sm:gap-3', false);
    }
}
