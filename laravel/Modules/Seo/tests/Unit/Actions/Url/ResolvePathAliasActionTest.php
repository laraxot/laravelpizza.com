<?php

declare(strict_types=1);

use Modules\Seo\Actions\Url\ResolvePathAliasAction;
use Modules\Seo\Datas\SeoConfigData;
use Modules\Seo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * Alias di pagina (faqs/faq, cookie/cookies, contatti/contacts, about/chi-siamo, home): 301 nella stessa lingua alla pagina canonica.
 * Nessun database: l'app serve solo a `SeoConfigData` (Spatie Data).
 */
function aliasTarget(string $path): ?string
{
    return (new ResolvePathAliasAction)->execute($path, ['it', 'en'], ['faqs' => 'faq', 'home' => '', 'services/old' => 'services/radioprotezione']);
}

it('sends an alias to the canonical page in the same language', function (): void {
    $cases = [
        ['/it/faqs', '/it/faq'],
        ['/en/faqs', '/en/faq'],
        ['/it/home', '/it'],
        ['/en/services/old', '/en/services/radioprotezione'],
    ];
    foreach ($cases as [$path, $canonical]) {
        Assert::assertSame($canonical, aliasTarget($path));
    }
});

it('leaves everything else alone', function (): void {
    foreach (['/it/faq', '/it', '/', '/de/faqs', '/livewire/faqs', '/it/FAQS', '/it/blog/faqs'] as $path) {
        Assert::assertNull(aliasTarget($path));
    }
});

it('declares aliases that end on a final page, never on another alias', function (): void {
    $data = SeoConfigData::from([]);
    $aliases = $data->pathAliases();

    Assert::assertNotEmpty($aliases);
    Assert::assertFalse($data->hasRejectedAliases());
    foreach ($aliases as $alias => $target) {
        Assert::assertFalse(array_key_exists($target, $aliases), "{$alias} -> {$target} is a chain");
    }
});

it('keeps the JSON of every alias and of every canonical page', function (): void {
    $pages = dirname(__DIR__, 5).'/TechPlanner/config/database/content/pages/';

    foreach (SeoConfigData::from([])->pathAliases() as $alias => $target) {
        Assert::assertFileExists($pages.$alias.'.json', "{$alias}.json is missing: aliases are never deleted");
        $canonical = $target === '' ? 'home' : $target;
        Assert::assertFileExists($pages.$canonical.'.json', "{$canonical}.json is missing: the canonical page must exist");
    }
});
