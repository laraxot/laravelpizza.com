<?php

declare(strict_types=1);

use Modules\Seo\Actions\Url\ResolvePathAliasAction;
use Modules\Seo\Datas\SeoConfigData;
use Modules\Seo\Tests\TestCase;

uses(TestCase::class);

/**
 * Alias di pagina (faqs/faq, cookie/cookies, contatti/contacts, about/chi-siamo, home): 301 nella stessa lingua alla pagina canonica.
 * Nessun database: l'app serve solo a `SeoConfigData` (Spatie Data).
 */
function aliasTarget(string $path): ?string
{
    return (new ResolvePathAliasAction)->execute($path, ['it', 'en'], ['faqs' => 'faq', 'home' => '', 'services/old' => 'services/radioprotezione']);
}

it('sends an alias to the canonical page in the same language', function (string $path, string $canonical): void {
    expect(aliasTarget($path))->toBe($canonical);
})->with([
    'it' => ['/it/faqs', '/it/faq'],
    'en' => ['/en/faqs', '/en/faq'],
    'home alias goes to the language root' => ['/it/home', '/it'],
    'nested alias' => ['/en/services/old', '/en/services/radioprotezione'],
]);

it('leaves everything else alone', function (string $path): void {
    expect(aliasTarget($path))->toBeNull();
})->with([
    'canonical page' => ['/it/faq'],
    'language root' => ['/it'],
    'root' => ['/'],
    'language that is not active' => ['/de/faqs'],
    'not a language' => ['/livewire/faqs'],
    'case of the rest is kept (it is a different page)' => ['/it/FAQS'],
    'alias as the child of another page' => ['/it/blog/faqs'],
]);

it('declares aliases that end on a final page, never on another alias', function (): void {
    $data = SeoConfigData::from([]);
    $aliases = $data->pathAliases();

    expect($aliases)->not->toBeEmpty()
        ->and($data->hasRejectedAliases())->toBeFalse();
    foreach ($aliases as $alias => $target) {
        expect(array_key_exists($target, $aliases))->toBeFalse("{$alias} -> {$target} is a chain");
    }
});

it('keeps the JSON of every alias and of every canonical page', function (): void {
    $pages = dirname(__DIR__, 5).'/TechPlanner/config/database/content/pages/';

    foreach (SeoConfigData::from([])->pathAliases() as $alias => $target) {
        expect(is_file($pages.$alias.'.json'))->toBeTrue("{$alias}.json is missing: aliases are never deleted");
        $canonical = $target === '' ? 'home' : $target;
        expect(is_file($pages.$canonical.'.json'))->toBeTrue("{$canonical}.json is missing: the canonical page must exist");
    }
});
