<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Stringable;
use Modules\Notify\Contracts\MobilePushNotification;
use Modules\Notify\Datas\FirebaseNotificationData;

/**
 * Class for sending notifications via Firebase Cloud Messaging to Android devices.
 */
class FirebaseAndroidNotification extends Notification implements MobilePushNotification
{
    use Queueable;

    public function __construct(
        public FirebaseNotificationData $data,
    ) {}

    /**
     * @return array<int, class-string>
     */
    public function via(object $_notifiable): array
    {
        $fcmChannelClass = 'NotificationChannels\\Fcm\\FcmChannel';

        if (! class_exists($fcmChannelClass)) {
            return [];
        }

        return [$fcmChannelClass];
    }

    public function toFirebase(object $_notifiable): object
    {
        $androidConfigClass = 'Kreait\\Firebase\\Messaging\\AndroidConfig';
        $cloudMessageClass = 'Kreait\\Firebase\\Messaging\\CloudMessage';
        $firebaseNotificationClass = 'Kreait\\Firebase\\Messaging\\Notification';

        if (
            ! class_exists($androidConfigClass)
            || ! class_exists($cloudMessageClass)
            || ! class_exists($firebaseNotificationClass)
        ) {
            return (object) [];
        }

        $androidConfig = [
            'ttl' => '3600s',
            'priority' => 'high',
        ];

        $dataProperty = $data->data ?? null;
        if (is_array($dataProperty)) {
            $notification = [];
            $allowedKeys = ['title', 'body', 'icon', 'color', 'sound', 'click_action'];

            foreach ($allowedKeys as $key) {
                if (isset($dataProperty[$key]) && is_string($dataProperty[$key]) && $dataProperty[$key] !== '') {
                    $notification[$key] = $dataProperty[$key];
                }
            }

            if ($notification !== []) {
                $androidConfig['notification'] = $notification;
            }
        }

        /** @var object $message */
        $message = $cloudMessageClass::new();

        if (! method_exists($message, 'withNotification') || ! method_exists($message, 'withAndroidConfig')) {
            return (object) [];
        }

        /** @var object $firebaseNotification */
        $firebaseNotification = $firebaseNotificationClass::create($data->title, $this->data->body);
        /** @var object $androidConfigObject */
        $androidConfigObject = $androidConfigClass::fromArray($androidConfig);

        /** @phpstan-ignore-next-line method.nonObject (Kreait CloudMessage from string class) */
        $messageWithNotification = $message->withNotification($firebaseNotification);
        if (! is_object($messageWithNotification) || ! method_exists($messageWithNotification, 'withAndroidConfig')) {
            return (object) [];
        }

        /** @var callable(object): mixed $withAndroidConfig */
        $withAndroidConfig = [$messageWithNotification, 'withAndroidConfig'];
        $builtMessage = $withAndroidConfig($androidConfigObject);

        return is_object($builtMessage) ? $builtMessage : (object) [];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(?object $_notifiable): array
    {
        return [];
    }

    public function toCloudMessage(): object
    {
        $cloudMessageClass = 'Kreait\\Firebase\\Messaging\\CloudMessage';

        if (! class_exists($cloudMessageClass)) {
            return (object) [];
        }

        $notificationData = $data->data;

        /** @var array<non-empty-string, string> $data */
        $data = [];
        foreach ($notificationData as $key => $value) {
            if (is_string($key) && $key !== '' && (is_string($value) || $value instanceof Stringable)) {
                $data[$key] = $value instanceof Stringable ? $value->toString() : $value;
            }
        }

        /** @var object $message */
        $message = $cloudMessageClass::new();

        if (! method_exists($message, 'withHighestPossiblePriority') || ! method_exists($message, 'withData')) {
            return (object) [];
        }

        /** @phpstan-ignore-next-line method.nonObject (Kreait CloudMessage from string class) */
        $messageWithPriority = $message->withHighestPossiblePriority();
        if (! is_object($messageWithPriority) || ! method_exists($messageWithPriority, 'withData')) {
            return (object) [];
        }

        /** @var callable(array<non-empty-string, string>): mixed $withData */
        $withData = [$messageWithPriority, 'withData'];
        $builtMessage = $withData($data);

        return is_object($builtMessage) ? $builtMessage : (object) [];
    }
}
