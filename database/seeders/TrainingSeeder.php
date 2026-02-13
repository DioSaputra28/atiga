<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 8 upcoming trainings
        Training::factory()
            ->count(8)
            ->upcoming()
            ->create();

        // Create 2 featured upcoming trainings
        Training::factory()
            ->count(2)
            ->upcoming()
            ->featured()
            ->create();

        // Create 5 completed trainings
        Training::factory()
            ->count(5)
            ->create([
                'status' => Training::STATUS_COMPLETED,
            ]);

        // Create 2 free trainings
        Training::factory()
            ->count(2)
            ->upcoming()
            ->free()
            ->create([
                'title' => 'Webinar Gratis: ' . fake()->sentence(4),
            ]);
    }
}
