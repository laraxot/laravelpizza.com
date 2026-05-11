<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Table;

abstract class XotBaseResourceTable
{
    public static function configure(Table $table): Table
    {
        $columns = static::getTableColumns();

        if (empty($columns)) {
            throw new \InvalidArgumentException('['.static::class.'::getTableColumns()] cannot return an empty array. Study the related Model and Migration to determine the real columns.');
        }

        return $table
            ->columns($columns)
            ->filters(static::getTableFilters())
            ->recordActions(static::getTableActions())
            ->toolbarActions(static::getTableBulkActions());
    }

    /**
     * @return array<string, Column>
     */
    abstract public static function getTableColumns(): array;

    /**
     * @return array<string, BaseFilter>
     */
    public static function getTableFilters(): array
    {
        return [];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    public static function getTableActions(): array
    {
        return [];
    }

    /**
     * @return array<string, BulkAction|BulkActionGroup>
     */
    public static function getTableBulkActions(): array
    {
        return [];
    }
}
