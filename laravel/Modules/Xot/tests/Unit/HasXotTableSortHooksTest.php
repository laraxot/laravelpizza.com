<?php

declare(strict_types=1);
use Filament\Tables\Columns\Column;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Modules\Xot\Tests\Unit\Support\DummyTestModel;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

uses(TestCase::class);

function invokeProtectedSortHook(object $instance, string $method): mixed
{
    $reflection = new ReflectionMethod($instance, $method);

    return $reflection->invoke($instance);
}

test('XotBaseResourceTable non dichiara hook di sort predefiniti', function (): void {
    $table = new class extends XotBaseResourceTable
    {
        /** @return array<string, Column> */
        public function getTableColumns(): array
        {
            return [];
        }

        public static function getModelClass(): string
        {
            return DummyTestModel::class;
        }
    };

    $reflection = new ReflectionClass($table);

    Assert::assertFalse($reflection->hasMethod('getTableSortColumn'));
    Assert::assertFalse($reflection->hasMethod('getTableSortDirection'));
});

test('getTableSortColumn override su XotBaseResourceTable', function (): void {
    $table = new class extends XotBaseResourceTable
    {
        /** @return array<string, Column> */
        public function getTableColumns(): array
        {
            return [];
        }

        public static function getModelClass(): string
        {
            return DummyTestModel::class;
        }

        public function getTableSortColumn(): string
        {
            return 'custom.id';
        }

        public function getTableSortDirection(): string
        {
            return 'asc';
        }
    };

    Assert::assertSame('custom.id', invokeProtectedSortHook($table, 'getTableSortColumn'));
    Assert::assertSame('asc', invokeProtectedSortHook($table, 'getTableSortDirection'));
});
