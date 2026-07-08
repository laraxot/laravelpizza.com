<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriEsclusioneResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Ptv\Filament\Actions\Bulk\CheckCriterioEsclusioneBulkAction;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\date;

class CriteriEsclusionesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'is_enabled' => ToggleColumn::make('is_enabled'),
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'field_name' => TextColumn::make('field_name')
                ->searchable()
                ->sortable(),
            'op' => TextColumn::make('op')
                ->searchable()
                ->sortable(),
            'value' => TextColumn::make('value')
                ->searchable()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            'anno' => SelectFilter::make('anno')
                ->options(function () {
                    $currentYear = (int) date('Y');

                    return [
                        $currentYear => $currentYear,
                        $currentYear - 1 => $currentYear - 1,
                        $currentYear - 2 => $currentYear - 2,
                    ];
                }),
        ];
    }

    /**
     * @return array<int|string, \Filament\Actions\BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            ...parent::getTableBulkActions(),
            CheckCriterioEsclusioneBulkAction::make(),
            // DeleteBulkAction::make(),
        ];
    }
}
