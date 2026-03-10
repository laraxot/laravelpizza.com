<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cms\Models\Post;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /** @var class-string<Post> */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'excerpt' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(5, true),
            'status' => 'published',
            'view_count' => 0,
            'meta_title' => $this->faker->sentence(),
            'meta_description' => $this->faker->sentence(),
            'meta_keywords' => $this->faker->words(3, true),
        ];
    }

    /**
     * Indicate that the post is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
        ]);
    }

    /**
     * Indicate that the post is draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }

    /**
     * Configure the factory to create a post with featured image.
     */
    public function withFeaturedImage(): static
    {
        return $this->afterCreating(function (Post $post): void {
            $post->featuredImage()->create([
                'name' => $post->title.' Image',
                'path' => '/images/'.$this->faker->word(),
                'alt' => $post->title,
                'caption' => $this->faker->sentence(),
            ]);
        });
    }

    /**
     * Configure the factory to create a post with categories.
     */
    public function withCategories(): static
    {
        return $this->afterCreating(function (Post $post): void {
            $post->categories()->create([
                'name' => $this->faker->word(),
                'slug' => $this->faker->slug(),
            ]);
        });
    }

    /**
     * Configure the factory to create a post with tags.
     */
    public function withTags(): static
    {
        return $this->afterCreating(function (Post $post): void {
            $post->tags()->create([
                'name' => $this->faker->word(),
                'slug' => $this->faker->slug(),
            ]);
        });
    }
}
