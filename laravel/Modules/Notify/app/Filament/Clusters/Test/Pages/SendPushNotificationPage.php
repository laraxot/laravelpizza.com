<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
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

    public ?array $notificationData = [];

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-paper-airplane';

    protected string $view = 'notify::filament.pages.send-push-notification';

    protected static ?string $cluster = Test::class;

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
            ->whereHas('device')
            ->get();

        $callback = function ($item) {
            /** @var mixed $item */
            if (! is_object($item)) {
                return [];
            }

            $profile = method_exists($item, 'getRelationValue') ? $item->getRelationValue('profile') : null;
            if (! is_object($profile)) {
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

            $tokenSuffix = mb_substr($token, -5);
            $label = $fullName.' ('.($robot ?? '').') '.$tokenSuffix;

            return [$token => $label];
        };

        $filterCallback = function ($item): bool {
            if (! is_object($item)) {
                return false;
            }
            $profile = method_exists($item, 'getRelationValue') ? $item->getRelationValue('profile') : null;

            return is_object($profile);
        };

        $to = $devices->filter($filterCallback)->mapWithKeys($callback)->toArray();

        Assert::isArray($to);

        return $schema
            ->components([
                Select::make('deviceToken')->options(fn () => $to),
                TextInput::make('type')->required(),
                TextInput::make('title')->required(),
                TextInput::make('body')->required(),
                Repeater::make('data')->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('value')->required(),
                ]),
            ])
            ->statePath('notificationData');
    }

    public function sendNotification(): void
    {
        if (
            ! class_exists('Kreait\\Firebase\\Messaging\\CloudMessage')
            || ! class_exists('Kreait\\Firebase\\Messaging\\MessageData')
        ) {
            Notification::make()
                ->danger()
                ->title('Firebase SDK non disponibile')
                ->body('Installa le dipendenze Firebase per inviare push notification.')
                ->send();

            return;
        }

        $data = $this->notificationForm->getState();
        $deviceToken = $data['deviceToken'] ?? '';

        if ($deviceToken === '') {
            Notification::make()
                ->danger()
                ->title('Errore')
                ->body('Token del dispositivo non valido')
                ->send();

            return;
        }

        $type = $data['type'] ?? '';
        $title = $data['title'] ?? '';
        $body = $data['body'] ?? '';
        $jsonData = isset($data['data']) ? json_encode($data['data']) : '{}';
        $jsonData = $jsonData ?: '{}';

        $pushDataTemp = [
            'type' => $type,
            'title' => $title,
            'body' => $body,
            'data' => $jsonData,
        ];

        if (count($pushDataTemp) === 0) {
            $pushDataTemp['type'] = 'notification';
        }

        $sanitizedData = [];
        foreach ($pushDataTemp as $key => $value) {
            if (is_scalar($value) || is_null($value)) {
                $sanitizedData[$key] = is_string($value) ? $value : ((string) $value);
            } else {
                $sanitizedData[$key] = (string) json_encode($value);
            }
        }

        $messageDataClass = 'Kreait\\Firebase\\Messaging\\MessageData';
        /** @var object $messageData */
        $messageData = $messageDataClass::fromArray($sanitizedData);

        Assert::stringNotEmpty($deviceToken, 'Il token del dispositivo non puo essere vuoto');

        $cloudMessageClass = 'Kreait\\Firebase\\Messaging\\CloudMessage';
        /** @var object $message */
        $message = $cloudMessageClass::new();

        if (
            ! method_exists($message, 'withToken')
            || ! method_exists($message, 'withHighestPossiblePriority')
            || ! method_exists($message, 'withData')
        ) {
            throw new Exception('CloudMessage API non compatibile');
        }

        // @phpstan-ignore-next-line method.nonObject
        $message = $message->withToken($deviceToken)->withHighestPossiblePriority()->withData($messageData);

        try {
            $messaging = app('firebase.messaging');
            if (! is_object($messaging) || ! method_exists($messaging, 'send')) {
                throw new Exception('Invalid messaging instance');
            }
            $messaging->send($message);
        } catch (Exception $e) {
            dddx([
                'message' => $e->getMessage(),
                'deviceToken' => $deviceToken,
            ]);
        }

        Notification::make()
            ->success()
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
            Action::make('notificationFormActions')->submit('notificationFormActions'),
        ];
    }

    protected function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();

        if (! ($user instanceof Model)) {
            throw new Exception(
                'The authenticated user object must be an Eloquent model to allow the profile page to update it.',
            );
        }

        return $user;
    }

    protected function fillForms(): void
    {
        $this->notificationForm->fill();
    }
}
