<?php

declare(strict_types=1);

namespace Modules\Notify\Services;

use DateTime;
use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Jobs\SendScheduledPushNotification;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function Safe\json_encode;

/**
 * Servizio per notifiche push avanzate.
 *
 * Gestisce l'invio di notifiche push attraverso multiple piattaforme e canali.
 */
class PushNotificationService
{
    use QueueableAction;

    /** @var array<string, array<string, mixed>> */
    private array $config;

    /** @var list<string> */
    private array $platforms = ['fcm', 'apns', 'webpush'];

    public function __construct()
    {
        $this->config = [
            'fcm' => [
                'server_key' => config('notify.fcm.server_key'),
                'url' => 'https://fcm.googleapis.com/fcm/send',
            ],
            'apns' => [
                'certificate' => config('notify.apns.certificate'),
                'passphrase' => config('notify.apns.passphrase'),
                'url' => config('notify.apns.url'),
            ],
            'webpush' => [
                'vapid_public' => config('notify.webpush.vapid_public'),
                'vapid_private' => config('notify.webpush.vapid_private'),
                'vapid_subject' => config('notify.webpush.vapid_subject'),
            ],
        ];
    }

    /**
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    public function sendToDevice(string $token, array $notification, array $data = []): array
    {
        $results = [];

        foreach ($this->platforms as $platform) {
            Assert::string($platform, 'Platform must be a string');
            try {
                $result = $this->sendToPlatform($platform, $token, $notification, $data);
                $results[$platform] = $result;
            } catch (Exception $e) {
                Log::error("Push notification failed for platform {$platform}", [
                    'error' => $e->getMessage(),
                    'token' => $token,
                    'notification' => $notification,
                ]);

                $results[$platform] = [
                    'success' => false,
                    'error' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }

    /**
     * @param  list<string>  $tokens
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    public function sendToDevices(array $tokens, array $notification, array $data = []): array
    {
        $results = [];

        $tokensByPlatform = $this->groupTokensByPlatform($tokens);

        foreach ($tokensByPlatform as $platform => $platformTokens) {
            Assert::string($platform, 'Platform must be a string');
            Assert::isArray($platformTokens, 'Platform tokens must be an array');
            try {
                $result = $this->sendBatchToPlatform($platform, $platformTokens, $notification, $data);
                $results[$platform] = $result;
            } catch (Exception $e) {
                Log::error("Batch push notification failed for platform {$platform}", [
                    'error' => $e->getMessage(),
                    'token_count' => count($platformTokens),
                ]);

                $results[$platform] = [
                    'success' => false,
                    'error' => $e->getMessage(),
                    'sent' => 0,
                    'failed' => count($platformTokens),
                ];
            }
        }

        return $results;
    }

    /**
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    public function sendToTopic(string $topic, array $notification, array $data = []): array
    {
        $results = [];

        foreach ($this->platforms as $platform) {
            Assert::string($platform, 'Platform must be a string');
            try {
                $result = $this->sendTopicToPlatform($platform, $topic, $notification, $data);
                $results[$platform] = $result;
            } catch (Exception $e) {
                Log::error("Topic push notification failed for platform {$platform}", [
                    'error' => $e->getMessage(),
                    'topic' => $topic,
                ]);

                $results[$platform] = [
                    'success' => false,
                    'error' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }

    /**
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function sendToAll(array $notification, array $data = []): array
    {
        $tokens = $this->getAllActiveTokens();

        if ($tokens === []) {
            return [
                'success' => false,
                'message' => 'No active tokens found',
            ];
        }

        return $this->sendToDevices($tokens, $notification, $data);
    }

    /**
     * @param  list<string>  $tokens
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     */
    public function scheduleNotification(array $tokens, array $notification, array $data, DateTime $scheduleTime): string
    {
        $jobId = uniqid('push_', true);

        Cache::put("scheduled_push:{$jobId}", [
            'tokens' => $tokens,
            'notification' => $notification,
            'data' => $data,
            'schedule_time' => $scheduleTime->getTimestamp(),
        ], $scheduleTime);

        SendScheduledPushNotification::dispatch($jobId)
            ->delay($scheduleTime);

        return $jobId;
    }

    /**
     * @param  list<string>  $tokens
     * @param  array<string, mixed>  $variables
     * @return array<string, array<string, mixed>>
     */
    public function sendWithTemplate(string $templateId, array $tokens, array $variables = []): array
    {
        $template = $this->getTemplate($templateId);

        if ($template === null) {
            throw new Exception("Template {$templateId} not found");
        }

        $notification = $this->processTemplate($template, $variables);
        /** @var array<string, mixed> $data */
        $data = isset($template['data']) && is_array($template['data']) ? $template['data'] : [];

        return $this->sendToDevices($tokens, $notification, $data);
    }

