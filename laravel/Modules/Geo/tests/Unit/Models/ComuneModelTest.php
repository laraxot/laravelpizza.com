<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Modules\Geo\Models\Comune;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

/*
 * Comune e' un modello Sushi letto da `geo.comuni_json_path` (default: resources/json/comuni.json del modulo).
 * Ogni test punta il modello a un fixture temporaneo, cosi' create/update/delete non riscrivono il JSON versionato.
 * regione/provincia/cap sono cast `array` (formato {codice, nome}, lo stesso usato da Address::getRegione()).
 */

/**
 * @return list<array<string, mixed>>
 */
function comuneModelFixtures(): array
{
    $now = now()->toIso8601String();

    return [
        [
            'id' => 1,
            'regione' => ['codice' => '03', 'nome' => 'Lombardia'],
            'provincia' => ['codice' => 'MI', 'nome' => 'Milano'],
            'nome' => 'Milano',
            'cap' => ['20100'],
            'lat' => 45.4642,
            'lng' => 9.1900,
            'created_at' => $now,
            'updated_at' => $now,
        ],
        [
            'id' => 2,
            'regione' => ['codice' => '03', 'nome' => 'Lombardia'],
            'provincia' => ['codice' => 'MI', 'nome' => 'Milano'],
            'nome' => 'Sesto San Giovanni',
            'cap' => ['20099'],
            'lat' => 45.5347,
            'lng' => 9.2345,
            'created_at' => $now,
            'updated_at' => $now,
        ],
    ];
}

<<<<<<< .merge_file_gWA8f5
=======
<<<<<<< .merge_file_RPJx5y
uses(TestCase::class);
=======
>>>>>>> .merge_file_tfa93k
function comuneModelFixturePath(): string
{
    return storage_path('framework/testing/geo/comuni-model-test.json');
}

uses(\Modules\Geo\Tests\TestCase::class);
>>>>>>> .merge_file_qCJ9yn

beforeEach(function (): void {
    File::ensureDirectoryExists(\dirname(comuneModelFixturePath()));
    File::put(comuneModelFixturePath(), json_encode(comuneModelFixtures(), JSON_PRETTY_PRINT));
    config(['geo.comuni_json_path' => comuneModelFixturePath()]);
    // Sushi crea la tabella in-memory al boot del modello: forza un nuovo boot sul fixture.
    Model::clearBootedModels();
});

afterEach(function (): void {
    File::delete(comuneModelFixturePath());
    config(['geo.comuni_json_path' => null]);
    Model::clearBootedModels();
});

