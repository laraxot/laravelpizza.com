<?php

declare(strict_types=1);

namespace Modules\UI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
<<<<<<< HEAD
use Modules\UI\Models\Category;

=======
use Illuminate\Support\Str;
use Modules\UI\Models\Category;

/**
 * @extends Factory<Category>
 */
>>>>>>> 40b96bcd6 (.)
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
<<<<<<< HEAD
        return [];
=======
        /** @var string $title */
        $title = fake()->sentence(2);

        return [
            'title' => $title,
            'slug' => Str::slug((string) $title).'-'.fake()->unique()->numerify('###'),
            'is_active' => 1,
            'sort_order' => 0,
        ];
>>>>>>> 40b96bcd6 (.)
    }
}
