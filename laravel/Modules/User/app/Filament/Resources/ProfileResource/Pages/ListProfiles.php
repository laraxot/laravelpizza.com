<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\ProfileResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\User\Filament\Resources\ProfileResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListProfiles extends XotBaseListRecords
{
    protected static string $resource = ProfileResource::class;

    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'email' => TextColumn::make('email')->searchable()->sortable(),
            'first_name' => TextColumn::make('first_name')->searchable()->sortable(),
            'last_name' => TextColumn::make('last_name')->searchable()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
}
