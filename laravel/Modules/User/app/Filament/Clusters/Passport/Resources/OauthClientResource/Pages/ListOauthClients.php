<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Modules\User\Actions\Passport\CreateClientAction;
use Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListOauthClients extends XotBaseListRecords
{
    protected static string $resource = OauthClientResource::class;

    /**
     * @return array<string, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'create_personal_access_client' => Action::make('create_personal_access_client')
                ->label(static::trans('actions.create_personal.label'))
                ->icon('heroicon-o-key')
                ->form([
                    TextInput::make('name')
                        ->default((string) config('app.name').' '.static::trans('actions.create_personal.label'))
                        ->required()
                        ->maxLength(255),
                ])
                ->action(function (array $data) {
                    app(CreateClientAction::class)->execute(
                        name: (string) $data['name'],
                        redirect: (string) config('app.url'),
                        personalAccess: true,
                    );
                    Notification::make()
                        ->title(static::trans('actions.create_personal.success'))
                        ->success()
                        ->send();
                }),

            'create_password_grant_client' => Action::make('create_password_grant_client')
                ->label(static::trans('actions.create_password.label'))
                ->icon('heroicon-o-lock-closed')
                ->form([
                    TextInput::make('name')
                        ->default((string) config('app.name').' '.static::trans('actions.create_password.label'))
                        ->required()
                        ->maxLength(255),
                    TextInput::make('provider')
                        ->default('users')
                        ->required()
                        ->maxLength(255),
                ])
                ->action(function (array $data) {
                    app(CreateClientAction::class)->execute(
                        name: (string) $data['name'],
                        redirect: (string) config('app.url'),
                        password: true,
                        provider: (string) $data['provider'],
                    );
                    Notification::make()
                        ->title(static::trans('actions.create_password.success'))
                        ->success()
                        ->send();
                }),

            'create_client_credentials_client' => Action::make('create_client_credentials_client')
                ->label(static::trans('actions.create_client_credentials.label'))
                ->icon('heroicon-o-server')
                ->form([
                    TextInput::make('name')
                        ->default((string) config('app.name').' '.static::trans('actions.create_client_credentials.label'))
                        ->required()
                        ->maxLength(255),
                ])
                ->action(function (array $data) {
                    app(CreateClientAction::class)->execute(
                        name: (string) $data['name'],
                        redirect: (string) config('app.url'),
                    );
                    Notification::make()
                        ->title(static::trans('actions.create_client_credentials.success'))
                        ->success()
                        ->send();
                }),
        ];
    }
}
