<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Modules\Seo\Http\Middleware\RedirectToCanonicalPath;
use Modules\Seo\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

uses(TestCase::class);

/**
 * DCP-288 (FO-6-20): la richiesta si costruisce a mano perche' il client di test toglie lo slash finale dall'indirizzo.
 */
function passThroughCanonicalPath(string $method, string $uri): Response
{
    return (new RedirectToCanonicalPath)->handle(Request::create($uri, $method), static fn (): Response => response('pagina'));
}

it('redirects with a 301 and keeps the query exactly as it came', function (): void {
    $cases = [
        ['/it/tickets/', '/it/tickets'],
        ['/de/', '/de'],
        ['/It/tickets/?q=buca&page=2', '/it/tickets?q=buca&page=2'],
        ['/IT//tickets?q=via%20Roma&a[]=1', '/it/tickets?q=via%20Roma&a[]=1'],
    ];
    foreach ($cases as [$from, $to]) {
        $response = passThroughCanonicalPath('GET', $from);
        Assert::assertSame(301, $response->getStatusCode());
        Assert::assertTrue(str_ends_with((string) $response->headers->get('Location'), $to));
    }
});

it('lets canonical requests through', function (): void {
    foreach (['/it', '/it/tickets?page=2', '/livewire/livewire.js', '/storage/'] as $uri) {
        Assert::assertSame('pagina', passThroughCanonicalPath('GET', $uri)->getContent());
    }
});

it('does not redirect what is not a read', function (): void {
    foreach (['POST', 'PUT', 'PATCH', 'DELETE'] as $method) {
        Assert::assertSame('pagina', passThroughCanonicalPath($method, '/IT/tickets/')->getContent());
    }
});

it('also redirects HEAD requests', function (): void {
    Assert::assertSame(301, passThroughCanonicalPath('HEAD', '/IT/tickets')->getStatusCode());
});
