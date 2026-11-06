<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\PageRegistration;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Filament\Clusters\Passport;
use Modules\User\Filament\Clusters\Passport\Resources\OauthDeviceCodeResource\Pages\ListOauthDeviceCodes;
use Modules\User\Filament\Clusters\Passport\Resources\OauthDeviceCodeResource\Pages\ViewOauthDeviceCode;
use Modules\User\Models\OauthDeviceCode;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class OauthDeviceCodeResource.
 *
 * Resource Filament per i codici dispositivo OAuth (RFC8628 Device Authorization Grant).
 */
class OauthDeviceCodeResource extends XotBaseResource
{
    protected static ?string $cluster = Passport::class;

    protected static ?string $model = OauthDeviceCode::class;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->limit(20),

                TextColumn::make('user_code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user_id')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('client_id')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('scopes')
                    ->limit(30),

                IconColumn::make('revoked')
                    ->boolean()
                    ->color(fn (bool $state): string => $state ? 'danger' : 'success'),

                TextColumn::make('user_approved_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('revoked')
                    ->label(static::trans('filters.revoked'))
                    ->query(fn (Builder $query) => $query->where('revoked', true)),
                Filter::make('expired')
                    ->label(static::trans('filters.expired'))
                    ->query(fn (Builder $query) => $query->where('expires_at', '<', now())),
                Filter::make('valid')
                    ->label(static::trans('filters.valid'))
                    ->query(fn (Builder $query) => $query->where('revoked', false)->where('expires_at', '>', now())),
            ])
            ->recordActions([
                Action::make('revoke')
                    ->label(static::trans('actions.revoke.label'))
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(static::trans('actions.revoke.label'))
                    ->action(function (Model|array|null $record): void {
                        if ($record instanceof OauthDeviceCode) {
                            $record->revoked = true;
                            $record->save();
                            Notification::make()
                                ->title(static::trans('actions.revoke.success'))
                                ->success()
                                ->send();
                        }
                    })
                    ->visible(fn (Model|array|null $record) => $record instanceof OauthDeviceCode && ! $record->revoked),
                DeleteAction::make(),
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
            'index' => ListOauthDeviceCodes::route('/'),
            'view' => ViewOauthDeviceCode::route('/{record}'),
        ];
    }

    /**
     * Modify the Eloquent query used to retrieve the records.
     */
    #[\Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'client']);
    }
}
