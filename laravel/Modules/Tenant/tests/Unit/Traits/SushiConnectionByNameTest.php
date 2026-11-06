<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\TestCase;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToCsvConnectionProbe;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonsCoverageModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToPhpArrayConnectionProbe;
use Webmozart\Assert\Assert;

use function Safe\json_decode;
use function Safe\json_encode;

uses(TestCase::class);

/**
 * Regressione: `Rule::unique(Model::class)` (quindi anche il `->unique()` di Filament) su un modello
 * Sushi senza cache su file falliva con "no such table". Sushi chiama la connessione come la classe
 * del modello, ma la registra solo nella config come SQLite `:memory:`: chi la risolve per nome
 * ottiene un database nuovo e vuoto, non quello dove Sushi ha creato la tabella.
 */
beforeEach(function (): void {
    // Sushi legge il JSON al boot del modello: ogni test deve ripartire da un modello non avviato.
    // I listener vanno azzerati prima, altrimenti il nuovo boot li registra due volte sullo stesso dispatcher.
    TestSushiModel::flushEventListeners();
    Model::clearBootedModels();

    TestCase::$testDirectory = storage_path('tests/sushi-json');
    TestCase::$testJsonPath = TestCase::$testDirectory.'/test_sushi.json';

    File::deleteDirectory(TestCase::$testDirectory);
    File::makeDirectory(TestCase::$testDirectory, 0755, true, true);

    // Mai il file condiviso di storage/framework/cache: se il primo migrate fallisce Sushi lo lascia vuoto
    // ma "aggiornato", e da allora ogni richiesta risponde "no such table".
    config(['sushi.cache-path' => TestCase::$testDirectory]);
});

afterEach(function (): void {
    File::deleteDirectory(TestCase::$testDirectory);
});

it('resolves the connection named after the model to the live sushi connection', function (string $modelClass): void {
    $modelClass::flushEventListeners();
    Model::clearBootedModels();

    $model = new $modelClass;
    Assert::isInstanceOf($model, Model::class);

    expect(DB::connection($modelClass))->toBe($model->resolveConnection());
})->with([
    'SushiToJson' => TestSushiModel::class,
    'SushiToJsons' => SushiToJsonsCoverageModel::class,
    'SushiToCsv' => SushiToCsvConnectionProbe::class,
    'SushiToPhpArray' => SushiToPhpArrayConnectionProbe::class,
]);

it('validates unique against the rows read from the json file', function (): void {
    File::put(TestCase::$testJsonPath, json_encode([
        [
            'id' => 1,
            'name' => 'ttt',
        ],
    ]));

    $duplicate = Validator::make(
        ['name' => 'ttt'],
        ['name' => [Rule::unique(TestSushiModel::class, 'name')]],
    );
    $free = Validator::make(
        ['name' => 'altro'],
        ['name' => [Rule::unique(TestSushiModel::class, 'name')]],
    );

    expect($duplicate->fails())->toBeTrue();
    expect($free->passes())->toBeTrue();
});

it('lets a record keep its own value when unique ignores it like filament does', function (): void {
    File::put(TestCase::$testJsonPath, json_encode([
        [
            'id' => 1,
            'name' => 'ttt',
        ],
    ]));

    $validator = Validator::make(
        ['name' => 'ttt'],
        ['name' => [Rule::unique(TestSushiModel::class, 'name')->ignore(1, 'test_sushi.id')]],
    );

    expect($validator->passes())->toBeTrue();
});

it('validates exists against the rows read from the json file', function (): void {
    File::put(TestCase::$testJsonPath, json_encode([
        [
            'id' => 1,
            'name' => 'ttt',
        ],
    ]));

    $known = Validator::make(['id' => 1], ['id' => [Rule::exists(TestSushiModel::class, 'id')]]);
    $unknown = Validator::make(['id' => 99], ['id' => [Rule::exists(TestSushiModel::class, 'id')]]);

    expect($known->passes())->toBeTrue();
    expect($unknown->fails())->toBeTrue();
});

it('rejects a duplicate right after the first record is created into a missing json file', function (): void {
    TestSushiModel::create(['name' => 'ttt']);

    $rows = json_decode(File::get(TestCase::$testJsonPath), true);
    $duplicate = Validator::make(
        ['name' => 'ttt'],
        ['name' => [Rule::unique(TestSushiModel::class, 'name')]],
    );

    expect($rows)->toHaveCount(1);
    expect($duplicate->fails())->toBeTrue();
});

it('creates the first record when the json file exists but is empty', function (): void {
    File::put(TestCase::$testJsonPath, '');

    TestSushiModel::create(['name' => 'ttt']);

    $rows = json_decode(File::get(TestCase::$testJsonPath), true);

    expect($rows)->toHaveCount(1);
});
