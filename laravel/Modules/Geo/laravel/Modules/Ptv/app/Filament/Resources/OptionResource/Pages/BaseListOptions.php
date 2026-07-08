<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\OptionResource\Pages;

use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Performance\Models\Option;
use Modules\Ptv\Enums\WorkerType;
use Modules\Ptv\Filament\Resources\OptionResource;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Override;

abstract class BaseListOptions extends PtvBaseYearListRecords
{
    protected static string $resource = OptionResource::class;

    public string $yearFieldName = 'year';

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->numeric()
                ->sortable(),
            'parent_id' => SelectColumn::make('parent_id')->options(function ($record) {
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

                if (method_exists($record, 'getKey')) {
                    $recordKey = $record->getKey();
                    if ($recordKey !== null) {
                        $query = $query->where('id', '!=', $recordKey);
                    }
                }

                return $query->where('value', '!=', '')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        $k = $item->id;
                        $v = $item->id.' ]'.$item->value;

                        return [$k => $v];
                    })
                    ->concat([null => 'Root'])
                    ->toArray();
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
            'year' => TextColumn::make('year')
                ->numeric()
                ->sortable(),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            ...parent::getTableFilters(),
            SelectFilter::make('option_type')
                ->options(WorkerType::class),
        ];
    }
}
