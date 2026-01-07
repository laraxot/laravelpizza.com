<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Cms\Models\Page;

beforeEach(function (): void {
    $this->page = Page/* @phpstan-ignore-line */ ::factory()->create();
});

test('page can be created', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->page)->toBeInstanceOf(Page::class);
});

test('page has fillable attributes', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $fillable = $this->page->getFillable();

    expect($fillable)->toContain('title');
    expect($fillable)->toContain('slug');
    expect($fillable)->toContain('status');
    expect($fillable)->toContain('template');
});

test('page has casts defined', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $casts = $this->page->getCasts();

    expect($casts)->toHaveKey('created_at');
    expect($casts)->toHaveKey('updated_at');
    expect($casts)->toHaveKey('published_at');
    expect($casts)->toHaveKey('meta');
});

test('page has proper table name', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->page->getTable())->toBe('pages');
});

test('page has content relationship', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->page->content())->toBeInstanceOf(HasMany::class);
});

test('page can be published', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    $this->page->update(['status' => 'published', 'published_at' => now()]);

    /* @phpstan-ignore-next-line property.notFound */
    expect($this->page->fresh()->isPublished())->toBeTrue();
});

test('page can be draft', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    $this->page->update(['status' => 'draft']);

    /* @phpstan-ignore-next-line property.notFound */
    expect($this->page->fresh()->isDraft())->toBeTrue();
});

test('page can be searched by title', function (): void {
    $searchResult = Page::search('test')->get();

    expect($searchResult)->toHaveCount(1);
    /* @phpstan-ignore-next-line property.notFound */
    expect($searchResult->first()->id)->toBe($this->page->id);
});

test('page can be filtered by status', function (): void {
    /** @var Collection */
    $publishedPage = Page/* @phpstan-ignore-line */ ::factory()->create(['status' => 'published']);
    /** @var Collection */
    $draftPage = Page/* @phpstan-ignore-line */ ::factory()->create(['status' => 'draft']);

    $publishedPages = Page::published()->get();
    $draftPages = Page::draft()->get();

    expect($publishedPages)->toHaveCount(1);
    expect($publishedPages->first()->id)->toBe($publishedPage->id);

    expect($draftPages)->toHaveCount(1);
    expect($draftPages->first()->id)->toBe($draftPage->id);
});

test('page can be filtered by template', function (): void {
    /** @var Collection */
    $templatePage = Page/* @phpstan-ignore-line */ ::factory()->create(['template' => 'default']);

    $templatePages = Page::byTemplate('default')->get();

    expect($templatePages)->toHaveCount(1);
    expect($templatePages->first()->id)->toBe($templatePage->id);
});

test('page has proper relationships', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->page->content())->toBeInstanceOf(HasMany::class);
});

test('page can get url', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    $this->page->update(['slug' => 'test-page']);

    /** @phpstan-ignore-next-line property.notFound */
    $url = $this->page->getUrlAttribute();

    expect($url)->toBe('/test-page');
});

test('page can check if is public', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    $this->page->update(['status' => 'published', 'published_at' => now()]);

    /* @phpstan-ignore-next-line property.notFound */
    expect($this->page->fresh()->isPublic())->toBeTrue();

    /* @phpstan-ignore-next-line property.notFound */
    $this->page->update(['status' => 'draft']);

    /* @phpstan-ignore-next-line property.notFound */
    expect($this->page->fresh()->isPublic())->toBeFalse();
});
