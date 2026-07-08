<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Services\TenantService;
use Modules\User\Datas\PasswordData;
use Modules\Xot\Filament\Pages\XotBasePage;

/**
 * Pagina per la gestione delle impostazioni delle password.
 *
 * @property Schema $form
 */
class Password extends XotBasePage
{
    /**
     * Dati del form per la gestione delle password.
     *
     * @var array<string, mixed>|null
     */
    public ?array $formData = [];

    /**
     * Vista per la pagina.
     */
    protected string $view = 'user::filament.pages.password';

    /**
     * Inizializza la pagina.
     */
    public function mount(): void
    {
        $this->fillForms();
    }

    /**
     * Definisce la struttura dello schema.
     *
     * @param Schema $schema Lo schema da configurare
     *
     * @return Schema Lo schema configurato
     */
    public function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('otp_expiration_minutes')
                    // Durata in minuti della validità della password temporanea
                    ->numeric()
                    ->helperText(static::trans('fields.otp_expiration_minutes.help'))
                    ->default(60),
                TextInput::make('otp_length')
                    // Lunghezza del codice OTP
                    ->helperText(static::trans('fields.otp_length.help'))
                    ->numeric(),
                TextInput::make('expires_in')->helperText(static::trans('fields.expires_in.help'))->numeric(), // The number of days before the password expires.
                TextInput::make('min')->helperText(static::trans('fields.min.help'))->numeric(), // = 6; // The minimum size of the password.
                Toggle::make('mixedCase')->helperText(static::trans('fields.mixedCase.help')), // = false; // If the password requires at least one uppercase and one lowercase letter.
                Toggle::make('letters')->helperText(static::trans('fields.letters.help')), // = false; // If the password requires at least one letter.
                Toggle::make('numbers')->helperText(static::trans('fields.numbers.help')), // = false; // If the password requires at least one number.
                Toggle::make('symbols')->helperText(static::trans('fields.symbols.help')), // = false; // If the password requires at least one symbol.
                Toggle::make('uncompromised')->helperText(static::trans('fields.uncompromised.help')), // = false; // If the password should not have been compromised in data leaks.
                TextInput::make('compromisedThreshold')
                    ->helperText(static::trans('fields.compromisedThreshold.help'))
                    ->numeric(), // = 1; // The number of times a password can appear in data leaks before being considered compromised.
            ])
            ->columns(3)
            // ->model($this->getUser())
            ->statePath('formData');
    }

    /**
     * Aggiorna i dati delle impostazioni delle password.
     */
    public function updateData(): void
    {
        try {
            /** @var array<string, mixed> $data */
            $data = $this->form->getState();
            TenantService::saveConfig('password', $data);

            // $this->handleRecordUpdate($this->getUser(), $data);
        } catch (Halt $exception) {
            dddx($exception->getMessage());

            return;
        }
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }

    /**
     * Riempie i form con i dati esistenti.
     */
    protected function fillForms(): void
    {
        /** @var array<string, mixed> $data */
        $data = PasswordData::make()->toArray();

        $this->form->fill($data);
    }

    /**
     * Restituisce le azioni per il form di aggiornamento.
     *
     * @return array<Action>
     */
    protected function getUpdateFormActions(): array
    {
        return [
            Action::make('updateDataAction')->submit('editDataForm'),
        ];
    }

    /**
     * Gestisce l'aggiornamento del record.
     *
     * @param Model                $record Il record da aggiornare
     * @param array<string, mixed> $data   I dati per l'aggiornamento
     *
     * @return Model Il record aggiornato
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        return $record;
    }
}
