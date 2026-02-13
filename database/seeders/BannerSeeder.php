<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create hero banners
        Banner::factory()
            ->count(3)
            ->hero()
            ->running()
            ->create();

        // Create sidebar banners
        Banner::factory()
            ->count(4)
            ->sidebar()
            ->running()
            ->create();

        // Create footer banners
        Banner::factory()
            ->count(2)
            ->create([
                'type' => Banner::TYPE_FOOTER,
                'is_active' => true,
            ]);

        // Create 1 inactive banner
        Banner::factory()
            ->inactive()
            ->create();
    }
}
