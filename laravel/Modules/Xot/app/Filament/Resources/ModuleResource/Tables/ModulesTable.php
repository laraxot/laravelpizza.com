<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\ModuleResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ModulesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'description' => TextColumn::make('description')->searchable()->sortable(),
            'status' => TextColumn::make('status')->badge()->sortable(),
            'priority' => TextColumn::make('priority')->sortable(),
            'path' => TextColumn::make('path')->searchable(),
            'icon' => TextColumn::make('icon')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
