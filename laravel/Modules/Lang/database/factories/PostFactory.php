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
            'title' => $this->faker->sentence(6),
            'slug' => $this->faker->slug(),
            'content' => $this->faker->paragraphs(3, true),
            'excerpt' => $this->faker->text(200),
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'published_at' => $this->faker->optional(0.7)->dateTimeBetween('-1 year', 'now'),
            'locale' => $this->faker->randomElement(['it', 'en', 'de']),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'status' => 'published',
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    public function italian(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'locale' => 'it',
        ]);
    }
}
