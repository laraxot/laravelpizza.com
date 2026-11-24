<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Push;

use Exception;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Datas\PushNotificationData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Invia una notifica push a più token, raggruppandoli per piattaforma.
 */
class SendPushToDevicesAction
{
    use QueueableAction;

    /**
     * Chiave = piattaforma rilevata dal token; valore = esito del batch, sia sul ramo
     * riuscito sia su quello di eccezione.
     *
     * @param  list<string>  $tokens
     * @param  array<string, mixed>  $data
     * @return array<string, array{success: bool, sent: int, failed: int, ...}>
     */
    public function execute(array $tokens, PushNotificationData $notification, array $data = []): array
    {
        $results = [];

        $tokensByPlatform = $this->groupTokensByPlatform($tokens);

        foreach ($tokensByPlatform as $platform => $platformTokens) {
            Assert::string($platform, 'Platform must be a string');
            Assert::isArray($platformTokens, 'Platform tokens must be an array');
            try {
                $results[$platform] = $this->sendBatchToPlatform($platform, $platformTokens, $notification, $data);
            } catch (Exception $e) {
                Log::error("Batch push notification failed for platform {$platform}", [
                    'error' => $e->getMessage(),
                    'token_count' => count($platformTokens)]);

                $results[$platform] = [
                    'success' => false,
                    'error' => $e->getMessage(),
                    'sent' => 0,
                    'failed' => count($platformTokens)];
            }
        }

        return $results;
    }

    /**
     * @param  list<string>  $tokens
     * @param  array<string, mixed>  $data
     * @return array{success: bool, sent: int, failed: int, total: int, results: list<array{success: bool, ...}>}
     */
    private function sendBatchToPlatform(string $platform, array $tokens, PushNotificationData $notification, array $data): array
    {
        $results = [];
        $successCount = 0;
        $failureCount = 0;

        foreach ($tokens as $token) {
            Assert::string($token, 'Token must be a string');
            try {
                $result = app(SendPushToPlatformAction::class)->execute($platform, $token, $notification, $data);
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
                    'token' => $token];
            }
        }

        return [
            'success' => $failureCount === 0,
            'sent' => $successCount,
            'failed' => $failureCount,
            'total' => count($tokens),
            'results' => $results];
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
}
