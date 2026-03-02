<?php

namespace Tests\Feature\Web;

use App\Models\AboutPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationRenderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_navbar_renders_with_responsive_classes(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('px-3');
        $response->assertSee('sm:px-4');

        $response->assertSee('h-9');
        $response->assertSee('w-9');
        $response->assertSee('sm:h-11');
        $response->assertSee('sm:w-11');

        $response->assertSee('text-lg');
        $response->assertSee('sm:text-xl');

        $response->assertSee('min-h-[44px]');
        $response->assertSee('min-w-[44px]');
    }

    public function test_mobile_menu_has_accessible_touch_targets(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('id="mobile-menu"', false);

        $response->assertSee('py-3');
    }

    public function test_about_navigation_link_is_hidden_when_about_page_is_unpublished(): void
    {
        AboutPage::factory()->create([
            'is_published' => false,
        ]);

        $response = $this->get('/');

        $response->assertSuccessful();
        $response->assertDontSee('href="'.route('about', [], false).'"', false);
        $response->assertDontSeeText('Tentang Kami');
    }

    public function test_about_navigation_link_is_visible_when_about_page_is_published(): void
    {
        AboutPage::factory()->create([
            'is_published' => true,
        ]);

        $response = $this->get('/');

        $response->assertSuccessful();
        $response->assertSee('href="'.route('about', [], false).'"', false);
        $response->assertSeeText('Tentang Kami');
    }
}
