<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Filament\Panel;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Exception;
use Override;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Notify\Notifications\SmsNotification;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;

/**
 * @property \Filament\Schemas\Schema $smsForm
 */
class SendNetfunSmsPage extends XotBasePage
{
    public null|array $smsData = [];

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-device-phone-mobile';

    protected string $view = 'notify::filament.pages.send-sms';

    protected static null|string $cluster = Test::class;

    /**
     * Get the slug of the page
     *
     * This explicit definition ensures consistent URL generation for acronyms
     */
    public static function getSlug(?Panel $panel = null): string
    {
        return 'send-netfun-sms-page';
    }

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'smsForm',
        ];
    }

    protected function fillForms(): void
    {
        $this->smsForm->fill();
    }

    public function smsForm(Schema $schema): Schema
    {
        return $schema->schema($this->getSmsFormSchema())->model($this->getUser())->statePath('smsData');
    }

    /**
     * @return array<string, \Filament\Forms\Components\TextInput|\Filament\Forms\Components\Textarea|\Filament\Forms\Components\Select>
     */
    public function getSmsFormSchema(): array
    {
        return [
            'to' => TextInput::make('to')
                ->label(__('notify::sms.form.to.label'))
                ->tel()
                ->required()
                ->helperText(__('notify::sms.form.to.helper'))
                ->placeholder('+393401234567'),
            'from' => TextInput::make('from')
                ->label(__('notify::sms.form.from.label'))
                ->default(config('app.name', 'Our Platform'))
                ->required()
                ->maxLength(11)
                ->helperText(__('notify::sms.form.from.helper')),
            'body' => Textarea::make('body')
                ->label(__('notify::sms.form.body.label'))
                ->required()
                ->rows(3)
                ->helperText(__('notify::sms.form.body.helper')),
            'provider' => Select::make('provider')
                ->label(__('notify::sms.form.provider.label'))
                ->options([
                    'netfun' => 'Netfun',
                    'smsfactor' => 'SmsFactory',
                    'twilio' => 'Twilio',
                    'nexmo' => 'Nexmo',
                    'plivo' => 'Plivo',
                    'gammu' => 'Gammu',
                ])
                ->default('netfun')
                ->selectablePlaceholder(false)
                ->required(),
        ];
    }

    public function sendSms(): void
    {
        $data = $this->smsForm->getState();

        $smsData = SmsData::from($data);
        /*
         * $smsData->to = $data['to'];
         * $smsData->from = $data['from'];
         * $smsData->body = $data['body'];
         */
        $provider = $data['provider'] ?? 'netfun';

        try {
            Notification::route('sms', $data['to'])->notify(new SmsNotification($smsData, ['provider' => $provider]));

            FilamentNotification::make()
                ->success()
                ->title(__('notify::sms.notifications.sent.title'))
                ->body(__('notify::sms.notifications.sent.body'))
                ->send();

            Log::info('SMS inviato con successo', [
                'to' => $data['to'],
                'from' => $data['from'],
                'provider' => $provider,
            ]);
        } catch (Exception $e) {
            Log::error('Errore durante l\'invio dell\'SMS', [
                'error' => $e->getMessage(),
                'to' => $data['to'],
                'from' => $data['from'],
                'provider' => $provider,
            ]);

            FilamentNotification::make()
                ->danger()
                ->title(__('notify::sms.notifications.error.title'))
                ->body($e->getMessage())
                ->send();
        }
    }

    protected function getSmsFormActions(): array
    {
        return [
            Action::make('sendSms')->label(__('notify::sms.actions.send'))->submit('sendSms'),
        ];
    }

    #[Override]
    protected function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();

        if (!($user instanceof Model)) {
            throw new Exception(
                'L\'utente autenticato deve essere un modello Eloquent per consentire l\'aggiornamento del profilo.',
            );
        }

        return $user;
    }
}
