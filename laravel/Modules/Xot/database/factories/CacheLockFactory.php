<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\CacheLock;

/**
 * @extends Factory<CacheLock>
 */
class CacheLockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<CacheLock>
     */
    protected $model = CacheLock::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'key' => $faker->word,
            'owner' => $faker->word,
            'expiration' => $faker->randomNumber(5),
        ];
    }
}
