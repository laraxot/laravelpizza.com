<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use BackedEnum;
use Filament\Panel;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Exception;
use Override;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Enums\SmsDriverEnum;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Notify\Models\MailTemplate;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Notify\Notifications\SmsNotification;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Webmozart\Assert\Assert;

/**
 * @property \Filament\Schemas\Schema $smsForm
 */
class SendSmsPage extends XotBasePage
{
    public null|array $smsData = [];
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-device-phone-mobile';
    protected string $view = 'notify::filament.pages.send-sms';
    protected static null|string $cluster = Test::class;

    /**
     * Get the slug of the page
     *
     * This explicit definition ensures consistent URL generation for acronyms
     */
    public static function getSlug(?Panel $panel = null): string
    {
        return 'send-sms-page';
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
     * @return array<string, \Filament\Forms\Components\TextInput|\Filament\Forms\Components\Select>
     */
    public function getSmsFormSchema(): array
    {
        return [
            'to' => TextInput::make('to')
                ->tel()
                ->required()
                ->helperText(__('notify::sms.fields.to.helper_text')),
            'message' => TextInput::make('message')
                ->required()
                ->maxLength(160)
                ->helperText(__('notify::sms.fields.message.helper_text')),
            'driver' => Select::make('driver')
                ->options(SmsDriverEnum::class)
                ->default(config('sms.default'))
                ->required()
                ->helperText(__('notify::sms.fields.driver.helper_text')),
            'template_slug' => Select::make('template_slug')
                ->options(MailTemplate::all()->pluck('slug', 'slug'))
                ->required(),
        ];
    }

    public function sendSMS(): void
    {
        try {
            $data = $this->smsForm->getState();
            $user = $this->getUser();
            /*
             * Notification::route('sms', $data['to'])
             * ->notify(new SmsNotification($data['message'], [
             * 'driver' => $data['driver']
             * ]));
             */
            $template_slug = $data['template_slug'];
            Assert::string($template_slug, __FILE__ . ':' . __LINE__ . ' - ' . class_basename(__CLASS__));
            $recordNotification = new RecordNotification($user, $template_slug);
            $notify = $recordNotification->mergeData($data);

            Notification::route('sms', $data['to'])
                //->locale('it')
                //->notify(new RecordNotification($user,'due'))
                ->notify($notify);

            

            FilamentNotification::make()
                ->success()
                ->title('SMS inviato con successo')
                ->send();
        } catch (Exception $e) {
            //Log::error('Errore nell\'invio SMS: ' . $e->getMessage());

            FilamentNotification::make()
                ->danger()
                ->title('Errore nell\'invio SMS')
                ->body($e->getMessage())
                ->persistent()
                ->send();
        }
    }

    /**
     * Get the form actions for the SMS form.
     *
     * @return array<Action>
     */
    protected function getSmsFormActions(): array
    {
        return [
            Action::make('send')
                ->label(__('notify::sms.actions.send'))
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->action('sendSMS'),
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
