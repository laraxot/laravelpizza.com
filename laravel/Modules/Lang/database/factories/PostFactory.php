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
            'title' => // @var mixed faker->sentence(6
            'slug' => // @var mixed faker->slug(
            'content' => // @var mixed faker->paragraphs(3, true
            'excerpt' => // @var mixed faker->text(200
            'status' => // @var mixed faker->randomElement(['draft', 'published', 'archived']
            'published_at' => // @var mixed faker->optional(0.7
            'locale' => // @var mixed faker->randomElement(['it', 'en', 'de']
        ];
    }

    public function published(): static
    {
        return // @var mixed state(fn (array $_attributes
            'status' => 'published',
            'published_at' => // @var mixed faker->dateTimeBetween('-1 year', 'now'
        ]);
    }

    public function draft(): static
    {
        return // @var mixed state(fn (array $_attributes
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    public function italian(): static
    {
        return // @var mixed state(fn (array $_attributes
            'locale' => 'it',
        ]);
    }
}
