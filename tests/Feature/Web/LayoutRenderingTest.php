<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LayoutRenderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_layout_has_mobile_viewport_meta_tag(): void
    {
        $response = $this->get('/');

        $response->assertSuccessful();

        $response->assertSee('<meta name="viewport" content="width=device-width, initial-scale=1.0">', false);
    }

    public function test_base_layout_shell_prevents_horizontal_overflow_at_mobile_widths(): void
    {
        $response = $this->get('/');

        $response->assertSuccessful();

        $response->assertSee('min-h-screen', false);
        $response->assertSee('overflow-x-hidden', false);
        $response->assertSee('flex min-h-screen flex-col', false);
        $response->assertSee('overflow-x-clip', false);
    }

    public function test_main_layout_container_uses_mobile_first_width_and_growth_classes(): void
    {
        $response = $this->get('/');

        $response->assertSuccessful();

        $response->assertSee('<main class="flex-1 min-w-0">', false);
    }
}
