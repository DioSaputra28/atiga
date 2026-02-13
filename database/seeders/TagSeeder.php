<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'pph21', 'pph22', 'pph23', 'pphfinal', 'ppn', 'faktur-pajak',
            'espt', 'efiling', 'djponline', 'tax-amnesty', 'pemeriksaan',
            'spt-tahunan', 'spt-masa', 'bupot', 'ebupot', 'tax-planning',
            'konsultan-pajak', 'peraturan-baru', 'pmk', 'per',
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
                'slug' => $tag,
            ]);
        }
    }
}
