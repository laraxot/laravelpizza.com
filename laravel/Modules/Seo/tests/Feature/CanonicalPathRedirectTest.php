<?php

declare(strict_types=1);

use Modules\Seo\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Pest\Laravel\get;

uses(TestCase::class);

/**
 * DCP-288 (FO-6-20): le copie della stessa pagina (lingua maiuscola, doppio slash, slash finale) rispondevano 200 e restavano indicizzabili.
 * Lo slash finale qui non si prova: il client di test lo toglie dall'indirizzo prima di inviare la richiesta (vedi RedirectToCanonicalPathTest).
 */
it('redirects the duplicates with a 301 to the canonical path and keeps the query', function (): void {
    $cases = [
        ['/IT/tickets', '/it/tickets'],
        ['/It/tickets?q=buca&page=2', '/it/tickets?q=buca&page=2'],
        ['/IT', '/it'],
        ['/it//tickets', '/it/tickets'],
        ['/IT/tests', '/it/tests'],
    ];
    foreach ($cases as [$from, $to]) {
        get($from)->assertStatus(301)->assertRedirect($to);
    }
});

it('serves the canonical paths and everything that is not a localized page as they are', function (): void {
    // Pagine che esistono in ogni installazione (home, login): `tickets` esiste solo nei progetti che hanno quel modulo.
    foreach (['/it', '/en', '/it/auth/login', '/up'] as $path) {
        get($path)->assertOk();
    }
});
