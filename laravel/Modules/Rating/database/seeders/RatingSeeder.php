<?php

declare(strict_types=1);

namespace Modules\Rating\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Rating\Models\Rating;

/**
 * Rating base Sì/No — schema ratings (title, color) usati da PredictSeeder.
 */
class RatingSeeder extends Seeder
{
    public function run(): void
    {
        Rating::query()->firstOrCreate(
            ['title' => 'Sì'],
            ['color' => '#10B981'],
        );

        Rating::query()->firstOrCreate(
            ['title' => 'No'],
            ['color' => '#EF4444'],
        );
    }
}
