<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Push;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Datas\PushNotificationData;
use Spatie\QueueableAction\QueueableAction;
use Throwable;
use Webmozart\Assert\Assert;

/**
 * Invia una notifica push programmata, letta dalla cache tramite il suo job id.
 *
 * Coppia di `SchedulePushNotificationAction`, che scrive la cache e mette in coda
 * questa action con `Spatie\QueueableAction\ActionJob::dispatch($action, [$jobId])->delay(...)`.
 */
class SendScheduledPushNotificationAction
{
    use QueueableAction;

    public function execute(string $jobId): void
    {
        try {
            $notificationData = Cache::get("scheduled_push:{$jobId}");

            if (! $notificationData) {
                Log::warning('Scheduled push notification not found', [
                    'job_id' => $jobId]);

                return;
            }

            Assert::isArray($notificationData, 'Notification data must be array');

            $rawTokens = $notificationData['tokens'] ?? [];
            Assert::isArray($rawTokens, 'Tokens must be array');
            /** @var list<string> $tokens */
            $tokens = array_values(array_filter($rawTokens, is_string(...)));

            $rawNotification = $notificationData['notification'] ?? [];
            Assert::isArray($rawNotification, 'Notification must be array');
            $notification = PushNotificationData::from($rawNotification);

            $rawData = $notificationData['data'] ?? [];
            Assert::isArray($rawData, 'Data must be array');
            /** @var array<string, mixed> $data */
            $data = $rawData;

            $result = app(SendPushToDevicesAction::class)->execute(
                $tokens,
                $notification,
                $data
            );

            Log::debug('Scheduled push notification sent', [
                'job_id' => $jobId,
                'result' => $result]);

            Cache::forget("scheduled_push:{$jobId}");
        } catch (Exception $e) {
            Log::error('Scheduled push notification failed', [
                'job_id' => $jobId,
                'error' => $e->getMessage()]);

            Cache::forget("scheduled_push:{$jobId}");

            throw $e;
        }
    }

    /**
     * Wired automaticamente da `Spatie\QueueableAction\ActionJob` quando l'esecuzione
     * in coda fallisce in modo definitivo (nessun accesso a `$jobId`: la cache e' gia'
     * stata ripulita dal catch di `execute()`, qui resta solo il log).
     */
    public function failed(Throwable $exception): void
    {
        Log::error('Scheduled push notification job failed permanently', [
            'error' => $exception->getMessage()]);
    }
}
