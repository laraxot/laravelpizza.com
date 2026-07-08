<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Traits;

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Schema\Blueprint;
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
    $schema = TestEnum::getFormSchema();
    Assert::assertInstanceOf(TextInput::class, $schema);
    Assert::assertCount(2, $schema);
});

it('adds columns to blueprint in create context', function (): void {
    $columns = TestEnum::getColumnDefinitions();
    Assert::assertCount(2, $columns);
    Assert::assertArrayHasKey('alpha', $columns);
    Assert::assertArrayHasKey('beta', $columns);
});

it('adds columns to blueprint in update context with hasColumn check', function (): void {
    $migration = $this->createUnitMock(XotBaseMigration::class);
    $migration->method('hasColumn')
        ->willReturnMap([
            ['alpha', true],
            ['beta', false],
        ]);

    $columnBeta = $this->createUnitMock(Blueprint::class);
    $columnBeta->method('nullable')->willReturnSelf();

    $table = $this->createUnitMock(Blueprint::class);
    $table->method('string')
        ->with('beta')
        ->willReturn($columnBeta);

    TestEnum::columns($table, $migration);
});

it('updates columns calls columns', function (): void {
    $column = $this->createUnitMock(Blueprint::class);
    $column->method('nullable')->willReturnSelf();

    $table = $this->createUnitMock(Blueprint::class);
    $table->method('string')->willReturn($column);

    $migration = $this->createUnitMock(XotBaseMigration::class);
    $migration->method('hasColumn')->willReturn(false);

    TestEnum::updateColumns($table, $migration);
});

it('drops columns', function (): void {
    $table = $this->createUnitMock(Blueprint::class);
    $table->method('dropColumn')
        ->with(['alpha', 'beta']);

    TestEnum::dropColumns($table);
});

it('gets column names', function (): void {
    Assert::assertSame(['alpha', 'beta'], TestEnum::getColumnNames());
});

it('has default empty column definitions', function (): void {
    Assert::assertSame([], EmptyDefinitionsEnum::getColumnDefinitions());
});
