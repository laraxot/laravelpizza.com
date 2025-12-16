<?php

/**
 * @see https://medium.com/modulr/send-telegram-notifications-with-laravel-9-342cc87b406
 * @see https://laravel-notification-channels.com/telegram/#usage
 */

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Datas\TelegramData;
use Modules\Notify\Datas\TelegramMessageData;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Notify\Notifications\TelegramNotification;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use NotificationChannels\Telegram\TelegramMessage;
use Telegram\Bot\Laravel\Facades\Telegram;
use Webmozart\Assert\Assert;

/**
 * @property \Filament\Schemas\Schema $telegramForm
 */
class SendTelegramPage extends XotBasePage implements HasForms
{
    use InteractsWithForms;

    // use NavigationLabelTrait;

    public null|array $telegramData = [];

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-paper-airplane';

    protected string $view = 'notify::filament.pages.send-telegram';

    protected static null|string $cluster = Test::class;

    public function mount(): void
    {
        $this->fillForms();
    }

    public function telegramForm(Schema $schema): Schema
    {
        return $schema->schema($this->getTelegramFormSchema())->model($this->getUser())->statePath('telegramData');
    }

    /**
     * @return array<string, \Filament\Forms\Components\Select|\Filament\Forms\Components\TextInput|\Filament\Forms\Components\Toggle>
     */
    public function getTelegramFormSchema(): array
    {
        return [
            'chat_id' => TextInput::make('chat_id')->required()->helperText('ID della chat o username del canale'),
            'text' => TextInput::make('text')
                ->required()
                ->maxLength(4096)
                ->helperText('Il messaggio non può superare i 4096 caratteri'),
            'driver' => Select::make('driver')
                ->options([
                    'bot' => 'Bot API',
                    'webhook' => 'Webhook',
                ])
                ->default('bot')
                ->required(),
            'parse_mode' => Select::make('parse_mode')
                ->options([
                    'HTML' => 'HTML',
                    'Markdown' => 'Markdown',
                    'MarkdownV2' => 'MarkdownV2',
                ])
                ->helperText('Formato del testo (opzionale)'),
            'disable_web_page_preview' => Toggle::make('disable_web_page_preview')->helperText('Disabilita l\'anteprima dei link'),
            'disable_notification' => Toggle::make('disable_notification')->helperText('Invia il messaggio silenziosamente'),
            'reply_to_message_id' => TextInput::make('reply_to_message_id')
                ->numeric()
                ->helperText('ID del messaggio a cui rispondere'),
            'media_url' => TextInput::make('media_url')->url()->helperText('URL del media (opzionale)'),
            'media_type' => Select::make('media_type')
                ->options([
                    'photo' => 'Foto',
                    'video' => 'Video',
                    'document' => 'Documento',
                    'audio' => 'Audio',
                ])
                ->helperText('Tipo di media (opzionale)'),
            'caption' => TextInput::make('caption')->helperText('Didascalia per il media (opzionale)'),
        ];
    }

    public function sendTelegram(): void
    {
        try {
            $data = $this->telegramForm->getState();
            $user = $this->getUser();

            $message = is_string($data['text']) ? $data['text'] : '';

            Notification::route('telegram', $data['chat_id'])->notify(
                new TelegramNotification($message, [
                    'driver' => $data['driver'],
                    'parse_mode' => $data['parse_mode'] ?? null,
                    'disable_web_page_preview' => $data['disable_web_page_preview'] ?? false,
                    'disable_notification' => $data['disable_notification'] ?? false,
                    'reply_to_message_id' => $data['reply_to_message_id'] ?? null,
                    'media_url' => $data['media_url'] ?? null,
                    'media_type' => $data['media_type'] ?? null,
                    'caption' => $data['caption'] ?? null,
                ]),
            );

            FilamentNotification::make()
                ->success()
                ->title('Messaggio Telegram inviato con successo')
                ->send();
        } catch (Exception $e) {
            Log::error('Errore nell\'invio Telegram: ' . $e->getMessage());

            FilamentNotification::make()
                ->danger()
                ->title('Errore nell\'invio Telegram')
                ->body($e->getMessage())
                ->send();
        }
    }

    protected function getForms(): array
    {
        return [
            'telegramForm',
        ];
    }

    protected function getTelegramFormActions(): array
    {
        return [
            Action::make('telegramFormActions')->submit('telegramFormActions'),
        ];
    }

    protected function fillForms(): void
    {
        // $data = $this->getUser()->attributesToArray();

        // $this->editProfileForm->fill($data);
        $this->telegramForm->fill();
    }
}
