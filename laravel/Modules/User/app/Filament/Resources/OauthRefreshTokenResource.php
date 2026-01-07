<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table; // Already there, but explicitly for boolean()
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Resources\OauthRefreshTokenResource\Pages;
use Modules\User\Filament\Resources\OauthRefreshTokenResource\Pages\ListOauthRefreshTokens;
use Modules\User\Filament\Resources\OauthRefreshTokenResource\Pages\ViewOauthRefreshToken;
use Modules\User\Models\OauthRefreshToken;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class OauthRefreshTokenResource.
 */
class OauthRefreshTokenResource extends XotBaseResource
{
    protected static ?string $model = OauthRefreshToken::class;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $modelLabel = 'OAuth Refresh Token';

    protected static ?string $pluralModelLabel = 'OAuth Refresh Tokens';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-path';

    /**
     * Get the form schema for the resource.
     *
     * @return array<string, Select|TextInput>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'access_token_id' => Select::make('access_token_id')
                ->relationship('accessToken', 'id')
                ->searchable()
                ->required(),
            'revoked' => TextInput::make('revoked')
                ->numeric()
                ->required(),
            'expires_at' => TextInput::make('expires_at'),
        ];
    }

    /**
     * Extend table callback for the resource.
     *
     * @return array<string, mixed>
     */
    public static function extendTableCallback(): array
    {
        return [
            'columns' => [
                TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('accessToken.id')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('revoked')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ],
            'filters' => [
                // Add filters for revoked status, expiration
            ],
            'actions' => [
                DeleteAction::make(),
            ],
            'bulk_actions' => [
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ],
            'default_sort' => ['created_at', 'desc'],
        ];
    }

    /**
     * Get the pages available for the resource.
     *
     * @return array<string, PageRegistration>
     */
    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListOauthRefreshTokens::route('/'),
            'view' => ViewOauthRefreshToken::route('/{record}'),
        ];
    }

    /**
     * Modify the Eloquent query used to retrieve the records.
     */
    #[\Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['accessToken']);
    }
}
