<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Notify\Notifications\TelegramNotification;
use Modules\Xot\Filament\Pages\XotBasePage;
use Webmozart\Assert\Assert;

class SendTelegram extends XotBasePage
{
    public ?array $emailData = [];

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-paper-airplane';
    protected string $view = 'notify::filament.pages.send-email';
    protected static ?string $cluster = Test::class;

    public function mount(): void
    {
        $this->emailForm->fill();
    }

    public function emailForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('recipient')->required(),
                    RichEditor::make('body')->required(),
                ]),
            ])
            ->model($this->getUser())
            ->statePath('emailData');
    }

    public function sendEmail(): void
    {
        $data = $this->emailForm->getState();
        Assert::string($token = config('services.telegram-bot-api.token'));
        $message = is_string($data['body'] ?? '') ? $data['body'] : '';
        Notification::route('telegram', $data['recipient'])->notify(new TelegramNotification($message));

        FilamentNotification::make()->success()->title(__('Message sent via Telegram'))->send();
    }

    protected function getForms(): array
    {
        return ['emailForm'];
    }

    protected function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();
        if (! ($user instanceof Model)) {
            throw new Exception('User must be Eloquent model');
        }
        return $user;
    }
}
