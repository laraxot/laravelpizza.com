<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Push;

use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Datas\NotifyConfigData;
use Modules\Notify\Datas\PushNotificationData;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Invia una notifica push a un topic su tutte le piattaforme supportate.
 */
class SendPushToTopicAction
{
    use QueueableAction;

    /** @var list<string> */
    private array $platforms = ['fcm', 'apns', 'webpush'];

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, array<string, mixed>>
     */
    public function execute(string $topic, PushNotificationData $notification, array $data = []): array
    {
        $results = [];

        foreach ($this->platforms as $platform) {
            Assert::string($platform, 'Platform must be a string');
            try {
                $results[$platform] = $this->sendTopicToPlatform($platform, $topic, $notification, $data);
            } catch (Exception $e) {
                Log::error("Topic push notification failed for platform {$platform}", [
                    'error' => $e->getMessage(),
                    'topic' => $topic]);

                $results[$platform] = [
                    'success' => false,
                    'error' => $e->getMessage()];
            }
        }

        return $results;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function sendTopicToPlatform(string $platform, string $topic, PushNotificationData $notification, array $data): array
    {
        return match ($platform) {
            'fcm' => $this->sendFCMTopicNotification($topic, $notification, $data),
            'apns' => $this->simulateTopicDelivery('apns', 'APNS topic notification sent (simulated)', $topic, $notification, $data),
            'webpush' => $this->simulateTopicDelivery('webpush', 'Web Push topic notification sent (simulated)', $topic, $notification, $data),
            default => throw new Exception("Unsupported platform: {$platform}")
        };
    }

    /**
     * APNs non ha topic pub/sub e Web Push non ha topic: senza una tabella sottoscrizioni topic -> token
     * non c'e' nulla da consegnare. La consegna e' simulata e tracciata nel log.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function simulateTopicDelivery(string $platform, string $message, string $topic, PushNotificationData $notification, array $data): array
    {
        app(LogSimulatedPushDeliveryAction::class)->execute($platform, $topic, [
            'topic' => $topic,
            'notification' => $notification->toArray(),
            'data' => $data]);

        return [
            'success' => true,
            'message' => $message,
            'topic' => $topic,
            'platform' => $platform];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function sendFCMTopicNotification(string $topic, PushNotificationData $notification, array $data): array
    {
        $payload = [
            'to' => "/topics/{$topic}",
            'notification' => [
                'title' => $notification->title,
                'body' => $notification->body,
                'icon' => $notification->icon ?? '/icons/icon-192x192.png'],
            'data' => $data];

        $serverKey = SafeStringCastAction::cast(config('notify.fcm.server_key'));
        $url = NotifyConfigData::make()->fcm_url;

        $response = Http::withHeaders([
            'Authorization' => 'key='.$serverKey,
            'Content-Type' => 'application/json'])->post($url, $payload);

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
                'topic' => $topic];
        }

        throw new Exception('FCM topic request failed: '.$response->body());
    }
}
