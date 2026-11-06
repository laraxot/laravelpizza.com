<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

use function Safe\simplexml_load_string;

uses(TestCase::class);

/*
 * sitemap.xml (front-office completeness audit, item 1): the `{container}.view` CMS pages are detail templates with no record
 * (`/it/blog/view` has no content), so they stay out; published posts and events come in through `SitemapPathsContract`.
 * Story: Modules/Seo/docs/stories/sitemap-detail-templates-and-articles.story.md.
 */
/** @return list<string> */
function seoSitemapLocs(TestCase $test): array
{
    $xml = simplexml_load_string((string) $test->get('/sitemap.xml')->assertOk()->getContent());
    $xml->registerXPathNamespace('s', 'http://www.sitemaps.org/schemas/sitemap/0.9');

    return array_values(array_map(static fn (SimpleXMLElement $loc): string => (string) $loc, $xml->xpath('//s:url/s:loc') ?: []));
}

/** Saves a published post or event and returns its slug. Blog is an optional consumer of Seo: without it there is nothing to publish. */
function seoSitemapArticle(string $contentType): string
{
    $article = class_exists('Modules\\Blog\\Models\\Article') ? app('Modules\\Blog\\Models\\Article') : null;
    if (! $article instanceof Model) {
        Assert::markTestSkipped('Modules\\Blog is not installed.');
    }

    $title = 'Sitemap '.$contentType.' '.Str::lower(Str::random(6));
    $article->forceFill([
        'uuid' => (string) Str::uuid(),
        'title' => $title,
        'slug' => Str::slug($title),
        'description' => $title,
        'content_blocks' => [['type' => 'paragraph', 'data' => ['text' => '<p>'.$title.'</p>']]],
        'sidebar_blocks' => [],
        'footer_blocks' => [],
        'type' => $contentType,
        'published_at' => Carbon::now()->subDay(),
        'event_start_date' => $contentType === 'event' ? Carbon::now()->addWeek() : null,
    ]);
    $article->save();

    return Str::slug($title);
}

it('leaves the detail templates out of the sitemap', function (): void {
    /** @var TestCase $this */
    $locs = seoSitemapLocs($this);

    expect($locs)->not->toBeEmpty();
    foreach ($locs as $loc) {
        expect($loc)->not->toMatch('#/(blog|events|services)/view$#');
    }
});

it('lists the published posts and events in every language', function (): void {
    /** @var TestCase $this */
    $post = seoSitemapArticle('post');
    $event = seoSitemapArticle('event');

    $locs = seoSitemapLocs($this);

    foreach (['it', 'en'] as $lang) {
        expect($locs)
            ->toContain(url('/'.$lang.'/blog/'.$post))
            ->toContain(url('/'.$lang.'/events/'.$event));
    }
});
