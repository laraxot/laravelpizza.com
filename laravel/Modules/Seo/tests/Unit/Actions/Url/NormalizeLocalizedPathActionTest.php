<?php

declare(strict_types=1);

use Modules\Seo\Actions\Url\NormalizeLocalizedPathAction;

/**
 * DCP-288 (FO-6-20): /IT, /It/tickets, /it//tickets e /it/tickets/ rispondevano 200 come la forma canonica.
 */
function normalizedPath(string $path): ?string
{
    return app(NormalizeLocalizedPathAction::class)->execute($path, ['it', 'en', 'de', 'es']);
}

it('returns the canonical path for the duplicates of a localized page', function (string $path, string $canonical): void {
    expect(normalizedPath($path))->toBe($canonical);
})->with([
    'upper case language' => ['/IT/tickets', '/it/tickets'],
    'mixed case language' => ['/It/tickets', '/it/tickets'],
    'upper case home' => ['/IT', '/it'],
    'home with slash' => ['/it/', '/it'],
    'double slash' => ['/it//tickets', '/it/tickets'],
    'many slashes' => ['/it///tickets//12', '/it/tickets/12'],
    'trailing slash' => ['/it/tickets/', '/it/tickets'],
    'all of it' => ['/DE//Tickets//', '/de/Tickets'],
]);

it('returns null when the path is already canonical or is not a localized page', function (string $path): void {
    expect(normalizedPath($path))->toBeNull();
})->with([
    'home' => ['/it'],
    'list' => ['/en/tickets'],
    'case of the rest is kept (it is a different page)' => ['/it/Blog'],
    'root' => ['/'],
    'not a language' => ['/livewire/livewire.js'],
    'not a language with a slash' => ['/storage/'],
    'unknown two-letter segment' => ['/fr/tickets/'],
]);
