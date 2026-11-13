<?php

declare(strict_types=1);

use Modules\Xot\Tests\Support\TestDatabaseGuard;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('accepts a testing environment with _test databases, sqlite and the documented exceptions', function (): void {
    $assert = static fn () => TestDatabaseGuard::assert('testing', [
        'mariadb' => ['driver' => 'mariadb', 'database' => 'fixcity_data_test'],
        'sqlite' => ['driver' => 'sqlite', 'database' => ':memory:'],
        'liveuser_general' => ['driver' => 'mariadb', 'database' => 'forge13'],
    ]);

    expect($assert)->not->toThrow(RuntimeException::class);
});

it('refuses an environment that is not testing', function (): void {
    $assert = static fn () => TestDatabaseGuard::assert('local', []);

    expect($assert)->toThrow(RuntimeException::class);
});

it('refuses a connection whose database does not end with _test', function (): void {
    $assert = static fn () => TestDatabaseGuard::assert('testing', [
        'mariadb' => ['driver' => 'mariadb', 'database' => 'quaeris_data'],
    ]);

    expect($assert)->toThrow(RuntimeException::class);
});

it('reads driver and database from the connection url, like the runtime does', function (): void {
    $assert = static fn () => TestDatabaseGuard::assert('testing', [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'url' => 'mysql://user:secret@localhost/quaeris_data',
        ],
    ]);

    expect($assert)->toThrow(RuntimeException::class);
});

// I due casi qui sotto arrivano da laravel/tests/Architecture/TestDatabaseGuardTest.php,
// accorpato qui il 2026-11-11 quando la cartella tests/ della radice e' stata
// sciolta: ogni modulo ha la propria. Coprivano due cose che questo file non
// verificava — che il messaggio d'errore non stampi la password quando la
// connessione arriva da un DB_URL, e che i database usa-e-getta di
// pest-scratch-db.sh siano accettati.

it('lets a DB_URL override the connection and never prints its password', function (): void {
    $message = '';

    try {
        TestDatabaseGuard::assert('testing', [
            'sqlite' => ['driver' => 'sqlite', 'database' => ':memory:', 'url' => 'mysql://marco:segreto@127.0.0.1/quaeris_data'],
        ]);
    } catch (RuntimeException $exception) {
        $message = $exception->getMessage();
    }

    expect($message)->toContain('"sqlite" (mysql) -> database "quaeris_data"')
        ->and($message)->not->toContain('segreto');
});

it('accepts the throwaway databases of pest-scratch-db.sh and ignores the legacy liveuser_general connection', function (): void {
    expect(fn () => TestDatabaseGuard::assert('testing', [
        'mysql' => ['driver' => 'mysql', 'database' => 'claude_scratch_pest_1760000000_123'],
        'liveuser_general' => ['driver' => 'mysql', 'database' => 'forge13'],
    ]))->not->toThrow(RuntimeException::class);
});
