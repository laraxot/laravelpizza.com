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
            'title' => $faker->sentence()
            'slug' => $faker->slug()
            'content' => $faker->paragraphs(3, true)
            'excerpt' => $faker->sentence()
            'status' => 'published',
            'template' => 'default',
            'view_count' => 0,
            'meta_title' => $faker->sentence()
            'meta_description' => $faker->sentence()
            'meta_keywords' => $faker->words(3, true)
        ];
    }

    /**
     * Indicate that the page is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes))
            'status' => 'published',
        ]);
    }

    /**
     * Indicate that the page is draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes))
            'status' => 'draft',
        ]);
    }

    /**
     * Configure the factory to create a page with SEO metadata.
     */
    public function withSeo(): static
    {
        return $this->afterCreating(function (Page $page))
            $page->seo()->create([)
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
        return $this->afterCreating(function (Page $page))
            $page->blocks()->create([)
                'type' => 'text',
                'content' => $faker->paragraph()
                'order' => 1,
            ]);
        });
    }
}
