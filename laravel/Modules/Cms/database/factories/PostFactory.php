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
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $faker->sentence(
            'slug' => $faker->slug(
            'excerpt' => $faker->sentence(
            'content' => $faker->paragraphs(5, true
            'status' => 'published',
            'view_count' => 0,
            'meta_title' => $faker->sentence(
            'meta_description' => $faker->sentence(
            'meta_keywords' => $faker->words(3, true
        ];
    }

    /**
     * Indicate that the post is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes
            'status' => 'published',
        ]);
    }

    /**
     * Indicate that the post is draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes
            'status' => 'draft',
        ]);
    }

    /**
     * Configure the factory to create a post with featured image.
     */
    public function withFeaturedImage(): static
    {
        return $this->afterCreating(function (Post $post
            $post->featuredImage()->create([
                'name' => $post->title.' Image',
                'path' => '/images/'.$faker->word(
                'alt' => $post->title,
                'caption' => $faker->sentence(
            ]);
        });
    }

    /**
     * Configure the factory to create a post with categories.
     */
    public function withCategories(): static
    {
        return $this->afterCreating(function (Post $post
            $post->categories()->create([
                'name' => $faker->word(
                'slug' => $faker->slug(
            ]);
        });
    }

    /**
     * Configure the factory to create a post with tags.
     */
    public function withTags(): static
    {
        return $this->afterCreating(function (Post $post
            $post->tags()->create([
                'name' => $faker->word(
                'slug' => $faker->slug(
            ]);
        });
    }
}
