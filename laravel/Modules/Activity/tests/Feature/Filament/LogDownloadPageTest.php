<?php

declare(strict_types=1);
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\File;
use Mockery\MockInterface;
use Modules\Xot\Contracts\UserContract;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

uses(TestCase::class);

/*
 * Prova la pagina Folio del download (resources/views/pages/api/log-download.blade.php) attraverso lo stack HTTP
 * completo: routing di Folio su /api, middleware `web`, autorizzazione, risposta.
 *
 * Nessun database: gli utenti sono mock. storage_path() e' puntato a una cartella temporanea con useStoragePath()
 * e ripristinato in afterEach, cosi' non si tocca mai il vero storage/logs.
 *
 * Le risposte 403/404 si verificano dal codice di stato dell'eccezione (withoutExceptionHandling): con il gestore
 * normale l'app renderizzerebbe la sua pagina d'errore a tema, che per un utente autenticato legge/crea un Profile
 * nel database, cosa che questi test non devono fare.
 */
beforeEach(function (): void {
    $this->originalStorage = storage_path();
    $this->tempStorage = $this->originalStorage.'/framework/testing/log-download-page-'.uniqid('', true);
    File::makeDirectory($this->tempStorage.'/logs/reports/252', 0777, true);
    app()->useStoragePath($this->tempStorage);

    File::put($this->tempStorage.'/logs/laravel.log', "[2026-09-20 10:00:00] local.INFO: ok\n");
    File::put($this->tempStorage.'/logs/reports/252/daily.log', "contenuto del report\n");
    File::put($this->originalStorage.'/framework/testing/segreto-pagina.log', 'segreto');

    $this->statusOf = function (string $url): int {
        try {
            return $this->withoutExceptionHandling()->get($url)->getStatusCode();
        } catch (HttpException $exception) {
            return $exception->getStatusCode();
        }
    };

    $this->user = function (bool $isSuperAdmin, bool $hasPermission = false): UserContract&Authenticatable {
        /** @var MockInterface&UserContract&Authenticatable $user */
        $user = Mockery::mock(UserContract::class, Authenticatable::class);
        $user->shouldReceive('hasRole')->with('super-admin')->andReturn($isSuperAdmin);
        $user->shouldReceive('hasPermissionTo')->with('log.viewAny')->andReturn($hasPermission);

        return $user;
    };
});

afterEach(function (): void {
    app()->useStoragePath($this->originalStorage);
    File::deleteDirectory($this->tempStorage);
    File::delete($this->originalStorage.'/framework/testing/segreto-pagina.log');
    Mockery::close();
});

it('answers 403 to a guest and never serves the file', function (): void {
    expect(($this->statusOf)('/api/log-download?file=laravel.log'))->toBe(403);
});

it('answers 403 to a logged in user without role and without permission', function (): void {
    $this->actingAs(($this->user)(false, false));

    expect(($this->statusOf)('/api/log-download?file=laravel.log'))->toBe(403);
});

it('streams the requested file to a super-admin', function (): void {
    $response = $this->actingAs(($this->user)(true))->get('/api/log-download?file=reports/252/daily.log');

    $response->assertOk();
    $binaryResponse = $response->baseResponse;
    expect($binaryResponse)->toBeInstanceOf(BinaryFileResponse::class);

    if (! $binaryResponse instanceof BinaryFileResponse) {
        $this->fail('La risposta non e\' un BinaryFileResponse.');
    }

    expect($response->headers->get('Content-Disposition'))->toContain('reports_252_daily.log');
    expect(File::get($binaryResponse->getFile()->getPathname()))->toBe("contenuto del report\n");
});

it('streams the requested file to a user with the log.viewAny permission', function (): void {
    $this->actingAs(($this->user)(false, true))
        ->get('/api/log-download?file=laravel.log')
        ->assertOk();
});

it('answers 404 to a file outside the log directory, missing, or a request without a file', function (): void {
    $this->actingAs(($this->user)(true));

    foreach ([
        '/api/log-download?file='.urlencode('../framework/testing/segreto-pagina.log'),
        '/api/log-download?file=non-esiste.log',
        '/api/log-download?file='.urlencode('laravel.log/../../.env'),
        '/api/log-download?file=',
        '/api/log-download',
    ] as $url) {
        expect(($this->statusOf)($url))->toBe(404);
    }
});
