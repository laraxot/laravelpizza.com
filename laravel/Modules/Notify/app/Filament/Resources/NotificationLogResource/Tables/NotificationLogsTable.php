<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationLogResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Notify\Models\NotificationLog;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class NotificationLogsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<NotificationLog>
     */
    protected static string $model = NotificationLog::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'channel' => TextColumn::make('channel')->searchable()->sortable()->badge(),
            'status' => TextColumn::make('status')->searchable()->sortable()->badge(),
            'notifiable_type' => TextColumn::make('notifiable_type')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
            'notifiable_id' => TextColumn::make('notifiable_id')->searchable()->sortable(),
            'status_message' => TextColumn::make('status_message')->searchable()->wrap()->limit(100),
            'sent_at' => TextColumn::make('sent_at')->dateTime()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
}