    /**
     * @param  array<string, mixed>  $criteria
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function sendWithTargeting(array $criteria, array $notification, array $data = []): array
    {
        $tokens = $this->getTokensByCriteria($criteria);

        if ($tokens === []) {
            return [
                'success' => false,
                'message' => 'No tokens found matching criteria',
            ];
        }

        return $this->sendToDevices($tokens, $notification, $data);
    }

    /**
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function sendToPlatform(string $platform, string $token, array $notification, array $data): array
    {
        return match ($platform) {
            'fcm' => $this->sendFCMNotification($token, $notification, $data),
            'apns' => $this->sendAPNSNotification($token, $notification, $data),
            'webpush' => $this->sendWebPushNotification($token, $notification, $data),
            default => throw new Exception("Unsupported platform: {$platform}")
        };
    }

    /**
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function sendFCMNotification(string $token, array $notification, array $data): array
    {
        $payload = [
            'to' => $token,
            'notification' => [
                'title' => $notification['title'],
                'body' => $notification['body'],
                'icon' => $notification['icon'] ?? '/icons/icon-192x192.png',
                'sound' => $notification['sound'] ?? 'default',
                'badge' => $notification['badge'] ?? 1,
            ],
            'data' => $data,
            'priority' => $notification['priority'] ?? 'high',
            'ttl' => $notification['ttl'] ?? 3600,
        ];

        $fcmConfig = $this->config['fcm'] ?? [];
        Assert::isArray($fcmConfig, 'FCM config must be an array');
        $serverKey = isset($fcmConfig['server_key']) ? SafeStringCastAction::cast($fcmConfig['server_key']) : '';
        $url = isset($fcmConfig['url']) ? SafeStringCastAction::cast($fcmConfig['url']) : '';

        $response = Http::withHeaders([
            'Authorization' => 'key='.$serverKey,
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        if ($response instanceof PromiseInterface) {
            $response = $response->wait();
        }

        if (! $response instanceof Response) {
            throw new Exception('FCM request returned unexpected response type');
        }

        if ($response->successful()) {
            $responseData = $response->json();

            return [
                'success' => true,
                'message_id' => is_array($responseData) && isset($responseData['message_id']) ? $responseData['message_id'] : null,
                'response' => $responseData,
            ];
        }

        throw new Exception('FCM request failed: '.$response->body());
    }

    /**
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function sendAPNSNotification(string $token, array $notification, array $data): array
    {
        return [
            'success' => true,
            'message' => 'APNS notification sent (simulated)',
            'platform' => 'apns',
        ];
    }

    /**
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function sendWebPushNotification(string $token, array $notification, array $data): array
    {
        json_encode([
            'title' => $notification['title'],
            'body' => $notification['body'],
            'icon' => $notification['icon'] ?? '/icons/icon-192x192.png',
            'badge' => $notification['badge'] ?? '/icons/badge-72x72.png',
            'data' => $data,
            'actions' => $notification['actions'] ?? [],
            'requireInteraction' => $notification['requireInteraction'] ?? false,
            'silent' => $notification['silent'] ?? false,
        ]);

        return [
            'success' => true,
            'message' => 'Web Push notification sent (simulated)',
            'platform' => 'webpush',
        ];
    }

    /**
     * @param  list<string>  $tokens
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function sendBatchToPlatform(string $platform, array $tokens, array $notification, array $data): array
    {
        $results = [];
        $successCount = 0;
        $failureCount = 0;

        foreach ($tokens as $token) {
            Assert::string($token, 'Token must be a string');
            try {
                $result = $this->sendToPlatform($platform, $token, $notification, $data);
                if ($result['success']) {
                    $successCount++;
                } else {
                    $failureCount++;
                }
                $results[] = $result;
            } catch (Exception $e) {
                $failureCount++;
                $results[] = [
                    'success' => false,
                    'error' => $e->getMessage(),
                    'token' => $token,
                ];
            }
        }

        return [
            'success' => $failureCount === 0,
            'sent' => $successCount,
            'failed' => $failureCount,
            'total' => count($tokens),
            'results' => $results,
        ];
    }

    /**
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function sendTopicToPlatform(string $platform, string $topic, array $notification, array $data): array
    {
        return match ($platform) {
            'fcm' => $this->sendFCMTopicNotification($topic, $notification, $data),
            'apns' => $this->sendAPNSTopicNotification($topic, $notification, $data),
            'webpush' => $this->sendWebPushTopicNotification($topic, $notification, $data),
            default => throw new Exception("Unsupported platform: {$platform}")
        };
    }

    /**
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function sendFCMTopicNotification(string $topic, array $notification, array $data): array
    {
        $payload = [
            'to' => "/topics/{$topic}",
            'notification' => [
                'title' => $notification['title'],
                'body' => $notification['body'],
                'icon' => $notification['icon'] ?? '/icons/icon-192x192.png',
            ],
            'data' => $data,
        ];

        $fcmConfig = $this->config['fcm'] ?? [];
        Assert::isArray($fcmConfig, 'FCM config must be an array');
        $serverKey = isset($fcmConfig['server_key']) ? SafeStringCastAction::cast($fcmConfig['server_key']) : '';
        $url = isset($fcmConfig['url']) ? SafeStringCastAction::cast($fcmConfig['url']) : '';

        $response = Http::withHeaders([
            'Authorization' => 'key='.$serverKey,
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        if ($response instanceof PromiseInterface) {
            $response = $response->wait();
        }

        if (! $response instanceof Response) {
            throw new Exception('FCM topic request returned unexpected response type');
        }

        if ($response->successful()) {
            $responseData = $response->json();

            return [
                'success' => true,
                'message_id' => is_array($responseData) && isset($responseData['message_id']) ? $responseData['message_id'] : null,
            ];
        }

        throw new Exception('FCM topic request failed: '.$response->body());
    }

    /**
     * @param  list<string>  $tokens
     * @return array<string, list<string>>
     */
    private function groupTokensByPlatform(array $tokens): array
    {
        $grouped = [];

        foreach ($tokens as $token) {
            Assert::string($token, 'Token must be a string');
            $platform = $this->detectPlatform($token);
            $grouped[$platform][] = $token;
        }

        return $grouped;
    }

