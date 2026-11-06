<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Mockery;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Tests\TestCase;
use Modules\Tenant\Tests\Unit\Fixtures\CatalogSushiCsvModel;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    $directory = storage_path('tests/sushi-csv');
    File::deleteDirectory($directory);
    File::makeDirectory($directory, 0755, true, true);

    TestCase::$testDirectory = $directory;
    $csvPath = $directory.'/catalog.csv';
    File::put(
        $csvPath,
        "id,name\n1,Item A\n2,Item B\n3,Item C\n"
    );

    $mock = Mockery::mock(GetTenantFilePathAction::class);
    $mock->allows(['execute' => $csvPath]);
    app()->instance(GetTenantFilePathAction::class, $mock);

    config(['sushi.cache-path' => $directory]);

    // Dopo il mock: flushEventListeners() fa `new static`, e il boot di Sushi legge il CSV.
    CatalogSushiCsvModel::flushEventListeners();
    Model::clearBootedModels();
});

afterEach(function (): void {
    File::deleteDirectory(TestCase::$testDirectory);
    Mockery::close();
});

it('loads rows from tenant csv via getSushiRows', function (): void {
    $model = new CatalogSushiCsvModel;
    $rows = $model->getSushiRows();

    Assert::assertCount(3, $rows);
    Assert::assertSame('Item A', $rows[0]['name']);
});

it('exposes csv path resolved through GetTenantFilePathAction', function (): void {
    $model = new CatalogSushiCsvModel;

    Assert::assertStringEndsWith('catalog.csv', $model->getCsvPath());
});

it('queries sushi csv rows with eloquent where', function (): void {
    $found = CatalogSushiCsvModel::query()->where('name', 'Item B')->first();

    Assert::assertNotNull($found);
    Assert::assertSame('Item B', $found->name);
});

it('finds row by primary key', function (): void {
    $found = CatalogSushiCsvModel::query()->find(2);

    Assert::assertNotNull($found);
    Assert::assertSame('Item B', $found->name);
});

it('throws when csv file is missing', function (): void {
    File::delete(TestCase::$testDirectory.'/catalog.csv');

    expect(fn () => (new CatalogSushiCsvModel)->getSushiRows())
        ->toThrow(\League\Csv\Exception::class);
});
