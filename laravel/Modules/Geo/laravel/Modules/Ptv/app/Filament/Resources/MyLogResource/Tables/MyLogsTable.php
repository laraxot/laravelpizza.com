<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\MyLogResource\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Ptv\Models\MyLog;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class MyLogsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),

            'tbl' => TextColumn::make('tbl')
                ->searchable()
                ->sortable(),

            'id_tbl' => TextColumn::make('id_tbl')
                ->numeric()
                ->sortable(),

            'note' => TextColumn::make('note')
                ->searchable()
                ->limit(50),

            'obj' => TextColumn::make('obj')
                ->searchable()
                ->limit(30),

            'act' => TextColumn::make('act')
                ->searchable()
                ->sortable(),

            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),

            'created_by' => TextColumn::make('created_by')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            'tbl' => SelectFilter::make('tbl')
                ->options(function (): array {
                    /** @var array<string, string> $tables */
                    $tables = MyLog::distinct('tbl')
                        ->whereNotNull('tbl')
                        ->orderBy('tbl')
                        ->pluck('tbl', 'tbl')
                        ->toArray();

                    return $tables;
                }),

            'note' => SelectFilter::make('note')
                ->options([
                    'sendMailLettF' => 'Invio Mail Lettera F',
                    'sendMailLettI' => 'Invio Mail Lettera I',
                ]),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableBulkActions(): array
    {
        return [];
    }
}
