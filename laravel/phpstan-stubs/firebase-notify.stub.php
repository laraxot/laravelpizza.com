<?php

declare(strict_types=1);

namespace Kreait\Firebase\Contract {
    interface Messaging
    {
        public function send(object $message): void;
    }
}

namespace Kreait\Firebase\Messaging {
    class MessageData
    {
        /** @param array<string, string> $data */
        public static function fromArray(array $data): self {}
    }

    class CloudMessage
    {
        public static function new(): self {}

        public function withToken(string $token): self {}

        public function withHighestPossiblePriority(): self {}

        /** @param MessageData|array<string, string> $data */
        public function withData(MessageData|array $data): self {}

        public function withNotification(Notification $notification): self {}

        /** @param array<string, mixed>|AndroidConfig $config */
        public function withAndroidConfig(AndroidConfig|array $config): self {}
    }

    class AndroidConfig
    {
        /** @param array<string, mixed> $config */
        public static function fromArray(array $config): self {}
    }

    class Notification
    {
        public static function create(string $title, string $body): self {}
    }

    interface Message {}
}

namespace NotificationChannels\Fcm {
    class FcmChannel {}
}
