<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\User\Models\OauthClient;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class ClientsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'clients';

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * @return array<string, Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * @return array<string, Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')
                ->label('Nome'),
            'id' => TextColumn::make('id')
                ->label('Client ID')
                ->copyable()
                ->copyMessage('Client ID copiato')
                ->copyMessageDuration(1500),
            'secret' => TextColumn::make('secret')
                ->label('Client Secret')
                ->formatStateUsing(static fn (): string => 'Mostrato solo alla creazione')
                ->tooltip('Il secret viene cifrato e non è più recuperabile: copia quello in chiaro al momento della creazione.'),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[\Override]
    public function getTableHeaderActions(): array
    {
        /** @var array<string, Action> $actions */
        $actions = parent::getTableHeaderActions();

        $actions['associateExistingClient'] = Action::make('associateExistingClient')
            ->label('Associa client esistente')
            ->icon('heroicon-o-link')
            ->schema([
                Select::make('client_id')
                    ->label('Client')
                    ->searchable()
                    ->required()
                    ->getSearchResultsUsing(static function (string $search): array {
                        return OauthClient::query()
                            ->whereNull('owner_id')
                            ->whereNull('owner_type')
                            ->where('name', 'like', "%{$search}%")
                            ->limit(25)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->getOptionLabelUsing(static function (?string $value): ?string {
                        if ($value === null) {
                            return null;
                        }

                        /** @var OauthClient|null $client */
                        $client = OauthClient::query()->find($value);

                        return $client?->name;
                    }),
            ])
            ->action(function (array $data): void {
                $ownerRecord = $this->getOwnerRecord();

                if (! $ownerRecord instanceof AuthUser) {
                    Notification::make()
                        ->title('Utente non valido per l\'associazione del client.')
                        ->danger()
                        ->send();

                    return;
                }

                /** @var AuthUser $owner */
                $owner = $ownerRecord;
                $clientId = $data['client_id'] ?? null;
                /** @var OauthClient|null $client */
                $client = $clientId !== null ? OauthClient::query()->find($clientId) : null;

                if ($client === null) {
                    Notification::make()
                        ->title('Client non trovato.')
                        ->danger()
                        ->send();

                    return;
                }

                $client->forceFill([
                    'user_id' => $owner->getKey(),
                ]);
                $client->save();

                Notification::make()
                    ->title('Client associato all\'utente.')
                    ->success()
                    ->send();
            });

        return $actions;
    }
}
