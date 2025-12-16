<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Kreait\Firebase\Messaging\MessageData;
use Exception;
use Override;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;
use Modules\Notify\Filament\Clusters\Test;
use Modules\User\Models\DeviceUser;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Webmozart\Assert\Assert;

use function Safe\json_encode;

/**
 * @property \Filament\Schemas\Schema $notificationForm
 */
class SendPushNotificationPage extends XotBasePage
{
    // use NavigationLabelTrait;

    public null|array $notificationData = [];

    // protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-paper-airplane';

    protected string $view = 'notify::filament.pages.send-push-notification';

    protected static null|string $cluster = Test::class;

    public function mount(): void
    {
        $this->fillForms();
    }

    public function notificationForm(Schema $schema): Schema
    {
        $devices = DeviceUser::with(['profile', 'device'])
            ->where('push_notifications_token', '!=', null)
            ->where('push_notifications_token', '!=', 'unknown')
            ->where('push_notifications_enabled', 1)
            // ->whereHas('profile') //db separato percio' da errore cosi'
            ->whereHas('device')
            ->get();

        /**
         * Callback per mappare i dispositivi in opzioni per il select.
         */
        $callback = function ($item) {
            /** @var mixed $item */
            if (!is_object($item)) {
                return [];
            }

            // Relations & attributes (Laravel-safe)
            $profile = method_exists($item, 'getRelationValue') ? $item->getRelationValue('profile') : null;
            if (!is_object($profile)) {
                return [];
            }
            $fullName = (string) (data_get($profile, 'full_name') ?? 'Utente');

            $tokenAttr = method_exists($item, 'getAttribute') ? $item->getAttribute('push_notifications_token') : null;
            $token = is_string($tokenAttr) ? $tokenAttr : '';
            if ($token === '' || $token === 'unknown') {
                return [];
            }

            $device = method_exists($item, 'getRelationValue') ? $item->getRelationValue('device') : null;
            $robotVal = data_get($device, 'robot');
            $robot = is_string($robotVal) ? $robotVal : null;

            // Creiamo la label con gli ultimi 5 caratteri del token
            $tokenSuffix = mb_substr($token, -5);
            $label = $fullName . ' (' . ($robot ?? '') . ') ' . $tokenSuffix;

            return [$token => $label];
        };

        /**
         * Callback per filtrare i dispositivi.
         */
        $filterCallback = function ($item): bool {
            if (!is_object($item)) {
                return false;
            }
            $profile = method_exists($item, 'getRelationValue') ? $item->getRelationValue('profile') : null;
            return is_object($profile);
        };

        $to = $devices->filter($filterCallback)->mapWithKeys($callback)->toArray();

        Assert::isArray($to);

        return $schema
            ->components([
                Select::make('deviceToken')->options(fn() => $to),
                TextInput::make('type')->required(),
                TextInput::make('title')->required(),
                TextInput::make('body')->required(),
                Repeater::make('data')->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('value')->required(),
                ]),
            ])
            // ->model($this->getUser())
            ->statePath('notificationData');
    }

    public function sendNotification(): void
    {
        $data = $this->notificationForm->getState();
        $deviceToken = $data['deviceToken'] ?? '';

        // Verifichiamo che deviceToken sia una stringa non vuota
        if ($deviceToken === '') {
            Notification::make()
                ->danger()
                ->title('Errore')
                ->body('Token del dispositivo non valido')
                ->send();
            return;
        }

        // Verifichiamo che i dati siano del tipo corretto
        $type = $data['type'] ?? '';
        $title = $data['title'] ?? '';
        $body = $data['body'] ?? '';
        $jsonData = isset($data['data']) ? json_encode($data['data']) : '{}';

        // Verifichiamo che jsonData sia una stringa
        $jsonData = $jsonData ?: '{}';

        // Creiamo un array con chiavi non vuote e valori stringa che implementano Stringable
        $pushDataTemp = [];

        // Aggiungiamo i valori all'array solo se non sono vuoti
        // PHPStan sa che queste stringhe non possono essere vuote a questo punto
        $pushDataTemp['type'] = $type;
        $pushDataTemp['title'] = $title;
        $pushDataTemp['body'] = $body;
        // Adding data field (we know jsonData can't be empty due to fallback to '{}' earlier)
        $pushDataTemp['data'] = $jsonData;

        // Verifichiamo che l'array contenga almeno un elemento
        if (count($pushDataTemp) === 0) {
            $pushDataTemp['type'] = 'notification';
        }

        // Creiamo un MessageData object
        // Convertiamo tutti i valori in stringa come richiesto da MessageData
        $sanitizedData = [];
        foreach ($pushDataTemp as $key => $value) {
            // All keys are non-empty strings by this point
            if (is_scalar($value) || is_null($value)) {
                $sanitizedData[$key] = is_string($value) ? $value : ((string) $value);
            } else {
                // Handle non-scalar values (arrays, objects) by converting to JSON
                $sanitizedData[$key] = (string) json_encode($value);
            }
        }
        $messageData = MessageData::fromArray($sanitizedData);

        // Verifichiamo che deviceToken sia una stringa non vuota (per soddisfare il tipo non-empty-string)
        Assert::stringNotEmpty($deviceToken, 'Il token del dispositivo non può essere vuoto');

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withHighestPossiblePriority()
            ->withData($messageData);

        try {
            // Otteniamo l'istanza di messaging e verifichiamo che sia valida
            /** @var Messaging $messaging */
            $messaging = app('firebase.messaging');
            Assert::isInstanceOf($messaging, Messaging::class, 'Invalid messaging instance');

            $messaging->send($message);
        } catch (Exception $e) {
            dddx([
                'message' => $e->getMessage(),
                'deviceToken' => $deviceToken,
            ]);
        }

        Notification::make()
            ->success()
            // ->title(__('filament-panels::pages/auth/edit-profile.notifications.saved.title'))
            ->title(__('check your client'))
            ->send();
    }

    protected function getForms(): array
    {
        return [
            'notificationForm',
        ];
    }

    protected function getNotificationFormActions(): array
    {
        return [
            Action::make('notificationFormActions')
                

                ->submit('notificationFormActions'),
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

    protected function fillForms(): void
    {
        // $data = $this->getUser()->attributesToArray();

        // $this->editProfileForm->fill($data);
        $this->notificationForm->fill();
    }
}
