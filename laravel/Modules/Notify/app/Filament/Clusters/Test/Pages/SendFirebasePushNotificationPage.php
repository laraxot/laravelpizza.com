<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Datas\FirebaseNotificationData;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Traits\SuperAdminOnlyTrait;

/**
 * @property Schema $pushForm
 */
class SendFirebasePushNotificationPage extends XotBasePage
{
    use SuperAdminOnlyTrait;

    /** @var array<string, mixed>|null */
    public ?array $pushData = [];

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-bell-alert';

    protected string $view = 'notify::filament.pages.send-push';

    protected static ?string $cluster = Test::class;

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'pushForm'];
    }

    protected function fillForms(): void
    {
        $this->pushForm->fill();
    }

    public function pushForm(Schema $schema): Schema
    {
        return $schema->components($this->getPushFormSchema())->model($this->getUser())->statePath('pushData');
    }

    /**
     * @return array<string, TextInput|Textarea|Select|Toggle|KeyValue>
     */
    public function getPushFormSchema(): array
    {
        return [
            'token' => TextInput::make('token')
                ->label(__('notify::push.form.token.label'))
                ->required()
                ->helperText(__('notify::push.form.token.helper')),
            'title' => TextInput::make('title')
                ->label(__('notify::push.form.title.label'))
                ->required()
                ->maxLength(100),
            'body' => Textarea::make('body')
                ->label(__('notify::push.form.body.label'))
                ->required()
                ->rows(3),
            'image_url' => TextInput::make('image_url')
                ->label(__('notify::push.form.image_url.label'))
                ->url()
                ->helperText(__('notify::push.form.image_url.helper')),
            'notification_type' => Select::make('notification_type')
                ->label(__('notify::push.form.notification_type.label'))
                ->options([
                    'message' => 'Message',
                    'alert' => 'Alert',
                    'reminder' => 'Reminder',
                    'update' => 'Update'])
                ->default('message')
                ->required(),
            'high_priority' => Toggle::make('high_priority')
                ->label(__('notify::push.form.high_priority.label'))
                ->default(false)
                ->helperText(__('notify::push.form.high_priority.helper')),
            'custom_data' => KeyValue::make('custom_data')
                ->label(__('notify::push.form.custom_data.label'))
                ->keyLabel(__('notify::push.form.custom_data.key_label'))
                ->valueLabel(__('notify::push.form.custom_data.value_label'))
                ->helperText(__('notify::push.form.custom_data.helper'))];
    }

    public function sendPushNotification(): void
    {
        abort_unless(static::canAccess(), 403);

        $data = $this->pushForm->getState();

        try {
            // TODO: Implementare PushNotification class
            // Inviare la notifica push
            // Notification::route('firebase', $data['token'])
            //     ->notify(new PushNotification($notificationData));

            // Notificare il successo
            FilamentNotification::make()
                ->success()
                ->title(__('notify::push.notifications.sent.title'))
                ->body(__('notify::push.notifications.sent.body'))
                ->send();

            // Loggare l'invio
            Log::debug('Notifica push inviata con successo', [
                'token' => $data['token'],
                'title' => $data['title'],
                'type' => $data['notification_type']]);
        } catch (Exception $e) {
            // Loggare l'errore
            Log::error('Errore durante l\'invio della notifica push', [
                'error' => $e->getMessage(),
                'token' => $data['token']]);

            // Notificare l'errore
            FilamentNotification::make()
                ->danger()
                ->title(__('notify::push.notifications.error.title'))
                ->body($e->getMessage())
                ->send();
        }
    }

    /**
     * FCM accetta solo coppie chiave non vuota => stringa: il tipo viaggia come chiave `type`.
     *
     * @return array<non-empty-string, string>
     */
    protected function getMessageData(FirebaseNotificationData $notificationData): array
    {
        $messageData = ['type' => $notificationData->type];

        foreach ($notificationData->data as $key => $value) {
            if ($key !== '') {
                $messageData[$key] = SafeStringCastAction::cast($value);
            }
        }

        return $messageData;
    }

    /** @return array<string, Action> */
    protected function getPushFormActions(): array
    {
        return [
            'submit' => Action::make('sendPushNotification')
                ->label(__('notify::push.actions.send'))
                ->submit('sendPushNotification')];
    }

    protected function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();

        if (! ($user instanceof Model)) {
            throw new Exception(
                'L\'utente autenticato deve essere un modello Eloquent per consentire l\'aggiornamento del profilo.',
            );
        }

        return $user;
    }
}
