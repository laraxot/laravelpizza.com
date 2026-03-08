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
            'title' => // @var mixed faker->sentence(
            'slug' => // @var mixed faker->slug(
            'excerpt' => // @var mixed faker->sentence(
            'content' => // @var mixed faker->paragraphs(5, true
            'status' => 'published',
            'view_count' => 0,
            'meta_title' => // @var mixed faker->sentence(
            'meta_description' => // @var mixed faker->sentence(
            'meta_keywords' => // @var mixed faker->words(3, true
        ];
    }

    /**
     * Indicate that the post is published.
     */
    public function published(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'published',
        ]);
    }

    /**
     * Indicate that the post is draft.
     */
    public function draft(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'draft',
        ]);
    }

    /**
     * Configure the factory to create a post with featured image.
     */
    public function withFeaturedImage(): static
    {
        return // @var mixed afterCreating(function (Post $post
            $post->featuredImage()->create([
                'name' => $post->title.' Image',
                'path' => '/images/'.// @var mixed faker->word(
                'alt' => $post->title,
                'caption' => // @var mixed faker->sentence(
            ]);
        });
    }

    /**
     * Configure the factory to create a post with categories.
     */
    public function withCategories(): static
    {
        return // @var mixed afterCreating(function (Post $post
            $post->categories()->create([
                'name' => // @var mixed faker->word(
                'slug' => // @var mixed faker->slug(
            ]);
        });
    }

    /**
     * Configure the factory to create a post with tags.
     */
    public function withTags(): static
    {
        return // @var mixed afterCreating(function (Post $post
            $post->tags()->create([
                'name' => // @var mixed faker->word(
                'slug' => // @var mixed faker->slug(
            ]);
        });
    }
}
