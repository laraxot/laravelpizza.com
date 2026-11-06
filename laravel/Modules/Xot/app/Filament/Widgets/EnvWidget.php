<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Arr;
use Modules\Xot\Datas\EnvData;
use Modules\Xot\Filament\Traits\SuperAdminOnlyTrait;

class EnvWidget extends XotBaseSchemaWidget
{
    use SuperAdminOnlyTrait;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    /** @var list<string> */
    public array $only = [];

    /** @var view-string */
    protected string $view = 'xot::filament.widgets.env';

    /**
     * Raggruppamento visivo dei campi per Section, stile Laravel — un
     * campo non elencato qui compare comunque (fuori da qualunque Section,
     * in coda), non sparisce mai in silenzio se qualcuno lo aggiunge a
     * getFormSchema() senza aggiornare questa mappa.
     *
     * @var array<string, list<string>>
     */
    private const array GROUPS = [
        'General' => ['app_url', 'debugbar_enabled', 'google_maps_api_key', 'telegram_bot_token'],
        'SMS' => ['sms_driver', 'netfun_token'],
        'Mail' => ['mail_mailer', 'mail_host', 'mail_port', 'mail_encryption', 'mail_username', 'mail_password', 'mail_from_address', 'mail_from_name'],
    ];

    public function mount(): void
    {
        /** @var array<string, mixed> */
        $data = EnvData::make()->toArray();
        $this->data = $data;

        $this->form->fill($this->data);
    }

    public static function canView(): bool
    {
        return static::canAccess();
    }

    public function submit(): void
    {
        abort_unless(static::canAccess(), 403);

        try {
            // getState(), non $this->data: lo stato Livewire è modificabile dal client, il form no.
            EnvData::make()->update($this->form->getState());
        } catch (\InvalidArgumentException $e) {
            Notification::make()
                ->title($e->getMessage())
                ->danger()
                ->send();

            return;
        }
        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();

        /*
         * dddx([
         * 'data' => $this->data,
         * // 'data1' => $this->form->getState(),
         * ]);
         */
    }

    /**
     * @return array<Component>
     */
    public function getFormSchema(): array
    {
        // Nessun ->label()/->placeholder()/->helperText() qui: Modules\Lang
        // (LangServiceProvider::registerFilamentLabel(), Field::configureUsing())
        // li risolve automaticamente da Modules/Xot/lang/{locale}/env.php,
        // chiave fields.<nome-campo>.<label|placeholder|helper_text> — verificato
        // dal vivo (non assunto): il primo caricamento di questa pagina scrive da
        // solo le voci mancanti in quel file. ->options() resta qui perché non è
        // gestito da quel meccanismo (sono valori di dominio, non testo UI).
        $all = [
            'app_url' => TextInput::make('app_url')->required(),
            'debugbar_enabled' => Toggle::make('debugbar_enabled'),
            'google_maps_api_key' => TextInput::make('google_maps_api_key'),
            'telegram_bot_token' => TextInput::make('telegram_bot_token'),
            'sms_driver' => Select::make('sms_driver')
                ->options([
                    'smsfactor' => 'SMSFactor',
                    'netfun' => 'Netfun',
                    'twilio' => 'Twilio',
                    'nexmo' => 'Nexmo (Vonage)',
                    'plivo' => 'Plivo',
                    'gammu' => 'Gammu',
                    'agiletelecom' => 'Agile Telecom',
                ]),
            'netfun_token' => TextInput::make('netfun_token'),
            'mail_mailer' => Select::make('mail_mailer')
                ->options([
                    'smtp' => 'SMTP',
                    'ses' => 'Amazon SES',
                    'postmark' => 'Postmark',
                    'resend' => 'Resend',
                    'sendmail' => 'Sendmail',
                    'log' => 'Log (nessun invio reale)',
                ]),
            'mail_host' => TextInput::make('mail_host'),
            'mail_port' => TextInput::make('mail_port'),
            'mail_encryption' => Select::make('mail_encryption')
                ->options([
                    '' => 'Nessuna',
                    'tls' => 'TLS',
                    'ssl' => 'SSL',
                ]),
            'mail_username' => TextInput::make('mail_username'),
            'mail_password' => TextInput::make('mail_password'),
            'mail_from_address' => TextInput::make('mail_from_address'),
            'mail_from_name' => TextInput::make('mail_from_name'),
        ];
        /** @var array<string, Component> $selected */
        $selected = $this->only === [] ? $all : Arr::only($all, $this->only);

        $grouped = [];
        $components = [];
        foreach (self::GROUPS as $label => $keys) {
            /** @var list<Component> $fields */
            $fields = [];
            foreach ($keys as $key) {
                if (isset($selected[$key])) {
                    $fields[] = $selected[$key];
                    $grouped[$key] = true;
                }
            }
            if ($fields === []) {
                continue;
            }
            $components[] = Section::make($label)->schema($fields);
        }

        // Campi selezionati ma non presenti in nessun gruppo di GROUPS
        // (es. un nuovo campo aggiunto a $all senza aggiornare la mappa):
        // restano visibili, fuori da qualunque Section, invece di sparire.
        foreach ($selected as $key => $field) {
            if (! isset($grouped[$key])) {
                $components[] = $field;
            }
        }

        return $components;
    }
}
