<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pajak Penghasilan',
                'slug' => 'pajak-penghasilan',
                'description' => 'Artikel seputar perpajakan penghasilan, PPh 21, PPh 22, PPh 23, dan PPh final.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Pajak Pertambahan Nilai',
                'slug' => 'pajak-pertambahan-nilai',
                'description' => 'Informasi tentang PPN, faktur pajak, dan pengkreditan PPN.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Peraturan Perpajakan',
                'slug' => 'peraturan-perpajakan',
                'description' => 'Update terbaru peraturan perpajakan dan kebijakan fiskal.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Tax Planning',
                'slug' => 'tax-planning',
                'description' => 'Strategi perencanaan pajak yang efektif dan efisien.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Tips & Trik',
                'slug' => 'tips-trik',
                'description' => 'Tips praktis dalam menghadapi masalah perpajakan.',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
