<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources\SocialProviderResource\Pages;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\User\Filament\Clusters\Socialite\Resources\SocialProviderResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * --.
 */
class ListSocialProviders extends XotBaseListRecords
{
    protected static string $resource = SocialProviderResource::class;

    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->wrap(),
            'active' => IconColumn::make('active')->boolean()->sortable(),
            'stateless' => IconColumn::make('stateless')->boolean()->sortable(),
            'socialite' => IconColumn::make('socialite')->boolean()->sortable(),
            'scopes' => TextColumn::make('scopes')->searchable()->wrap(),
            'parameters' => TextColumn::make('parameters')->searchable()->wrap(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable(),
        ];
    }

    #[\Override]
    public function getTableFilters(): array
    {
        return [
            'active' => SelectFilter::make('active')->options([
                true => 'Active',
                false => 'Inactive',
            ]),
        ];
    }
}
