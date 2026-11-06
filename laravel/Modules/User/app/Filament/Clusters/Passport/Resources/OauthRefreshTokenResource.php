<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\PageRegistration;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Actions\Passport\RevokeRefreshTokenAction;
use Modules\User\Filament\Clusters\Passport;
use Modules\User\Filament\Clusters\Passport\Resources\OauthRefreshTokenResource\Pages\ListOauthRefreshTokens;
use Modules\User\Filament\Clusters\Passport\Resources\OauthRefreshTokenResource\Pages\ViewOauthRefreshToken;
use Modules\User\Models\OauthRefreshToken;
use Modules\Xot\Filament\Resources\XotBaseResource;

class OauthRefreshTokenResource extends XotBaseResource
{
    protected static ?string $cluster = Passport::class;

    protected static ?string $model = OauthRefreshToken::class;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                IDColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('access_token_id')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('revoked')
                    ->boolean()
                    ->color(fn (bool $state): string => $state ? 'danger' : 'success'),

                TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Add filters for revoked status, expiration
            ])
            ->recordActions([
                Action::make('revoke')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Model|array|null $record): void {
                        if ($record instanceof OauthRefreshToken && app(RevokeRefreshTokenAction::class)->execute($record)) {
                            Notification::make()
                                ->title(static::trans('actions.revoke.success'))
                                ->success()
                                ->send();
                        }
                    })
                    ->visible(fn (Model|array|null $record) => $record instanceof OauthRefreshToken && ! (bool) $record->getAttribute('revoked')),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('expires_at', 'desc');
    }

    /**
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
