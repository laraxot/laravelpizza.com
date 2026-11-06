<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotificationResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Notify\Models\Notification;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class NotificationsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Notification>
     */
    protected static string $model = Notification::class;

    public function getTableFilters(): array
    {
        return [
            'read' => Filter::make('is_read')
                ->query(fn (Builder $query): Builder => $query->where('read_at', '!=', null))
                ->label('Read'),
            'unread' => Filter::make('is_unread')
                ->query(fn (Builder $query): Builder => $query->whereNull('read_at'))
                ->label('Unread'),
            'type' => SelectFilter::make('type')
                ->options([
                    'info' => 'Info',
                    'success' => 'Success',
                    'warning' => 'Warning',
                    'error' => 'Error'])
                ->multiple()];
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'type' => TextColumn::make('type')->searchable()->sortable()->badge()->wrap(),
            'notifiable_type' => TextColumn::make('notifiable_type')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
            'notifiable_id' => TextColumn::make('notifiable_id')->searchable()->sortable(),
            'notifiable' => TextColumn::make('notifiable.name')->toggleable(isToggledHiddenByDefault: true),
            'data' => TextColumn::make('data')->toggleable(isToggledHiddenByDefault: true),
            'read_at' => TextColumn::make('read_at')->dateTime()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            'id' => IDColumn::make('id')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