    private function detectPlatform(string $token): string
    {
        if (strlen($token) === 64 && ctype_xdigit($token)) {
            return 'apns';
        }
        if (strlen($token) > 100 && str_contains($token, ':')) {
            return 'fcm';
        }

        return 'webpush';
    }

    /**
     * @return list<string>
     */
    private function getAllActiveTokens(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function getTemplate(string $templateId): ?array
    {
        /** @var array<string, array<string, mixed>> $templates */
        $templates = [
            'ticket_created' => [
                'title' => 'Nuovo Ticket Creato',
                'body' => 'È stato creato un nuovo ticket: {ticket_title}',
                'icon' => '/icons/ticket.png',
                'data' => ['type' => 'ticket_created'],
            ],
            'ticket_updated' => [
                'title' => 'Ticket Aggiornato',
                'body' => 'Il ticket {ticket_title} è stato aggiornato',
                'icon' => '/icons/update.png',
                'data' => ['type' => 'ticket_updated'],
            ],
            'ticket_resolved' => [
                'title' => 'Ticket Risolto',
                'body' => 'Il ticket {ticket_title} è stato risolto',
                'icon' => '/icons/check.png',
                'data' => ['type' => 'ticket_resolved'],
            ],
        ];

        return $templates[$templateId] ?? null;
    }

    /**
     * @param  array<string, mixed>  $template
     * @param  array<string, mixed>  $variables
     * @return array<string, mixed>
     */
    private function processTemplate(array $template, array $variables): array
    {
        $notification = $template;

        foreach ($variables as $key => $value) {
            $keyStr = SafeStringCastAction::cast($key);
            $valueStr = SafeStringCastAction::cast($value);
            $titleStr = isset($notification['title']) ? SafeStringCastAction::cast($notification['title']) : '';
            $bodyStr = isset($notification['body']) ? SafeStringCastAction::cast($notification['body']) : '';

            $notification['title'] = str_replace('{{'.$keyStr.'}}', $valueStr, $titleStr);
            $notification['body'] = str_replace('{{'.$keyStr.'}}', $valueStr, $bodyStr);
        }

        return $notification;
    }

    /**
     * @param  array<string, mixed>  $criteria
     * @return list<string>
     */
    private function getTokensByCriteria(array $criteria): array
    {
        return [];
    }

    /**
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function sendAPNSTopicNotification(string $topic, array $notification, array $data): array
    {
        return [
            'success' => true,
            'message' => 'APNS topic notification sent (simulated)',
            'platform' => 'apns',
        ];
    }

    /**
     * @param  array<string, mixed>  $notification
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function sendWebPushTopicNotification(string $topic, array $notification, array $data): array
    {
        return [
            'success' => true,
            'message' => 'Web Push topic notification sent (simulated)',
            'platform' => 'webpush',
        ];
    }
}
