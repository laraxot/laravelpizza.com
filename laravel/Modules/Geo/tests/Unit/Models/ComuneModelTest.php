<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Modules\Geo\Models\Comune;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

/**
 * @return list<array<string, mixed>>
 */
function comuneModelFixtures(): array
{
    return [
        [
            'id' => 1,
            'regione' => 'Lombardia',
            'provincia' => 'Milano',
            'nome' => 'Milano',
            'cap' => '20100',
            'lat' => 45.4642,
            'lng' => 9.1900,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 2,
            'regione' => 'Lombardia',
            'provincia' => 'Milano',
            'nome' => 'Sesto San Giovanni',
            'cap' => '20099',
            'lat' => 45.5347,
            'lng' => 9.2345,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];
}

uses(\Modules\Geo\Tests\TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\Geo\Tests\TestCase $this */
    File::put(
        base_path('database/content/comuni.json'),
        json_encode(comuneModelFixtures(), JSON_PRETTY_PRINT)
    );
});

afterEach(function (): void {
    Cache::forget('sushi_Comune_data');
    File::delete(base_path('database/content/comuni.json'));
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
        $comuni = Comune::query()->where('regione', 'Lombardia')->get();

        Assert::assertCount(2, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Lombardia', $first->regione);
    });

    test('filters comuni by province', function (): void {
        $comuni = Comune::query()->where('provincia', 'Milano')->get();

        Assert::assertCount(2, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->provincia);
    });

    test('filters comuni by cap', function (): void {
        $comuni = Comune::findByCap('20100');

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('20100', $first->cap);
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
            ->where('provincia', 'Milano')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame('Milano', $first->provincia);
    });

    test('filters comuni by name and region', function (): void {
        $comuni = Comune::query()
            ->where('nome', 'Milano')
            ->where('regione', 'Lombardia')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame('Lombardia', $first->regione);
    });

    test('filters comuni by name province and region', function (): void {
        $comuni = Comune::query()
            ->where('nome', 'Milano')
            ->where('provincia', 'Milano')
            ->where('regione', 'Lombardia')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame('Milano', $first->provincia);
        Assert::assertSame('Lombardia', $first->regione);
    });

    test('filters comuni by name and cap', function (): void {
        $comuni = Comune::query()
            ->where('nome', 'Milano')
            ->where('cap', '20100')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame('20100', $first->cap);
    });

    test('filters comuni by name province and cap', function (): void {
        $comuni = Comune::query()
            ->where('nome', 'Milano')
            ->where('provincia', 'Milano')
            ->where('cap', '20100')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame('Milano', $first->provincia);
        Assert::assertSame('20100', $first->cap);
    });

    test('filters comuni by name region and cap', function (): void {
        $comuni = Comune::query()
            ->where('nome', 'Milano')
            ->where('regione', 'Lombardia')
            ->where('cap', '20100')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame('Lombardia', $first->regione);
        Assert::assertSame('20100', $first->cap);
    });

    test('filters comuni by name province region and cap', function (): void {
        $comuni = Comune::query()
            ->where('nome', 'Milano')
            ->where('provincia', 'Milano')
            ->where('regione', 'Lombardia')
            ->where('cap', '20100')
            ->get();

        Assert::assertCount(1, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        Assert::assertSame('Milano', $first->provincia);
        Assert::assertSame('Lombardia', $first->regione);
        Assert::assertSame('20100', $first->cap);
    });

    test('creates a new comune', function (): void {
        $comune = Comune::create([
            'regione' => 'Lombardia',
            'provincia' => 'Milano',
            'nome' => 'Bresso',
            'cap' => '20091',
            'lat' => 45.5389,
            'lng' => 9.1900,
        ]);

        Assert::assertNotNull($comune);
        Assert::assertSame('Bresso', $comune->nome);
        Assert::assertSame('Milano', $comune->provincia);
        Assert::assertSame('Lombardia', $comune->regione);
        Assert::assertSame('20091', $comune->cap);
        Assert::assertSame(45.5389, $comune->lat);
        Assert::assertSame(9.1900, $comune->lng);
    });

    test('updates an existing comune', function (): void {
        $comune = Comune::first();
        Assert::assertInstanceOf(Comune::class, $comune);

        $comune->update([
            'nome' => 'Milano Centro',
            'cap' => '20121',
        ]);

        Assert::assertSame('Milano Centro', $comune->nome);
        Assert::assertSame('20121', $comune->cap);
    });

    test('deletes an existing comune', function (): void {
        $comune = Comune::first();
        Assert::assertInstanceOf(Comune::class, $comune);
        $id = $comune->id;

        $comune->delete();

        Assert::assertNull(Comune::find($id));
    });
});
