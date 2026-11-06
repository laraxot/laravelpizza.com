<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Modules\Notify\Datas\SmsData;
use Modules\Notify\Models\Contracts\SmsActionContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * Azione per l'invio di SMS tramite Agile Telecom.
 */
class SendAgiletelecomSMSAction implements SmsActionContract
{
    use QueueableAction;

    /**
     * @return array<string, mixed>
     */
    public function execute(SmsData $data): array
    {
        return app(SendAgiletelecomSMSv2Action::class)->execute($data);
    }
}
