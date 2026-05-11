<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class NotificationsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'type' => TextColumn::make('type')->sortable(),
            'status' => TextColumn::make('status')->sortable(),
            'read_at' => TextColumn::make('read_at')->dateTime()->sortable(),
            'sent_at' => TextColumn::make('sent_at')->dateTime()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
