<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Modules\Geo\Models\Comune;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    // Crea un file JSON di test
    $this->testData = [
        [
            'id' => 1,
            'regione' => 'Lombardia',
            'provincia' => 'Milano',
            'comune' => 'Milano',
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
            'comune' => 'Sesto San Giovanni',
            'cap' => '20099',
            'lat' => 45.5347,
            'lng' => 9.2345,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    File::put(base_path('database/content/comuni.json'), json_encode($this->testData, JSON_PRETTY_PRINT));
});

afterEach(function (): void {
    // Pulisci la cache
    Cache::forget('sushi_Comune_data');

    // Rimuovi il file di test
    File::delete(base_path('database/content/comuni.json'));
});

test('it can load comuni from json', function (): void {
    $comuni = Comune::all();

    expect($comuni)->toHaveCount(2);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[1]->comune)->toBe('Sesto San Giovanni');
});

test('it can filter comuni by region', function (): void {
    $comuni = Comune::byRegion('Lombardia')->get();

    expect($comuni)->toHaveCount(2);
    expect($comuni[0]->regione)->toBe('Lombardia');
    expect($comuni[1]->regione)->toBe('Lombardia');
});

test('it can filter comuni by province', function (): void {
    $comuni = Comune::byProvince('Milano')->get();

    expect($comuni)->toHaveCount(2);
    expect($comuni[0]->provincia)->toBe('Milano');
    expect($comuni[1]->provincia)->toBe('Milano');
});

test('it can filter comuni by cap', function (): void {
    $comuni = Comune::byCap('20100')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->cap)->toBe('20100');
});

test('it can filter comuni by name', function (): void {
    $comuni = Comune::byName('Milano')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
});

test('it can filter comuni by exact name', function (): void {
    $comuni = Comune::byExactName('Milano')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
});

test('it can filter comuni by name and province', function (): void {
    $comuni = Comune::byNameAndProvince('Milano', 'Milano')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->provincia)->toBe('Milano');
});

test('it can filter comuni by name and region', function (): void {
    $comuni = Comune::byNameAndRegion('Milano', 'Lombardia')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->regione)->toBe('Lombardia');
});

test('it can filter comuni by name province and region', function (): void {
    $comuni = Comune::byNameProvinceAndRegion('Milano', 'Milano', 'Lombardia')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->provincia)->toBe('Milano');
    expect($comuni[0]->regione)->toBe('Lombardia');
});

test('it can filter comuni by name and cap', function (): void {
    $comuni = Comune::byNameAndCap('Milano', '20100')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->cap)->toBe('20100');
});

test('it can filter comuni by name province and cap', function (): void {
    $comuni = Comune::byNameProvinceAndCap('Milano', 'Milano', '20100')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->provincia)->toBe('Milano');
    expect($comuni[0]->cap)->toBe('20100');
});

test('it can filter comuni by name region and cap', function (): void {
    $comuni = Comune::byNameRegionAndCap('Milano', 'Lombardia', '20100')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->regione)->toBe('Lombardia');
    expect($comuni[0]->cap)->toBe('20100');
});

test('it can filter comuni by name province region and cap', function (): void {
    $comuni = Comune::byNameProvinceRegionAndCap('Milano', 'Milano', 'Lombardia', '20100')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->provincia)->toBe('Milano');
    expect($comuni[0]->regione)->toBe('Lombardia');
    expect($comuni[0]->cap)->toBe('20100');
});

test('it can create a new comune', function (): void {
    $comune = Comune::create([
        'regione' => 'Lombardia',
        'provincia' => 'Milano',
        'comune' => 'Bresso',
        'cap' => '20091',
        'lat' => 45.5389,
        'lng' => 9.1900,
    ]);

    expect($comune->id)->not->toBeNull();
    expect($comune->comune)->toBe('Bresso');
    expect($comune->provincia)->toBe('Milano');
    expect($comune->regione)->toBe('Lombardia');
    expect($comune->cap)->toBe('20091');
    expect($comune->lat)->toBe(45.5389);
    expect($comune->lng)->toBe(9.1900);
});

test('it can update an existing comune', function (): void {
    $comune = Comune::first();
    $comune->update([
        'comune' => 'Milano Centro',
        'cap' => '20121',
    ]);

    expect($comune->comune)->toBe('Milano Centro');
    expect($comune->cap)->toBe('20121');
});

test('it can delete an existing comune', function (): void {
    $comune = Comune::first();
    $id = $comune->id;

    $comune->delete();

    expect(Comune::find($id))->toBeNull();
});
