<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

/**
 * RatingTable Schema - XotBaseResourceTable Zen Pattern.
 *
 * @see XotBaseResourceTable
 */
class RatingTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'title' => TextColumn::make('title')->searchable()->sortable(),
            'slug' => TextColumn::make('slug')->searchable()->sortable(),
            'rule' => TextColumn::make('rule')->badge()->sortable(),
            'is_disabled' => TextColumn::make('is_disabled')->badge()->sortable(),
            'is_readonly' => TextColumn::make('is_readonly')->badge()->sortable(),
            'order_column' => TextColumn::make('order_column')->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
        ];
    }

    /**
     * @return array<string, BulkAction|BulkActionGroup>
     */
    public function getTableBulkActions(): array
    {
        return [
            'bulk' => BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }
}
