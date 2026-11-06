<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\DeviceResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\Device;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class DevicesTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Device>
     */
    protected static string $model = Device::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'device' => TextColumn::make('device')->searchable()->sortable(),
            'platform' => TextColumn::make('platform')->searchable()->sortable(),
            'browser' => TextColumn::make('browser')->searchable()->sortable(),
            'is_desktop' => IconColumn::make('is_desktop')->boolean()->sortable(),
            'is_mobile' => IconColumn::make('is_mobile')->boolean()->sortable(),
            'is_phone' => IconColumn::make('is_phone')->boolean()->sortable(),
            'is_tablet' => IconColumn::make('is_tablet')->boolean()->sortable(),
            'is_robot' => IconColumn::make('is_robot')->boolean()->sortable(),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'uuid' => TextColumn::make('uuid')->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
