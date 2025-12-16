<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Override;
use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Datas\EmailData;
use Modules\Notify\Emails\EmailDataEmail;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Webmozart\Assert\Assert;

/**
 * @property \Filament\Schemas\Schema $emailForm
 */
class SendSpatieEmailPage extends XotBasePage
{
    public null|array $emailData = [];
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-paper-airplane';
    protected string $view = 'notify::filament.pages.send-email';
    protected static null|string $cluster = Test::class;

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'emailForm',
        ];
    }

    protected function fillForms(): void
    {
        // $data = $this->getUser()->attributesToArray();

        // $this->editProfileForm->fill($data);
        $this->emailForm->fill();
    }

    public function emailForm(Schema $schema): Schema
    {
        return $schema->schema($this->getEmailFormSchema())->model($this->getUser())->statePath('emailData');
    }

    /**
     * @return array<string, \Filament\Forms\Components\TextInput|\Filament\Forms\Components\Select|\Filament\Forms\Components\RichEditor>
     */
    public function getEmailFormSchema(): array
    {
        return [
            'to' => TextInput::make('to')->email()->required(),
            /*
             * 'subject' => Forms\Components\TextInput::make('subject')
             * ->required(),
             */
            'mail_template_slug' => Select::make('mail_template_slug')
                ->options(MailTemplate::all()->pluck('slug', 'slug'))
                ->required(),
            'body_html' => RichEditor::make('body_html')->required(),
        ];
    }

    public function sendEmail(): void
    {
        $data = $this->emailForm->getState();
        /*
         * $email_data = EmailData::from($data);
         *
         * Mail::to($data['to'])->send(
         * new EmailDataEmail($email_data)
         * );
         *
         *
         */
        $user = $this->getUser();
        $attachments = [
            [
                'path' => public_path('images/avatars/default-3.svg'),
                'as' => 'logo.png',
                'mime' => 'image/png',
            ],
            [
                'path' => public_path('images/avatars/default-3.svg'),
                'as' => 'logo.png',
                'mime' => 'image/png',
            ],
        ];
        //Mail::to($data['to'])->locale('it')->send((new SpatieEmail($user,'due'))->addAttachments($attachments));
        /*
         * // Create and send the email
         * $email = new SpatieEmail($user, 'uno');
         * $email->addAttachments($attachments);
         *
         * Mail::to($data['to'])
         * ->locale('it')
         * ->send($email);
         */
        $mail_template_slug = $data['mail_template_slug'];
        Assert::string($mail_template_slug, __FILE__ . ':' . __LINE__ . ' - ' . class_basename(__CLASS__));
        $recordNotification = new RecordNotification($user, $mail_template_slug);
        $notify = $recordNotification->mergeData($data);

        Notification::route('mail', $data['to'])
            //->locale('it')
            ->notify($notify);

        FilamentNotification::make()
            ->success()
            // ->title(__('filament-panels::pages/auth/edit-profile.notifications.saved.title'))
            ->title(__('check your email client'))
            ->send();
    }

    protected function getEmailFormActions(): array
    {
        return [
            Action::make('emailFormActions')->submit('emailFormActions'),
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
