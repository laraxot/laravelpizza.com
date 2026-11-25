<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Traits;

use Illuminate\Database\Schema\Blueprint;
use Mockery;
use Mockery\MockInterface;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Tests\Fixtures\Enums\EmptyDefinitionsEnum;
use Modules\Xot\Tests\Fixtures\Enums\TestEnum;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('gets label via translation', function (): void {
    $label = TestEnum::ALPHA->getLabel();
    Assert::assertSame('string', gettype($label));
});

it('gets color via translation', function (): void {
    $color = TestEnum::ALPHA->getColor();
    Assert::assertSame('string', gettype($color));
});

it('gets icon via translation', function (): void {
    $icon = TestEnum::ALPHA->getIcon();
    Assert::assertSame('string', gettype($icon));
});

it('gets description via translation', function (): void {
    $description = TestEnum::ALPHA->getDescription();
    Assert::assertSame('string', gettype($description));
});

it('gets searchable values', function (): void {
    Assert::assertSame(['alpha', 'beta'], TestEnum::getSearchable());
});

it('gets form schema', function (): void {
    $schema = TestEnum::ALPHA->getFormSchema();
    // Assert::assertIsArray($schema);
    Assert::assertCount(2, $schema);
});

it('adds columns to blueprint in create context', function (): void {
    $columns = TestEnum::getColumnDefinitions();
    Assert::assertCount(2, $columns);
    Assert::assertArrayHasKey('alpha', $columns);
    Assert::assertArrayHasKey('beta', $columns);
});

it('adds columns to blueprint in update context with hasColumn check', function (): void {
    /** @var XotBaseMigration&MockInterface $migration */
    $migration = Mockery::mock(XotBaseMigration::class);
    $migration->shouldReceive('hasColumn')->with('alpha')->andReturn(true);
    $migration->shouldReceive('hasColumn')->with('beta')->andReturn(false);

    /** @var Blueprint&MockInterface $columnBeta */
    $columnBeta = Mockery::mock(Blueprint::class);
    $columnBeta->shouldReceive('nullable')->andReturn($columnBeta);

    /** @var Blueprint&MockInterface $table */
    $table = Mockery::mock(Blueprint::class);
    $table->shouldReceive('string')->with('beta')->andReturn($columnBeta);

    TestEnum::columns($table, $migration);
});

it('updates columns calls columns', function (): void {
    /** @var Blueprint&MockInterface $column */
    $column = Mockery::mock(Blueprint::class);
    $column->shouldReceive('nullable')->andReturn($column);

    /** @var Blueprint&MockInterface $table */
    $table = Mockery::mock(Blueprint::class);
    $table->shouldReceive('string')->andReturn($column);

    /** @var XotBaseMigration&MockInterface $migration */
    $migration = Mockery::mock(XotBaseMigration::class);
    $migration->shouldReceive('hasColumn')->andReturn(false);

    TestEnum::updateColumns($table, $migration);
});

it('drops columns', function (): void {
    /** @var Blueprint&MockInterface $table */
    $table = Mockery::mock(Blueprint::class);
    $table->shouldReceive('dropColumn')->with(['alpha', 'beta']);

    TestEnum::dropColumns($table);
});

it('gets column names', function (): void {
    Assert::assertSame(['alpha', 'beta'], TestEnum::getColumnNames());
});

it('has default empty column definitions', function (): void {
    Assert::assertSame([], EmptyDefinitionsEnum::getColumnDefinitions());
});
