<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Traits;

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;
use Modules\Xot\Tests\Fixtures\Enums\TestEnum;
use Modules\Xot\Tests\TestCase;
use Modules\Xot\Traits\EnumTrait;

uses(TestCase::class);

it('gets label via translation', function (): void {
    // We expect translation keys like 'test_enum.alpha.label'
    // Since we don't have actual translations for TestEnum, it will likely return the key or fallback
    $label = TestEnum::ALPHA->getLabel();
    expect($label)->toBeString();
});

it('gets color via translation', function (): void {
    $color = TestEnum::ALPHA->getColor();
    expect($color)->toBeString();
});

it('gets icon via translation', function (): void {
    $icon = TestEnum::ALPHA->getIcon();
    expect($icon)->toBeString();
});

it('gets description via translation', function (): void {
    $description = TestEnum::ALPHA->getDescription();
    expect($description)->toBeString();
});

it('gets searchable values', function (): void {
    expect(TestEnum::getSearchable())->toBe(['alpha', 'beta']);
});

it('gets form schema', function (): void {
    $schema = TestEnum::getFormSchema();
    expect($schema)->toBeArray()
        ->and($schema)->toHaveCount(2)
        ->and($schema['alpha'])->toBeInstanceOf(\Filament\Forms\Components\TextInput::class);
});

it('adds columns to blueprint in create context', function (): void {
    $table = \Mockery::mock(Blueprint::class);

    // Expect string('alpha')->nullable()
    $columnAlpha = \Mockery::mock();
    $columnAlpha->shouldReceive('nullable')->andReturnSelf();
    $table->shouldReceive('string')->with('alpha')->andReturn($columnAlpha);

    // Expect string('beta')->nullable()
    $columnBeta = \Mockery::mock();
    $columnBeta->shouldReceive('nullable')->andReturnSelf();
    $table->shouldReceive('string')->with('beta')->andReturn($columnBeta);

    TestEnum::columns($table);

    \Mockery::close();
    expect(true)->toBeTrue(); // Assertion for mock execution
});

it('adds columns to blueprint in update context with hasColumn check', function (): void {
    $table = \Mockery::mock(Blueprint::class);
    $migration = \Mockery::mock(XotBaseMigration::class);

    // Alpha exists, Beta does not
    $migration->shouldReceive('hasColumn')->with('alpha')->andReturn(true);
    $migration->shouldReceive('hasColumn')->with('beta')->andReturn(false);

    // Should NOT call string('alpha')
    $table->shouldNotReceive('string')->with('alpha');

    // Should call string('beta')
    $columnBeta = \Mockery::mock();
    $columnBeta->shouldReceive('nullable')->andReturnSelf();
    $table->shouldReceive('string')->with('beta')->andReturn($columnBeta);

    TestEnum::columns($table, $migration);

    \Mockery::close();
    expect(true)->toBeTrue();
});

it('updates columns calls columns', function (): void {
    $table = \Mockery::mock(Blueprint::class);
    $migration = \Mockery::mock(XotBaseMigration::class);

    $migration->shouldReceive('hasColumn')->andReturn(false);
    $table->shouldReceive('string')->andReturn(\Mockery::mock(['nullable' => null]));

    TestEnum::updateColumns($table, $migration);

    \Mockery::close();
    expect(true)->toBeTrue();
});

it('drops columns', function (): void {
    $table = \Mockery::mock(Blueprint::class);
    $table->shouldReceive('dropColumn')->with(['alpha', 'beta']);

    TestEnum::dropColumns($table);

    \Mockery::close();
    expect(true)->toBeTrue();
});

it('gets column names', function (): void {
    expect(TestEnum::getColumnNames())->toBe(['alpha', 'beta']);
});

it('has default empty column definitions', function (): void {
    // Need a different enum without overrides
    $enum = new class
    {
        use EnumTrait;

        public static function cases()
        {
            return [];
        }
    };
    expect($enum::getColumnDefinitions())->toBe([]);
});
