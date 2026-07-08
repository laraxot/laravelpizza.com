<?php

/**
 * Xot Seeder Helper Functions.
 *
 * This file contains helper functions for seeding data with Xot modules
 * The functions ensure that models are only seeded once
 */

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

/**
 * Seed a model once per application lifetime.
 *
 * @param string $modelClass The model class to seed (e.g., '\Modules\Notify\Models\NotificationType')
 */
function xotSeedModelOnce(string $modelClass): void
{
    // Skip if already seeded
    $cacheKey = "xot_seeder:{$modelClass}";
    if (Cache::has($cacheKey)) {
        return;
    }

    // Import the model class
    $modelInstance = app($modelClass);
    if (! $modelInstance instanceof Model) {
        return;
    }

    // Check if model exists
    if ($modelInstance->newQuery()->count() > 0) {
        // Model already exists, mark as seeded
        Cache::put($cacheKey, true, 24 * 60 * 60); // Cache for 24 hours

        return;
    }

    // Get the seeds from the seeder class
    // This assumes there's a standard seeder file named with the format
    // {ModelName}Seeder.php in the seeders directory
    $seederClass = $modelClass.'Seeder';

    try {
        // Check if seeder class exists
        if (class_exists($seederClass)) {
            // Create seeder instance and run its seed method
            $seeder = new $seederClass();

            if ($seeder instanceof Seeder && is_callable([$seeder, 'run'])) {
                $seeder->{'run'}();

                // Mark as seeded
                Cache::put($cacheKey, true, 24 * 60 * 60);
            }
        }
    } catch (Exception $e) {
        // Log error but don't crash
    }
}
