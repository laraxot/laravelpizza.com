<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\Pages;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Arr;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

use function Safe\date;

abstract class PtvBaseYearListRecords extends XotBaseListRecords
{
    public string $yearFieldName = 'anno';

    #[Override]
    protected function getHeaderActions(): array
    {
        /** @var array<string, mixed>|null $tableFilters */
        $tableFilters = $this->tableFilters;
        $anno = $tableFilters ? Arr::get($tableFilters, 'anno.value') : null;

        // @phpstan-ignore-next-line return.type
        return [
            ...parent::getHeaderActions(),
            CopyFromLastYearAction::make('copy_from_last_year')->setYearFieldName($this->yearFieldName),
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
            'anno' => app(GetYearFilter::class)
                ->execute($this->yearFieldName, intval(date('Y')) - 3, intval(date('Y'))),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'id' => TextColumn::make('id'),
            'name' => TextColumn::make('name'),
            'field_name' => TextColumn::make('field_name'),
            'op' => TextColumn::make('op'),
            'value' => TextColumn::make('value'),
            'type' => TextColumn::make('type'),
            'anno' => TextColumn::make('anno'),
        ];
    }
}
