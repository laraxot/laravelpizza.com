<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Modules\Seo\Http\Middleware\RedirectToCanonicalPath;
use Modules\Seo\Tests\Support\FakeTenantSeoConfig;
use Modules\Seo\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

uses(TestCase::class);

// Il middleware legge le lingue da `laravellocalization.supportedLocales`, che cambia da progetto a progetto:
// il test fissa le sue, cosi' i casi `de`/`es` valgono ovunque.
beforeEach(function (): void {
    config(['laravellocalization.supportedLocales' => ['it' => [], 'en' => [], 'de' => [], 'es' => []]]);
});

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

it('redirects an alias with a 301 to the canonical page and keeps the query', function (): void {
    $cases = [
        ['/it/chi-siamo', '/it/about'],
        ['/de/chi-siamo', '/de/about'],
        ['/en/chi-siamo?utm=a&b=2', '/en/about?utm=a&b=2'],
        ['/es/home', '/es'],
        ['/IT/chi-siamo/', '/it/about'],
    ];
    foreach ($cases as [$from, $to]) {
        $response = passThroughPageAlias('GET', $from);
        Assert::assertSame(301, $response->getStatusCode());
        Assert::assertTrue(str_ends_with((string) $response->headers->get('Location'), $to));
    }
});

it('serves the canonical page, the other pages and non-localized paths as they are', function (): void {
    foreach (['/it/about', '/it', '/it/privacy', '/livewire/livewire.js', '/it/chi-siamo/team'] as $uri) {
        Assert::assertSame('pagina', passThroughPageAlias('GET', $uri)->getContent());
    }
});

it('does not redirect an alias for what is not a read', function (): void {
    foreach (['POST', 'PUT', 'DELETE'] as $method) {
        Assert::assertSame('pagina', passThroughPageAlias($method, '/it/chi-siamo')->getContent());
    }
});

it('redirects nothing when the site declares no aliases', function (): void {
    FakeTenantSeoConfig::bind(['path_aliases' => []]);

    $response = (new RedirectToCanonicalPath)->handle(Request::create('/it/chi-siamo', 'GET'), static fn (): Response => response('pagina'));

    Assert::assertSame('pagina', $response->getContent());
});
