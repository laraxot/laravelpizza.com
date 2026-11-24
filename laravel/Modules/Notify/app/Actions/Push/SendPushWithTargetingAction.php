<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\Push;

use Illuminate\Support\Facades\Log;
use Modules\Notify\Datas\PushCriteriaData;
use Modules\Notify\Datas\PushNotificationData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Invia una notifica push ai token che soddisfano criteri di targeting.
 */
class SendPushWithTargetingAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function execute(PushCriteriaData $criteria, PushNotificationData $notification, array $data = []): array
    {
        $tokens = $this->getTokensByCriteria($criteria);

        if ($tokens === []) {
            return [
                'success' => false,
                'message' => 'No tokens found matching criteria'];
        }

        return app(SendPushToDevicesAction::class)->execute($tokens, $notification, $data);
    }

    /**
     * Stub: ritorna sempre `[]`, ma i due motivi vanno distinti nel log perche' `execute()` li
     * riporta entrambi come "nessun token": un criterio errato e' un bug del chiamante, l'assenza
     * dello store dei device token e' una funzione non ancora implementata.
     *
     * @return list<string>
     */
    private function getTokensByCriteria(PushCriteriaData $criteria): array
    {
        if ($criteria->platform !== null && ! in_array($criteria->platform, ['fcm', 'apns', 'webpush'], true)) {
            Log::warning('Push targeting: piattaforma non supportata nei criteri, nessun token risolto.', [
                'platform' => $criteria->platform]);

            return [];
        }

        Log::notice('Push targeting: nessuno store dei device token collegato, nessun token risolto.', [
            'criteria' => $criteria->toArray()]);

        return [];
    }
}
