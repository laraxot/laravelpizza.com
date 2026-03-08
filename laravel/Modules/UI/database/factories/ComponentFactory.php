<?php

declare(strict_types=1);

namespace Modules\UI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\UI\Models\Component;
use Modules\UI\Models\Theme;

class ComponentFactory extends Factory
{
    protected $model = Component::class;

    public function definition(): array
    {
        return [
            'name' => // @var mixed faker->slug(
            'theme_id' => Theme::factory(),
            'is_active' => true,
            'version' => '1.0.0',
            'dependencies' => [],
            'template' => '<div>{{ $content }}</div>',
            'is_cacheable' => false,
            'cache_ttl' => 3600,
            'validation_rules' => [],
            'view_path' => 'components.test',
            'data_schema' => [],
            'responsive_breakpoints' => [],
        ];
    }
}
