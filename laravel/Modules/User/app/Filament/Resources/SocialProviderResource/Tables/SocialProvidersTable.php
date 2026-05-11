<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SocialProviderResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class SocialProvidersTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'uuid' => TextColumn::make('uuid'),
            'name' => TextColumn::make('name')->searchable(),
            'slug' => TextColumn::make('slug'),
            'provider' => TextColumn::make('provider'),
            'active' => TextColumn::make('active')->badge(),
            'socialite' => TextColumn::make('socialite')->badge(),
            'stateless' => TextColumn::make('stateless')->badge(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
            'updated_by' => TextColumn::make('updated_by')->toggleable(),
            'created_by' => TextColumn::make('created_by')->toggleable(),
        ];
    }
}
