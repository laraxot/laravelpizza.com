<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources\ChartResource\Pages;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Modules\Chart\Filament\Resources\ChartResource;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Pagina di elenco per le risorse Chart.
 */
class ListCharts extends XotBaseListRecords
{
    /**
     * Layout della tabella.
     */
    public TableLayoutEnum $layoutView = TableLayoutEnum::LIST;

    /**
     * Risorsa associata a questa pagina.
     */
    protected static string $resource = ChartResource::class;

    /**
     * Definisce le colonne della tabella.
     *
     * @return array<string, TextColumn>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable()
                ->searchable(),
            'type' => TextColumn::make('type')
                ->sortable()
                ->searchable(),
            'group_by' => TextColumn::make('group_by')
                ->sortable()
                ->searchable(),
            'sort_by' => TextColumn::make('sort_by')
                ->sortable(),
            'width' => TextColumn::make('width')
                ->numeric()
                ->sortable(),
            'height' => TextColumn::make('height')
                ->numeric()
                ->sortable(),
            'font_family' => TextColumn::make('font_family')
                ->searchable(),
            'font_style' => TextColumn::make('font_style')
                ->searchable(),
            'font_size' => TextColumn::make('font_size')
                ->numeric()
                ->sortable(),
        ];
    }
}
