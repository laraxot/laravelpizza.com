<?php

declare(strict_types=1);

use Tests\TestCase;

use function Pest\Laravel\get;

uses(TestCase::class);

/**
 * DCP-288 (FO-6-20): le copie della stessa pagina (lingua maiuscola, doppio slash, slash finale) rispondevano 200 e restavano indicizzabili.
 * Lo slash finale qui non si prova: il client di test lo toglie dall'indirizzo prima di inviare la richiesta (vedi RedirectToCanonicalPathTest).
 */
it('redirects the duplicates with a 301 to the canonical path and keeps the query', function (string $from, string $to): void {
    get($from)->assertStatus(301)->assertRedirect($to);
})->with([
    'upper case language' => ['/IT/tickets', '/it/tickets'],
    'mixed case with query' => ['/It/tickets?q=buca&page=2', '/it/tickets?q=buca&page=2'],
    'home' => ['/IT', '/it'],
    'double slash' => ['/it//tickets', '/it/tickets'],
    'parity pages' => ['/IT/tests', '/it/tests'],
]);

it('serves the canonical paths and everything that is not a localized page as they are', function (string $path): void {
    get($path)->assertOk();
})->with(['/it', '/it/tickets', '/en/tickets', '/up']);
