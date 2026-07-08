<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\OptionResource\Tables;

use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Performance\Models\Option;
use Modules\Ptv\Enums\WorkerType;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class OptionsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'id' => TextColumn::make('id')
                ->numeric()
                ->sortable(),
            /*
                Tables\Columns\TextInputColumn::make('parent_id')
                    ->type('number')
                    ->sortable(),
                */
            'parent_id' => SelectColumn::make('parent_id')->options(function ($record) {
                // Type narrowing: ensure record is object with properties
                if (! is_object($record)) {
                    return [];
                }

                $year = isset($record->year) ? $record->year : null;
                $optionType = isset($record->option_type) ? $record->option_type : null;
                $name = isset($record->name) ? $record->name : null;

                if ($year === null || $optionType === null || $name === null) {
                    return [];
                }

                $query = Option::where('year', $year)
                    ->where('option_type', $optionType)
                    ->where('name', $name);

                // Type narrowing: ensure record has getKey() method
                if (method_exists($record, 'getKey')) {
                    $recordKey = $record->getKey();
                    if ($recordKey !== null) {
                        $query = $query->where('id', '!=', $recordKey);
                    }
                }

                $opts = $query->where('value', '!=', '')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        $k = $item->id;
                        $v = $item->id.' ]'.$item->value;

                        return [$k => $v];
                    })
                    ->concat([null => 'Root'])
                    ->toArray();

                return $opts;
            }),
            'option_type' => TextColumn::make('option_type')
                ->searchable(),
            'name' => TextColumn::make('name')
                ->searchable(),
            'value' => TextColumn::make('value')
                ->searchable()
                ->wrap(),
            'txt' => TextColumn::make('txt')
                ->searchable()
                ->wrap()
                ->html(),
            'txt1' => TextColumn::make('txt1')
                ->searchable()
                ->wrap()
                ->html(),
            /*
                Tables\Columns\TextColumn::make('option_id')
                    ->numeric()
                    ->sortable(),
                */
            /*
                Tables\Columns\TextColumn::make('pos')
                    ->numeric()
                    ->sortable(),
                */
            'year' => TextColumn::make('year')
                ->numeric()
                ->sortable(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            'option_type' => SelectFilter::make('option_type')
                ->options(WorkerType::class),
        ];
    }
}
