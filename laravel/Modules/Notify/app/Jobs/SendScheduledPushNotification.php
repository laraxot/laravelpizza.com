<?php

declare(strict_types=1);

namespace Modules\Notify\Jobs;

use Exception;
use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Services\PushNotificationService;
use Webmozart\Assert\Assert;

/**
 * Job per l'invio di notifiche push programmate
 *
 * Gestisce l'invio di notifiche push in base
 * a una programmazione temporale.
 */
class SendScheduledPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $jobId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(PushNotificationService $pushService): void
    {
        try {
            // Recupera dati notifica programmata
            $notificationData = Cache::get("scheduled_push:{$this->jobId}");

            if (! $notificationData) {
                Log::warning('Scheduled push notification not found', [
                    'job_id' => $this->jobId,
                ]);

                return;
            }

            Assert::isArray($notificationData, 'Notification data must be array');

            $tokens = $notificationData['tokens'] ?? [];
            Assert::isArray($tokens, 'Tokens must be array');

            $notification = $notificationData['notification'] ?? [];
            Assert::isArray($notification, 'Notification must be array');

            $data = $notificationData['data'] ?? [];
            Assert::isArray($data, 'Data must be array');

            // Invia notifica
            $result = $pushService->sendToDevices(
                $tokens,
                $notification,
                $data
            );

            // Log risultato
            Log::info('Scheduled push notification sent', [
                'job_id' => $this->jobId,
                'result' => $result,
            ]);

            // Rimuovi notifica programmata
            Cache::forget("scheduled_push:{$this->jobId}");
        } catch (Exception $e) {
            Log::error('Scheduled push notification failed', [
                'job_id' => $this->jobId,
                'error' => $e->getMessage(),
            ]);

            // Rilancia l'eccezione per il retry
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        Log::error('Scheduled push notification job failed permanently', [
            'job_id' => $this->jobId,
            'error' => $exception->getMessage(),
        ]);

        // Rimuovi notifica programmata anche in caso di fallimento
        Cache::forget("scheduled_push:{$this->jobId}");
    }
}
