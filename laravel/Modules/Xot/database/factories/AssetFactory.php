<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\UI\Models\Asset;

/**
 * @extends Factory<Asset>
 */
class AssetFactory extends Factory
{
    protected $model = Asset::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $faker->word(
            'path' => '/assets/'.$faker->word(
            'type' => 'css',
            'version' => '1.0.0',
            'is_public' => $faker->boolean(
        ];
    }

    /**
     * Indicate that the asset is public.
     */
    public function public(): static
    {
        return $this->state(fn (array $attributes
            'is_public' => true,
        ]);
    }

    /**
     * Indicate that the asset is private.
     */
    public function private(): static
    {
        return $this->state(fn (array $attributes
            'is_public' => false,
        ]);
    }
}
