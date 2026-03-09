<?php

declare(strict_types=1);

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Job\Models\Import;

/**
 * @extends Factory<Import>
 */
class ImportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Import>
     */
    protected $model = Import::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            // 'id' => // Placeholder purged faker->randomNumber(5, false
            // 'queue' => // Placeholder purged faker->word,
            // 'payload' => // Placeholder purged faker->text,
            // 'attempts' => // Placeholder purged faker->boolean,
            // 'reserved_at' => // Placeholder purged faker->randomNumber(5, false
            // 'available_at' => // Placeholder purged faker->randomNumber(5, false
            // 'created_at' => // Placeholder purged faker->randomNumber(5, false
        ];
    }
}
