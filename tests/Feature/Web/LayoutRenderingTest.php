<?php

namespace Tests\Feature\Web;

use App\Settings\SiteSetting;
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

    public function test_floating_whatsapp_popup_renders_when_social_whatsapp_is_configured(): void
    {
        $siteSetting = app(SiteSetting::class);
        $siteSetting->social_whatsapp = '6281234567890';
        $siteSetting->save();

        $response = $this->get('/');

        $response->assertSuccessful();
        $response->assertSee('https://wa.me/6281234567890');
        $response->assertSeeText('Chat WhatsApp');
        $response->assertSee('fixed bottom-4 right-4', false);
    }

    public function test_floating_whatsapp_popup_does_not_render_when_social_whatsapp_is_null(): void
    {
        $siteSetting = app(SiteSetting::class);
        $siteSetting->social_whatsapp = null;
        $siteSetting->save();

        $response = $this->get('/');

        $response->assertSuccessful();
        $response->assertDontSee('https://wa.me/');
        $response->assertDontSeeText('Chat WhatsApp');
    }
}
