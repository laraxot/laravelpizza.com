<?php

declare(strict_types=1);

use Modules\User\Database\Seeders\RolesSeeder;
use Modules\User\Database\Seeders\UserMassSeeder;
use Modules\User\Tests\TestCase;

uses(TestCase::class)->group('no-user-db');

/*
 * DCP-377: `Seeder::$command` e' null fuori da `db:seed` (test, chiamate dal codice). I metodi di output dei seeder devono
 * tacere in quel caso, senza errori. PHPStan lo vede perche' `getConsoleCommand()` e' `?Command`; qui lo fissa il comportamento.
 */
test('the roles seeder does not fail when no console is attached', function (): void {
    $seeder = new RolesSeeder;
    $displayResults = new ReflectionMethod($seeder, 'displayResults');

    expect(fn () => $displayResults->invoke($seeder, []))->not->toThrow(Throwable::class);
});

test('the user mass seeder stays silent when no console is attached', function (string $method): void {
    $seeder = new UserMassSeeder;
    $output = new ReflectionMethod($seeder, $method);

    expect(fn () => $output->invoke($seeder, 'messaggio'))->not->toThrow(Throwable::class);
})->with(['info', 'error']);
