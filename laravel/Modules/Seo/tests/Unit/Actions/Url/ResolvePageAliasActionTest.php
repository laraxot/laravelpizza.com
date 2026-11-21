<?php

declare(strict_types=1);

use Modules\Seo\Actions\Url\ResolvePageAliasAction;
use PHPUnit\Framework\Assert;

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
 * @param  array<array-key, mixed>|null  $aliases
 */
function pageAliasTarget(string $path, ?array $aliases = null): ?string
{
    return app(ResolvePageAliasAction::class)->execute($path, ['it', 'en', 'de', 'es'], $aliases ?? PAGE_ALIASES);
}

it('sends an alias to the canonical page keeping the language', function (): void {
    $cases = [
        ['/it/chi-siamo', '/it/about'],
        ['/en/chi-siamo', '/en/about'],
        ['/de/contatti', '/de/contacts'],
        ['/es/contatti', '/es/contacts'],
        ['/it/home', '/it'],
        ['/en/blog/vecchio', '/en/blog'],
        ['/it/chi-siamo/', '/it/about'],
        ['/DE/chi-siamo', '/de/about'],
    ];
    foreach ($cases as [$path, $canonical]) {
        Assert::assertSame($canonical, pageAliasTarget($path));
    }
});

it('leaves everything that is not an alias alone', function (): void {
    foreach (['/it/about', '/it', '/', '/it/chi-siamo/team', '/it/Chi-Siamo', '/chi-siamo', '/fr/chi-siamo', '/livewire/livewire.js'] as $path) {
        Assert::assertNull(pageAliasTarget($path));
    }
});

it('does nothing without a map', function (): void {
    Assert::assertNull(pageAliasTarget('/it/chi-siamo', []));
});

it('ignores entries that could loop or are not readable', function (): void {
    $cases = [
        [['chi-siamo' => 'chi-siamo']],
        [['chi-siamo' => 'about', 'about' => 'team']],
        [['chi-siamo' => ['about']]],
        [['' => 'about']],
    ];
    foreach ($cases as [$aliases]) {
        Assert::assertNull(pageAliasTarget('/it/chi-siamo', $aliases));
    }
});

it('tells the sitemap which page paths are aliases', function (): void {
    $action = app(ResolvePageAliasAction::class);

    Assert::assertTrue($action->isAlias('chi-siamo', PAGE_ALIASES));
    Assert::assertTrue($action->isAlias('/chi-siamo/', PAGE_ALIASES));
    Assert::assertTrue($action->isAlias('blog/vecchio', PAGE_ALIASES));
    Assert::assertFalse($action->isAlias('about', PAGE_ALIASES));
    Assert::assertFalse($action->isAlias('', PAGE_ALIASES));
});
