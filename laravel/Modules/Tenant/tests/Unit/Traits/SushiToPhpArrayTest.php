<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Model;
use Mockery;
use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Modules\Tenant\Tests\TestCase;
use Modules\Tenant\Tests\Unit\Fixtures\SushiPhpArrayCatalogProbe;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToPhpArrayConnectionProbe;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    SushiToPhpArrayConnectionProbe::flushEventListeners();
    Model::clearBootedModels();
});

afterEach(function (): void {
    Mockery::close();
});

it('loads rows from tenant php config array', function (): void {
    $mock = Mockery::mock(GetTenantConfigArrayAction::class);
    $mock->allows([
        'execute' => [
            ['id' => 1, 'title' => 'Item A', 'price' => '10'],
            ['id' => 2, 'title' => 'Item B', 'price' => '20'],
        ],
    ]);
    app()->instance(GetTenantConfigArrayAction::class, $mock);
    app()->instance(FilterConfigStringKeysAction::class, new FilterConfigStringKeysAction);

    SushiPhpArrayCatalogProbe::flushEventListeners();
    Model::clearBootedModels();

    $rows = (new SushiPhpArrayCatalogProbe)->getSushiRows();

    Assert::assertCount(2, $rows);
    Assert::assertSame('Item A', $rows[0]['title']);
});

it('queries sushi php array rows', function (): void {
    $mock = Mockery::mock(GetTenantConfigArrayAction::class);
    $mock->allows([
        'execute' => [
            ['id' => 1, 'title' => 'Query Me', 'price' => '5'],
        ],
    ]);
    app()->instance(GetTenantConfigArrayAction::class, $mock);
    app()->instance(FilterConfigStringKeysAction::class, new FilterConfigStringKeysAction);

    SushiPhpArrayCatalogProbe::flushEventListeners();
    Model::clearBootedModels();

    $found = SushiPhpArrayCatalogProbe::query()->where('title', 'Query Me')->first();

    Assert::assertNotNull($found);
    Assert::assertSame('Query Me', $found->title);
});

it('uses fixed rows when getRows is overridden on probe', function (): void {
    $rows = (new SushiToPhpArrayConnectionProbe)->getRows();

    Assert::assertCount(1, $rows);
    Assert::assertSame('ttt', $rows[0]['name']);
});
