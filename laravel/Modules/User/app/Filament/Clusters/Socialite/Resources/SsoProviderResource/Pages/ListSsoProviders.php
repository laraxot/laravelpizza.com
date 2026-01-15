<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources\SsoProviderResource\Pages;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\User\Filament\Clusters\Socialite\Resources\SsoProviderResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListSsoProviders extends XotBaseListRecords
{
    protected static string $resource = SsoProviderResource::class;

    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable()->wrap(),
            'display_name' => TextColumn::make('display_name')->searchable()->sortable()->wrap(),
            'type' => TextColumn::make('type')->searchable()->sortable(),
            'is_active' => IconColumn::make('is_active')->boolean()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable(),
        ];
    }

    #[\Override]
    public function getTableFilters(): array
    {
        return [
            'type' => SelectFilter::make('type')->options([
                'saml' => 'SAML',
                'oidc' => 'OIDC',
                'oauth' => 'OAuth',
            ]),
            'is_active' => SelectFilter::make('is_active')->options([
                true => 'Active',
                false => 'Inactive',
            ]),
        ];
    }
}
