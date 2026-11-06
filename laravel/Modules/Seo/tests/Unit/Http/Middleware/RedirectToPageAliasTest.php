<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Modules\Seo\Http\Middleware\RedirectToCanonicalPath;
use Modules\Seo\Tests\Support\FakeTenantSeoConfig;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

uses(TestCase::class);

/**
 * Un alias di pagina (`chi-siamo` per `about`) risponde 301 al canonico nella stessa lingua, in un solo salto anche quando
 * la richiesta ha pure una copia di forma (lingua maiuscola, slash finale). La mappa si imposta nel test: in produzione
 * viene dalle impostazioni di Seo (`SeoConfigData`, file `seo` del tenant).
 */
function passThroughPageAlias(string $method, string $uri): Response
{
    FakeTenantSeoConfig::bind([
        'path_aliases' => [
            [
                'alias' => 'chi-siamo',
                'target' => 'about',
            ],
            [
                'alias' => 'home',
                'target' => '',
            ],
        ],
    ]);

    return (new RedirectToCanonicalPath)->handle(Request::create($uri, $method), static fn (): Response => response('pagina'));
}

it('redirects an alias with a 301 to the canonical page and keeps the query', function (string $from, string $to): void {
    $response = passThroughPageAlias('GET', $from);

    expect($response->getStatusCode())->toBe(301);
    Assert::assertTrue(str_ends_with((string) $response->headers->get('Location'), $to));
})->with([
    'italian' => ['/it/chi-siamo', '/it/about'],
    'german' => ['/de/chi-siamo', '/de/about'],
    'query kept' => ['/en/chi-siamo?utm=a&b=2', '/en/about?utm=a&b=2'],
    'home alias' => ['/es/home', '/es'],
    'one hop for a shape copy of an alias' => ['/IT/chi-siamo/', '/it/about'],
]);

it('serves the canonical page, the other pages and non-localized paths as they are', function (string $uri): void {
    expect(passThroughPageAlias('GET', $uri)->getContent())->toBe('pagina');
})->with(['/it/about', '/it', '/it/privacy', '/livewire/livewire.js', '/it/chi-siamo/team']);

it('does not redirect an alias for what is not a read', function (string $method): void {
    expect(passThroughPageAlias($method, '/it/chi-siamo')->getContent())->toBe('pagina');
})->with(['POST', 'PUT', 'DELETE']);

it('redirects nothing when the site declares no aliases', function (): void {
    FakeTenantSeoConfig::bind(['path_aliases' => []]);

    $response = (new RedirectToCanonicalPath)->handle(Request::create('/it/chi-siamo', 'GET'), static fn (): Response => response('pagina'));

    expect($response->getContent())->toBe('pagina');
});
