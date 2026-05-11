<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\ExtraResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ExtrasTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'model_type' => TextColumn::make('model_type')->searchable()->sortable(),
            'model_id' => TextColumn::make('model_id')->searchable()->sortable(),
            'extra_attributes' => TextColumn::make('extra_attributes'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
