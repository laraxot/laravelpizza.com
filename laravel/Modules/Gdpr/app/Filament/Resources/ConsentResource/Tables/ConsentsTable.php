<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources\ConsentResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ConsentsTable extends XotBaseResourceTable
{
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->searchable(),
            'treatment' => TextColumn::make('treatment.name')->searchable(),
            'subject_id' => TextColumn::make('subject_id')->searchable(),
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
