<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Push;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

/**
 * Traccia nel log l'invio push "simulato" per le piattaforme senza transport reale (APNs, Web Push).
 *
 * Gli stub di consegna ritornano `success: true` senza chiamare alcuna API: finche' il transport
 * non e' implementato, il log e' l'unico modo per vedere cosa sarebbe stato consegnato e a chi.
 */
final class LogSimulatedPushDeliveryAction
{
    use QueueableAction;

    /**
     * @param  string  $platform  `apns` | `webpush`
     * @param  string  $target  Device token o nome topic (il token viene abbreviato: e' un identificativo sensibile)
     * @param  array<string, mixed>  $payload  Payload che sarebbe stato consegnato
     */
    public function execute(string $platform, string $target, array $payload): void
    {
        Log::notice("Push {$platform} simulato: transport non implementato, nessun invio reale.", [
            'platform' => $platform,
            'target' => Str::limit($target, 12),
            'payload' => $payload,
        ]);
    }
}
