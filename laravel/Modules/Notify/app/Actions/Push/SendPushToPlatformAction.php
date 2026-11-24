<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Push;

use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Modules\Notify\Datas\NotifyConfigData;
use Modules\Notify\Datas\PushNotificationData;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Invia una notifica push a un singolo token su una specifica piattaforma
 * (fcm, apns, webpush).
 */
class SendPushToPlatformAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $data
     * @return array{success: bool, message_id: mixed, response: mixed}|array{success: bool, message: string, platform: string}
     */
    public function execute(string $platform, string $token, PushNotificationData $notification, array $data = []): array
    {
        return match ($platform) {
            'fcm' => $this->sendFCMNotification($token, $notification, $data),
            'apns' => $this->sendAPNSNotification($token, $notification, $data),
            'webpush' => $this->sendWebPushNotification($token, $notification, $data),
            default => throw new Exception("Unsupported platform: {$platform}")
        };
    }

    /**
     * `message_id` e `response` restano `mixed`: vengono da `Response::json()`, che
     * decodifica il corpo HTTP di FCM senza contratto.
     *
     * @param  array<string, mixed>  $data
     * @return array{success: bool, message_id: mixed, response: mixed}
     */
    private function sendFCMNotification(string $token, PushNotificationData $notification, array $data): array
    {
        $payload = [
            'to' => $token,
            'notification' => [
                'title' => $notification->title,
                'body' => $notification->body,
                'icon' => $notification->icon ?? '/icons/icon-192x192.png',
                'sound' => $notification->sound ?? 'default',
                'badge' => $notification->badge ?? 1],
            'data' => $data,
            'priority' => $notification->priority ?? 'high',
            'ttl' => $notification->ttl ?? 3600];

        $serverKey = SafeStringCastAction::cast(config('notify.fcm.server_key'));
        $url = NotifyConfigData::make()->fcm_url;

        $response = Http::withHeaders([
            'Authorization' => 'key='.$serverKey,
            'Content-Type' => 'application/json'])->post($url, $payload);

        if ($response instanceof PromiseInterface) {
            $response = $response->wait();
        }

        if (! $response instanceof Response) {
            throw new Exception('FCM request returned unexpected response type');
        }

        if ($response->successful()) {
            $responseData = $response->json();

            // FCM legacy risponde 200 anche quando il token e' rifiutato: l'esito vero e' in `failure`
            $failures = is_array($responseData) ? ($responseData['failure'] ?? 0) : 0;
            if (is_int($failures) && $failures > 0) {
                throw new Exception('FCM rejected the token: '.$response->body());
            }

            return [
                'success' => true,
                'message_id' => is_array($responseData) && isset($responseData['message_id']) ? $responseData['message_id'] : null,
                'response' => $responseData];
        }

        throw new Exception('FCM request failed: '.$response->body());
    }

    /**
     * APNs e' simulato: nessun transport reale, la consegna viene solo tracciata nel log.
     *
     * @param  array<string, mixed>  $data
     * @return array{success: bool, message: string, platform: string}
     */
    private function sendAPNSNotification(string $token, PushNotificationData $notification, array $data): array
    {
        app(LogSimulatedPushDeliveryAction::class)->execute('apns', $token, [
            'notification' => $notification->toArray(),
            'data' => $data]);

        return [
            'success' => true,
            'message' => 'APNS notification sent (simulated)',
            'platform' => 'apns'];
    }

    /**
     * Web Push e' simulato: il payload che andrebbe al push service viene tracciato nel log
     * invece di essere scartato.
     *
     * @param  array<string, mixed>  $data
     * @return array{success: bool, message: string, platform: string}
     */
    private function sendWebPushNotification(string $token, PushNotificationData $notification, array $data): array
    {
        app(LogSimulatedPushDeliveryAction::class)->execute('webpush', $token, [
            'title' => $notification->title,
            'body' => $notification->body,
            'icon' => $notification->icon ?? '/icons/icon-192x192.png',
            'badge' => $notification->badge ?? '/icons/badge-72x72.png',
            'data' => $data,
            'actions' => $notification->actions ?? [],
            'requireInteraction' => $notification->requireInteraction ?? false,
            'silent' => $notification->silent ?? false]);

        return [
            'success' => true,
            'message' => 'Web Push notification sent (simulated)',
            'platform' => 'webpush'];
    }
}
