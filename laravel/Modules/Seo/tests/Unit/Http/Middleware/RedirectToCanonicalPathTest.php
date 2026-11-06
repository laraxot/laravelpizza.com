<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Modules\Seo\Http\Middleware\RedirectToCanonicalPath;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

uses(TestCase::class);

/**
 * DCP-288 (FO-6-20): la richiesta si costruisce a mano perche' il client di test toglie lo slash finale dall'indirizzo.
 */
function passThroughCanonicalPath(string $method, string $uri): Response
{
    return (new RedirectToCanonicalPath)->handle(Request::create($uri, $method), static fn (): Response => response('pagina'));
}

it('redirects with a 301 and keeps the query exactly as it came', function (string $from, string $to): void {
    $response = passThroughCanonicalPath('GET', $from);

    expect($response->getStatusCode())->toBe(301);
    Assert::assertTrue(str_ends_with((string) $response->headers->get('Location'), $to));
})->with([
    'trailing slash' => ['/it/tickets/', '/it/tickets'],
    'trailing slash on the home' => ['/de/', '/de'],
    'query in the original order' => ['/It/tickets/?q=buca&page=2', '/it/tickets?q=buca&page=2'],
    'encoded query' => ['/IT//tickets?q=via%20Roma&a[]=1', '/it/tickets?q=via%20Roma&a[]=1'],
]);

it('lets canonical requests through', function (string $uri): void {
    expect(passThroughCanonicalPath('GET', $uri)->getContent())->toBe('pagina');
})->with(['/it', '/it/tickets?page=2', '/livewire/livewire.js', '/storage/']);

it('does not redirect what is not a read', function (string $method): void {
    expect(passThroughCanonicalPath($method, '/IT/tickets/')->getContent())->toBe('pagina');
})->with(['POST', 'PUT', 'PATCH', 'DELETE']);

it('also redirects HEAD requests', function (): void {
    expect(passThroughCanonicalPath('HEAD', '/IT/tickets')->getStatusCode())->toBe(301);
});
