<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications\Channels;

use Kreait\Firebase\Messaging\RegistrationToken;
use Kreait\Firebase\Messaging\RegistrationTokens;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\MulticastSendReport;
use Modules\Notify\Contracts\CanReceivePushNotifications;
use Modules\Notify\Contracts\MobilePushNotification;
use Modules\Notify\Datas\PushNotificationDebugData;
use Psr\Log\LoggerInterface;

use function Safe\json_encode;

final class FirebaseCloudMessagingChannel
{
    private static LoggerInterface $logger;

    public function __construct(
        private readonly Messaging $firebaseCloudMessaging,
    ) {
        self::$logger = Log::driver('firebase') ?? Log::getDefaultDriver();
    }

    public function send(Model&CanReceivePushNotifications $notifiable, MobilePushNotification $notification): void
    {
        $userNotificationTokens = $notifiable->getMobileDeviceTokens();

        if ($userNotificationTokens->isEmpty()) {
            // No devices to be notified, bye!
            return;
        }

        try {
            $multicastSendReport = $this->sendMulticastNotificationToDevices(
                notification: $notification,
                userDeviceTokens: $userNotificationTokens,
                debugTokens: (bool) config('firebase.enable_token_validation'),
            );

            if (config('firebase.enable_debug_mode')) {
                $notificationDebugData = PushNotificationDebugData::make(
                    notifiable: $notifiable,
                    notification: $notification,
                    sendReport: $multicastSendReport,
                )->toArray();

                self::$logger->debug(sprintf(
                    "FCM notification debug:\n%s",
                    json_encode($notificationDebugData, JSON_PRETTY_PRINT),
                ));
            }
        } catch (Exception $exception) {
            self::$logger->error(sprintf(
                "An exception has been thrown while trying to send FCM notifications.\n\tError message is: '%s' [%s]\n\tNotification data was: %s\n\tUser devices were: %s",
                $exception->getMessage(),
                $exception->getCode(),
                json_encode($notification->toArray(null), JSON_THROW_ON_ERROR),
                json_encode($userNotificationTokens->toArray(), JSON_THROW_ON_ERROR),
            ));
            self::$logger->error(json_encode($exception->getTrace(), JSON_PRETTY_PRINT));
        }
    }

    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    private function sendMulticastNotificationToDevices(
        MobilePushNotification $notification,
        Collection $userDeviceTokens,
        bool $debugTokens = false,
    ): MulticastSendReport {
        if ($debugTokens) {
            // Make sure tokens are valid (for debugging purposes)
            $this->testFcmTokens($userDeviceTokens);
        }

        /**
         * @var list<RegistrationToken|string>|RegistrationToken|RegistrationTokens|non-empty-string
         */
        $registrationTokens = $userDeviceTokens->toArray();

        return $this->firebaseCloudMessaging->sendMulticast(
            message: $notification->toCloudMessage(),
            registrationTokens: $registrationTokens,
        );
    }

    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    private function testFcmTokens(Collection $tokens): void
    {
        /**
         * @var list<RegistrationToken|non-empty-string>|RegistrationToken|RegistrationTokens|non-empty-string
         */
        $registrationTokenOrTokens = $tokens->toArray();
        $validatedTokens = $this->firebaseCloudMessaging->validateRegistrationTokens($registrationTokenOrTokens);
        self::$logger->debug(json_encode($validatedTokens, JSON_PRETTY_PRINT));
    }
}
