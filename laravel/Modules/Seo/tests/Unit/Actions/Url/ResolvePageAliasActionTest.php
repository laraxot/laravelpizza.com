<?php

declare(strict_types=1);

use Modules\Seo\Actions\Url\ResolvePageAliasAction;

/**
 * Due slug per la stessa pagina (about/chi-siamo, faq/faqs, /home e la home): l'alias risponde 301 al canonico, in tutte le lingue.
 * Test puro: la mappa si passa a mano, non si legge la configurazione del sito.
 */
const PAGE_ALIASES = [
    'chi-siamo' => 'about',
    'contatti' => 'contacts',
    'home' => '',
    'blog/vecchio' => 'blog',
];

/**
 * @param array<array-key, mixed>|null $aliases
 */
function pageAliasTarget(string $path, ?array $aliases = null): ?string
{
    return app(ResolvePageAliasAction::class)->execute($path, ['it', 'en', 'de', 'es'], $aliases ?? PAGE_ALIASES);
}

it('sends an alias to the canonical page keeping the language', function (string $path, string $canonical): void {
    expect(pageAliasTarget($path))->toBe($canonical);
})->with([
    'italian' => ['/it/chi-siamo', '/it/about'],
    'english' => ['/en/chi-siamo', '/en/about'],
    'german' => ['/de/contatti', '/de/contacts'],
    'spanish' => ['/es/contatti', '/es/contacts'],
    'home alias goes to the language root' => ['/it/home', '/it'],
    'nested alias' => ['/en/blog/vecchio', '/en/blog'],
    'trailing slash' => ['/it/chi-siamo/', '/it/about'],
    'upper case language' => ['/DE/chi-siamo', '/de/about'],
]);

it('leaves everything that is not an alias alone', function (string $path): void {
    expect(pageAliasTarget($path))->toBeNull();
})->with([
    'canonical page' => ['/it/about'],
    'home' => ['/it'],
    'root' => ['/'],
    'a sub page of an alias is another page' => ['/it/chi-siamo/team'],
    'case of the slug is kept: it is another page' => ['/it/Chi-Siamo'],
    'not a language' => ['/chi-siamo'],
    'unknown language' => ['/fr/chi-siamo'],
    'asset' => ['/livewire/livewire.js'],
]);

it('does nothing without a map', function (): void {
    expect(pageAliasTarget('/it/chi-siamo', []))->toBeNull();
});

it('ignores entries that could loop or are not readable', function (array $aliases): void {
    expect(pageAliasTarget('/it/chi-siamo', $aliases))->toBeNull();
})->with([
    'alias of itself' => [['chi-siamo' => 'chi-siamo']],
    'target is an alias too (a chain is a configuration error, not followed)' => [['chi-siamo' => 'about', 'about' => 'team']],
    'target is not a string' => [['chi-siamo' => ['about']]],
    'empty alias' => [['' => 'about']],
]);

it('tells the sitemap which page paths are aliases', function (): void {
    $action = app(ResolvePageAliasAction::class);

    expect($action->isAlias('chi-siamo', PAGE_ALIASES))->toBeTrue()
        ->and($action->isAlias('/chi-siamo/', PAGE_ALIASES))->toBeTrue()
        ->and($action->isAlias('blog/vecchio', PAGE_ALIASES))->toBeTrue()
        ->and($action->isAlias('about', PAGE_ALIASES))->toBeFalse()
        ->and($action->isAlias('', PAGE_ALIASES))->toBeFalse();
});
