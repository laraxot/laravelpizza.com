<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\DeviceResource\Pages;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\User\Filament\Resources\DeviceResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListDevices extends XotBaseListRecords
{
    protected static string $resource = DeviceResource::class;

    /**
     * @return array<string, Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'uuid' => TextColumn::make('uuid')->searchable()->sortable(),
            'mobile_id' => TextColumn::make('mobile_id')->searchable()->sortable(),
            'device' => TextColumn::make('device')->searchable()->sortable(),
            'platform' => TextColumn::make('platform')->searchable()->sortable(),
            'browser' => TextColumn::make('browser')->searchable()->sortable(),
            'version' => TextColumn::make('version')->searchable()->sortable(),
            'is_robot' => IconColumn::make('is_robot')->boolean(),
            'is_desktop' => IconColumn::make('is_desktop')->boolean(),
            'is_mobile' => IconColumn::make('is_mobile')->boolean(),
            'is_tablet' => IconColumn::make('is_tablet')->boolean(),
            'is_phone' => IconColumn::make('is_phone')->boolean(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
}
