<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\DeviceResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class DevicesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'uuid' => TextColumn::make('uuid'),
            'user_id' => TextColumn::make('user_id'),
            'device' => TextColumn::make('device'),
            'platform' => TextColumn::make('platform'),
            'browser' => TextColumn::make('browser'),
            'ip' => TextColumn::make('ip'),
            'is_desktop' => TextColumn::make('is_desktop')->badge(),
            'is_mobile' => TextColumn::make('is_mobile')->badge(),
            'is_phone' => TextColumn::make('is_phone')->badge(),
            'is_robot' => TextColumn::make('is_robot')->badge(),
            'is_tablet' => TextColumn::make('is_tablet')->badge(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
            'updated_by' => TextColumn::make('updated_by')->toggleable(),
            'created_by' => TextColumn::make('created_by')->toggleable(),
        ];
    }
}
