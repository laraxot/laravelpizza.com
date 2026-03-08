<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cms\Models\Page;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

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
            'content' => // @var mixed faker->paragraphs(3, true
            'excerpt' => // @var mixed faker->sentence(
            'status' => 'published',
            'template' => 'default',
            'view_count' => 0,
            'meta_title' => // @var mixed faker->sentence(
            'meta_description' => // @var mixed faker->sentence(
            'meta_keywords' => // @var mixed faker->words(3, true
        ];
    }

    /**
     * Indicate that the page is published.
     */
    public function published(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'published',
        ]);
    }

    /**
     * Indicate that the page is draft.
     */
    public function draft(): static
    {
        return // @var mixed state(fn (array $attributes
            'status' => 'draft',
        ]);
    }

    /**
     * Configure the factory to create a page with SEO metadata.
     */
    public function withSeo(): static
    {
        return // @var mixed afterCreating(function (Page $page
            $page->seo()->create([
                'meta_title' => $page->title.' - SEO Title',
                'meta_description' => $page->meta_description,
                'meta_keywords' => $page->meta_keywords,
                'og_title' => $page->title,
                'og_description' => $page->meta_description,
                'twitter_card' => 'summary',
            ]);
        });
    }

    /**
     * Configure the factory to create a page with blocks.
     */
    public function withBlocks(): static
    {
        return // @var mixed afterCreating(function (Page $page
            $page->blocks()->create([
                'type' => 'text',
                'content' => // @var mixed faker->paragraph(
                'order' => 1,
            ]);
        });
    }
}
