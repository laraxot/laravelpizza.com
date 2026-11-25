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
        'mariadb' => ['driver' => 'mariadb', 'database' => '<nome progetto>_data'],
    ]);

    expect($assert)->toThrow(RuntimeException::class);
});

it('reads driver and database from the connection url, like the runtime does', function (): void {
    $assert = static fn () => TestDatabaseGuard::assert('testing', [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'url' => 'mysql://user:secret@localhost/<nome progetto>_data',
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
            'sqlite' => ['driver' => 'sqlite', 'database' => ':memory:', 'url' => 'mysql://marco:segreto@127.0.0.1/<nome progetto>_data'],
        ]);
    } catch (RuntimeException $exception) {
        $message = $exception->getMessage();
    }

    expect($message)->toContain('"sqlite" (mysql) -> database "<nome progetto>_data"')
        ->and($message)->not->toContain('segreto');
});

it('accepts the throwaway databases of pest-scratch-db.sh and ignores the legacy liveuser_general connection', function (): void {
    expect(fn () => TestDatabaseGuard::assert('testing', [
        'mysql' => ['driver' => 'mysql', 'database' => 'claude_scratch_pest_1760000000_123'],
        'liveuser_general' => ['driver' => 'mysql', 'database' => 'forge13'],
    ]))->not->toThrow(RuntimeException::class);
});

// Difese a strati (Modules/Xot/docs/testing/difese-database-nei-test.md): anche con il nome giusto,
// un host remoto ferma i test. Un .env.testing copiato da staging non deve poter fare DROP laggiu'.

it('refuses a _test database on a remote host', function (): void {
    expect(fn () => TestDatabaseGuard::assert('testing', [
        'mariadb' => ['driver' => 'mariadb', 'database' => 'restaurant_test', 'host' => 'db.staging.example.com'],
    ]))->toThrow(RuntimeException::class, 'is not local');
});

it('reads the host from the connection url too', function (): void {
    expect(fn () => TestDatabaseGuard::assert('testing', [
        'mysql' => ['driver' => 'mysql', 'database' => 'x_test', 'host' => '127.0.0.1', 'url' => 'mysql://u:p@10.0.0.5/restaurant_test'],
    ]))->toThrow(RuntimeException::class, 'host "10.0.0.5"');
});

it('accepts local hosts, docker service names and the hosts listed in TEST_DB_ALLOWED_HOSTS', function (): void {
    expect(fn () => TestDatabaseGuard::assert('testing', [
        'a' => ['driver' => 'mariadb', 'database' => 'a_test', 'host' => '127.0.0.1'],
        'b' => ['driver' => 'mariadb', 'database' => 'b_test', 'host' => 'localhost'],
        'c' => ['driver' => 'mysql', 'database' => 'c_test', 'host' => 'mysql'],
        'd' => ['driver' => 'pgsql', 'database' => 'd_test', 'host' => 'ci-db.internal'],
    ], ['ci-db.internal']))->not->toThrow(RuntimeException::class);
});
