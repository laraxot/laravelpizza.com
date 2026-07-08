<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\MyLogResource\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class MyLogsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, CreateAction>
     */
    public function getTableHeaderActions(): array
    {
        return [
            'create_log' => CreateAction::make(),
        ];
    }

    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->numeric()
                ->sortable(),
            'id_tbl' => TextColumn::make('id_tbl')
                ->numeric()
                ->sortable(),
            'tbl' => TextColumn::make('tbl')
                ->searchable()
                ->sortable(),
            'id_approvaz' => TextColumn::make('id_approvaz')
                ->numeric()
                ->sortable(),
            'note' => TextColumn::make('note')
                ->searchable()
                ->sortable()
                ->wrap(),
            'data' => TextColumn::make('data')
                ->searchable()
                ->sortable(),
            'datemod' => TextColumn::make('datemod')
                ->searchable()
                ->sortable(),
            'handle' => TextColumn::make('handle')
                ->searchable()
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'created_by' => TextColumn::make('created_by')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_by' => TextColumn::make('updated_by')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public function getTableFilters(): array
    {
        return [
            'tbl' => SelectFilter::make('tbl')
                ->options(fn () => [
                    'individuales' => 'Individuali',
                    'individuale_pos' => 'Individuali PO',
                    'individuale_regionales' => 'Individuali Regionali',
                    'individuale_adms' => 'Individuali ADM',
                ]),
            'note' => Filter::make('note')
                ->schema([
                    TextInput::make('value')
                        ->placeholder('Inserisci la nota da cercare'),
                ])
                ->query(fn (Builder $query, array $data): Builder => $query->when(
                    $data['value'] ?? null,
                    fn (Builder $query, $value): Builder => $query->where('note', 'like', '%'.(string) $value.'%')
                )),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }
}
