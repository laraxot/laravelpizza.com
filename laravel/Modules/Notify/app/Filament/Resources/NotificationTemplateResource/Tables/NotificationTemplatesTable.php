<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationTemplateResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class NotificationTemplatesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'code' => TextColumn::make('code')->searchable()->sortable(),
            'type' => TextColumn::make('type')->sortable(),
            'category' => TextColumn::make('category')->sortable(),
            'is_active' => TextColumn::make('is_active')->badge(),
            'version' => TextColumn::make('version')->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
