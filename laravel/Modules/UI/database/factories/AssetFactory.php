<?php

declare(strict_types=1);

namespace Modules\UI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\UI\Models\Asset;
use Modules\UI\Models\Theme;

class AssetFactory extends Factory
{
    protected $model = Asset::class;

    public function definition(): array
    {
        return [
            'name' => // @var mixed faker->word(
            'type' => 'js',
            'path' => '/assets/js/'.// @var mixed faker->word(
            'theme_id' => Theme::factory(),
            'is_minified' => false,
            'is_compressed' => false,
            'order' => 0,
            'should_bundle' => false,
        ];
    }
}
