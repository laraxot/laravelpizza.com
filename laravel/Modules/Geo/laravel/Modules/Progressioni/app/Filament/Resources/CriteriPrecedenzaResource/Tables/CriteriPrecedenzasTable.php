<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CriteriPrecedenzaResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class CriteriPrecedenzasTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'parent_id' => TextColumn::make('parent_id')
                ->numeric()
                ->sortable(),
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'order_direction' => TextColumn::make('order_direction')
                ->sortable(),
            'label' => TextColumn::make('label')
                ->searchable()
                ->sortable(),
            'descr' => TextColumn::make('descr')
                ->searchable()
                ->sortable(),
            'post_type' => TextColumn::make('post_type')
                ->sortable(),
            'posizione' => TextColumn::make('posizione')
                ->numeric()
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
}
