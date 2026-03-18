<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit;

use Modules\Cms\Models\Page;
use Modules\Cms\Models\Post;

it('can create a cms page', function () {
    $page = Page::factory()->create([
        'title' => 'Home Page',
        'slug' => 'home',
        'content' => 'Welcome to our website',
    ]);

    expect($page)->toBeInstanceOf(Page::class);
    expect($page->title)->toBe('Home Page');
    expect($page->slug)->toBe('home');
    expect($page->content)->toBe('Welcome to our website');
});

it('can create a cms page with seo metadata', function () {
    $page = Page::factory()->withSeo()->create([
        'title' => 'SEO Page',
        'slug' => 'seo',
    ]);

    expect($page->seo)->toBeInstanceOf(\Modules\Cms\Models\Seo::class);
    expect($page->seo->meta_title)->toBe('SEO Page');
});

it('can create a cms page with menu', function () {
    $page = Page::factory()->create([
        'title' => 'Menu Page',
        'slug' => 'menu',
    ]);

    $menu = $page->menus()->create([
        'name' => 'Main Menu',
        'slug' => 'main-menu',
    ]);

    expect($menu)->toBeInstanceOf(\Modules\Cms\Models\Menu::class);
    expect($menu->name)->toBe('Main Menu');
});

it('can create a cms page with blocks', function () {
    $page = Page::factory()->create([
        'title' => 'Blocks Page',
        'slug' => 'blocks',
    ]);

    $block = $page->blocks()->create([
        'type' => 'text',
        'content' => 'Block content',
        'order' => 1,
    ]);

    expect($block)->toBeInstanceOf(\Modules\Cms\Models\Block::class);
    expect($block->type)->toBe('text');
    expect($block->order)->toBe(1);
});

it('can create a cms post', function () {
    $post = Post::factory()->create([
        'title' => 'Test Post',
        'slug' => 'test-post',
        'excerpt' => 'This is a test post',
    ]);

    expect($post)->toBeInstanceOf(Post::class);
    expect($post->title)->toBe('Test Post');
    expect($post->slug)->toBe('test-post');
});

it('can create a cms post with featured image', function () {
    $post = Post::factory()->withFeaturedImage()->create([
        'title' => 'Featured Post',
        'slug' => 'featured',
    ]);

    expect($post->featuredImage)->toBeInstanceOf(\Modules\Cms\Models\Media::class);
});

it('can create a cms post category', function () {
    $post = Post::factory()->create([
        'title' => 'Category Post',
        'slug' => 'category',
    ]);

    $category = $post->categories()->create([
        'name' => 'Technology',
        'slug' => 'technology',
    ]);

    expect($category)->toBeInstanceOf(\Modules\Cms\Models\Category::class);
    expect($category->name)->toBe('Technology');
});

it('can create a cms post tag', function () {
    $post = Post::factory()->create([
        'title' => 'Tag Post',
        'slug' => 'tag',
    ]);

    $tag = $post->tags()->create([
        'name' => 'laravel',
        'slug' => 'laravel',
    ]);

    expect($tag)->toBeInstanceOf(\Modules\Cms\Models\Tag::class);
    expect($tag->name)->toBe('laravel');
});

it('can create a cms page with custom fields', function () {
    $page = Page::factory()->create([
        'title' => 'Custom Fields Page',
        'slug' => 'custom-fields',
    ]);

    $customField = $page->customFields()->create([
        'key' => 'background_color',
        'value' => '#ffffff',
    ]);

    expect($customField)->toBeInstanceOf(\Modules\Cms\Models\CustomField::class);
    expect($customField->key)->toBe('background_color');
    expect($customField->value)->toBe('#ffffff');
});

it('can create a cms page with translations', function () {
    $page = Page::factory()->create([
        'title' => 'Translated Page',
        'slug' => 'translated',
    ]);

    $translation = $page->translations()->create([
        'locale' => 'en',
        'title' => 'Translated Page',
        'slug' => 'translated-en',
    ]);

    expect($translation)->toBeInstanceOf(\Modules\Cms\Models\PageTranslation::class);
    expect($translation->locale)->toBe('en');
});
