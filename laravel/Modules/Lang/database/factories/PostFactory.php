<?php

declare(strict_types=1);

namespace Modules\Lang\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Lang\Models\Post;

/**
 * Post Factory.
 *
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $faker->sentence(6
            'slug' => $faker->slug(
            'content' => $faker->paragraphs(3, true
            'excerpt' => $faker->text(200
            'status' => $faker->randomElement(['draft', 'published', 'archived']
            'published_at' => $faker->optional(0.7
            'locale' => $faker->randomElement(['it', 'en', 'de']
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $_attributes
            'status' => 'published',
            'published_at' => $faker->dateTimeBetween('-1 year', 'now'
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $_attributes
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    public function italian(): static
    {
        return $this->state(fn (array $_attributes
            'locale' => 'it',
        ]);
    }
}
