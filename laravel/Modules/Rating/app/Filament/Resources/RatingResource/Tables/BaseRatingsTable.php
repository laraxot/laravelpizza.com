<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

/**
 * Tabella rating condivisa tra moduli che estendono BaseRatingResource.
 *
 * Le classi concrete nei moduli figli estendono questa base e sovrascrivono
 * i metodi getTable*() quando l'UI differisce.
 */
abstract class BaseRatingsTable extends XotBaseResourceTable
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
            // order_column è interno — usato solo per reordering via HasXotTable::applyReorderable()
            // Non visibile nell'UI utente (vedi story 5.97 e 5.98):
            // 'order_column' => TextColumn::make('order_column')->sortable(),
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
}
