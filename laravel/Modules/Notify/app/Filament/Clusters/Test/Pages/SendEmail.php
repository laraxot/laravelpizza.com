<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Modules\Notify\Datas\EmailData;
use Modules\Notify\Emails\EmailDataEmail;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;

class SendEmail extends XotBasePage
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
                    TextInput::make('recipient')->email()->required(),
                    TextInput::make('subject')->required(),
                    RichEditor::make('body_html')->required(),
                ]),
            ])
            ->model($this->getUser())
            ->statePath('emailData');
    }

    public function sendEmail(): void
    {
        $data = $this->emailForm->getState();
        $email_data = EmailData::from($data);
        Mail::to($data['recipient'])->send(new EmailDataEmail($email_data));

        Notification::make()->success()->title(__('check your email client'))->send();
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
