<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Clusters\Passport;
use Modules\User\Filament\Clusters\Passport\Resources\OauthRefreshTokenResource\Pages\ListOauthRefreshTokens;
use Modules\User\Filament\Clusters\Passport\Resources\OauthRefreshTokenResource\Pages\ViewOauthRefreshToken;
use Modules\User\Models\OauthRefreshToken;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

/**
 * Class OauthRefreshTokenResource.
 */
class OauthRefreshTokenResource extends XotBaseResource
{
    protected static ?string $cluster = Passport::class;
    protected static ?string $model = OauthRefreshToken::class;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $modelLabel = 'OAuth Refresh Token';

    protected static ?string $pluralModelLabel = 'OAuth Refresh Tokens';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-path';

    /**
     * Get the form schema for the resource.
     *
     * @return array<string, Component>
     */
    #[Override]
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
     * @return array<string, class-string>
     */
    #[Override]
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
    #[Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['accessToken']);
    }
}
