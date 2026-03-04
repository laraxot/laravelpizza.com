<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\OauthClientResource\Pages;

use Filament\Actions\Action;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\User\Actions\Passport\RevokeClientAction;
use Modules\User\Filament\Resources\OauthClientResource;
use Modules\User\Models\OauthClient;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

/**
 * View OAuth Client page.
 */
class ViewOauthClient extends XotBaseViewRecord
{
    protected static string $resource = OauthClientResource::class;

    /**
     * Get the header actions.
     *
     * @return array<string, Action|\Filament\Actions\ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        $actions = parent::getHeaderActions();

        /** @var OauthClient|null $record */
        $record = $this->record;

        if ($record !== null && ! $record->revoked) {
            $actions['revoke'] = Action::make('revoke')
                ->label(__('user::actions.oauth.revoke_client.label'))
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading(__('user::actions.oauth.revoke_client.modal.heading'))
                ->modalDescription(__('user::actions.oauth.revoke_client.modal.description'))
                ->modalSubmitActionLabel(__('user::actions.oauth.revoke_client.modal.confirm'))
                ->action(function (): void {
                    /** @var OauthClient $record */
                    $record = $this->record;
                    app(RevokeClientAction::class)->execute($record, true);
                    $this->redirect(OauthClientResource::getUrl('index'));
                })
                ->successNotificationTitle(__('user::actions.oauth.revoke_client.success'));
        }

        return $actions;
    }

    /**
     * Schema dell'infolist per la visualizzazione dei dettagli.
     *
     * @return array<string, Component>
     */
    protected function getInfolistSchema(): array
    {
        return [
            'oauth_info' => XotBaseSection::make('OAuth Client Information')
                ->schema([
                    'name' => TextEntry::make('name'),
                    'user' => TextEntry::make('user.name'),
                    'redirect' => TextEntry::make('redirect'),
                    'provider' => TextEntry::make('provider'),
                    'personal_access_client' => IconEntry::make('personal_access_client')
                        ->boolean(),
                    'password_client' => IconEntry::make('password_client')
                        ->boolean(),
                    'created_at' => TextEntry::make('created_at')
                        ->dateTime(),
                ]),
        ];
    }
}
