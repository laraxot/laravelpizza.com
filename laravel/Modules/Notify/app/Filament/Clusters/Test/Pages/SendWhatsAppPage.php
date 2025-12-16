<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use BackedEnum;
use Filament\Panel;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
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
use Modules\Notify\Datas\WhatsAppData;
use Modules\Notify\Enums\WhatsAppDriverEnum;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Notify\Notifications\WhatsAppNotification;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;

/**
 * @property \Filament\Schemas\Schema $whatsappForm
 */
class SendWhatsAppPage extends XotBasePage
{
    public null|array $whatsappData = [];
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected string $view = 'notify::filament.pages.send-whatsapp';
    protected static null|string $cluster = Test::class;

    /**
     * Get the slug of the page
     *
     * This explicit definition ensures consistent URL generation for acronyms
     */
    public static function getSlug(?Panel $panel = null): string
    {
        return 'send-whatsapp-page';
    }

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'whatsappForm',
        ];
    }

    protected function fillForms(): void
    {
        $this->whatsappForm->fill();
    }

    public function whatsappForm(Schema $schema): Schema
    {
        return $schema->schema($this->getWhatsAppFormSchema())->model($this->getUser())->statePath('whatsappData');
    }

    /**
     * @return array<string, \Filament\Forms\Components\KeyValue|\Filament\Forms\Components\Select|\Filament\Forms\Components\TextInput>
     */
    public function getWhatsAppFormSchema(): array
    {
        return [
            'to' => TextInput::make('to')
                ->tel()
                ->required()
                ->helperText('Inserisci il numero di telefono con prefisso internazionale (es. +39)'),
            'message' => TextInput::make('message')
                ->required()
                ->maxLength(4096)
                ->helperText('Il messaggio non può superare i 4096 caratteri'),
            'driver' => Select::make('driver')
                ->options(WhatsAppDriverEnum::options())
                ->default(WhatsAppDriverEnum::getDefault()->value)
                ->required()
                ->helperText(__('notify::whatsapp.fields.driver.helper_text')),
            'template' => TextInput::make('template')->helperText('Nome del template (opzionale)'),
            'parameters' => KeyValue::make('parameters')->helperText('Parametri per il template (opzionale)'),
            'media_url' => TextInput::make('media_url')->url()->helperText('URL del media (opzionale)'),
            'media_type' => Select::make('media_type')
                ->options([
                    'image' => 'Immagine',
                    'video' => 'Video',
                    'document' => 'Documento',
                    'audio' => 'Audio',
                ])
                ->helperText('Tipo di media (opzionale)'),
        ];
    }

    public function sendWhatsApp(): void
    {
        try {
            $data = $this->whatsappForm->getState();
            $user = $this->getUser();

            $message = is_string($data['message']) ? $data['message'] : '';

            Notification::route('whatsapp', $data['to'])->notify(
                new WhatsAppNotification($message, [
                    'driver' => $data['driver'],
                    'template' => $data['template'] ?? null,
                    'parameters' => $data['parameters'] ?? null,
                    'media_url' => $data['media_url'] ?? null,
                    'media_type' => $data['media_type'] ?? null,
                ]),
            );

            FilamentNotification::make()
                ->success()
                ->title('Messaggio WhatsApp inviato con successo')
                ->send();
        } catch (Exception $e) {
            Log::error('Errore nell\'invio WhatsApp: ' . $e->getMessage());

            FilamentNotification::make()
                ->danger()
                ->title('Errore nell\'invio WhatsApp')
                ->body($e->getMessage())
                ->send();
        }
    }

    protected function getWhatsAppFormActions(): array
    {
        return [
            Action::make('whatsappFormActions')->submit('whatsappFormActions'),
        ];
    }

    #[Override]
    protected function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();

        if (!($user instanceof Model)) {
            throw new Exception(
                'The authenticated user object must be an Eloquent model to allow the profile page to update it.',
            );
        }

        return $user;
    }
}