describe('Comune model JSON filters', function (): void {
    test('loads comuni from json', function (): void {
        $comuni = Comune::all();

        Assert::assertCount(2, $comuni);
        /** @var Comune|null $first */
        $first = $comuni->first();
        Assert::assertNotNull($first);
        Assert::assertSame('Milano', $first->nome);
        /** @var Comune|null $last */
        $last = $comuni->last();
        Assert::assertNotNull($last);
        Assert::assertSame('Sesto San Giovanni', $last->nome);
    });

    test('filters comuni by region', function (): void {
        $comuni = Comune::query()->where('regione->nome', 'Lombardia')->get();

        Assert::assertCount(2, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Lombardia', $first->regione['nome'] ?? null);
    });

    test('filters comuni by province', function (): void {
        $comuni = Comune::query()->where('provincia->nome', 'Milano')->get();

        Assert::assertCount(2, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->provincia['nome'] ?? null);
    });

    test('filters comuni by cap', function (): void {
        $comuni = Comune::findByCap('20100');

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame(['20100'], $first->cap);
    });

    test('filters comuni by name', function (): void {
        $comuni = Comune::query()->where('nome', 'like', '%Milano%')->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
    });

    test('filters comuni by exact name', function (): void {
        $comune = Comune::findByNome('Milano');

        Assert::assertInstanceOf(Comune::class, $comune);
        Assert::assertSame('Milano', $comune->nome);
    });

    test('filters comuni by name and province', function (): void {
        $comuni = Comune::query()
            ->where('nome', 'Milano')
            ->where('provincia->nome', 'Milano')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame('Milano', $first->provincia['nome'] ?? null);
    });

    test('filters comuni by name and region', function (): void {
        $comuni = Comune::query()
            ->where('nome', 'Milano')
            ->where('regione->nome', 'Lombardia')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame('Lombardia', $first->regione['nome'] ?? null);
    });

    test('filters comuni by name province and region', function (): void {
        $comuni = Comune::query()
            ->where('nome', 'Milano')
            ->where('provincia->nome', 'Milano')
            ->where('regione->nome', 'Lombardia')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame('Milano', $first->provincia['nome'] ?? null);
        Assert::assertSame('Lombardia', $first->regione['nome'] ?? null);
    });

    test('filters comuni by name and cap', function (): void {
        $comuni = Comune::query()
            ->where('nome', 'Milano')
            ->where('cap', 'like', '%"20100"%')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame(['20100'], $first->cap);
    });

    test('filters comuni by name province and cap', function (): void {
        $comuni = Comune::query()
            ->where('nome', 'Milano')
            ->where('provincia->nome', 'Milano')
            ->where('cap', 'like', '%"20100"%')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame('Milano', $first->provincia['nome'] ?? null);
        Assert::assertSame(['20100'], $first->cap);
    });

    test('filters comuni by name region and cap', function (): void {
        $comuni = Comune::query()
            ->where('nome', 'Milano')
            ->where('regione->nome', 'Lombardia')
            ->where('cap', 'like', '%"20100"%')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame('Lombardia', $first->regione['nome'] ?? null);
        Assert::assertSame(['20100'], $first->cap);
    });

    test('filters comuni by name province region and cap', function (): void {
        $comuni = Comune::query()
            ->where('nome', 'Milano')
            ->where('provincia->nome', 'Milano')
            ->where('regione->nome', 'Lombardia')
            ->where('cap', 'like', '%"20100"%')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame('Milano', $first->provincia['nome'] ?? null);
        Assert::assertSame('Lombardia', $first->regione['nome'] ?? null);
        Assert::assertSame(['20100'], $first->cap);
    });

    test('creates a new comune', function (): void {
        $comune = Comune::create([
            'regione' => ['codice' => '03', 'nome' => 'Lombardia'],
            'provincia' => ['codice' => 'MI', 'nome' => 'Milano'],
            'nome' => 'Bresso',
            'cap' => ['20091'],
            'lat' => 45.5389,
            'lng' => 9.1900,
        ]);

        Assert::assertNotNull($comune);
        Assert::assertSame('Bresso', $comune->nome);
        Assert::assertSame('Milano', $comune->provincia['nome'] ?? null);
        Assert::assertSame('Lombardia', $comune->regione['nome'] ?? null);
        Assert::assertSame(['20091'], $comune->cap);
        Assert::assertNotNull(Comune::findByNome('Bresso'));
        Assert::assertSame(45.5389, $comune->lat);
        Assert::assertSame(9.1900, $comune->lng);
    });

    test('updates an existing comune', function (): void {
        $comune = Comune::first();
        Assert::assertInstanceOf(Comune::class, $comune);

        $comune->update([
            'nome' => 'Milano Centro',
            'cap' => ['20121'],
        ]);

        Assert::assertSame('Milano Centro', $comune->nome);
        Assert::assertSame(['20121'], $comune->cap);
        Assert::assertNotNull(Comune::findByNome('Milano Centro'));
    });

    test('deletes an existing comune', function (): void {
        $comune = Comune::first();
        Assert::assertInstanceOf(Comune::class, $comune);
        $id = $comune->id;

        $comune->delete();

        Assert::assertNull(Comune::find($id));
    });
});
