<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\Cache;

/**
 * @extends Factory<Cache>
 */
class CacheFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Cache>
     */
    protected $model = Cache::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'key' => $this->faker->word,
            'value' => $this->faker->text,
            'expiration' => $this->faker->randomNumber(5),
        ];
    }
}
