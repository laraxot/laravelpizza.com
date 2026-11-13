<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cms\Models\PageContent;

/**
 * @extends Factory<PageContent>
 */
class PageContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = PageContent::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}
