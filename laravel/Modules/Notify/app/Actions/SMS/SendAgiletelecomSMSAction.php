<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;
use Override;

/**
 * Azione per l'invio di SMS tramite Agile Telecom.
 */
class SendAgiletelecomSMSAction implements SmsActionContract
{
    #[Override]
    public function execute(SmsData $data): array
    {
        return app(SendAgiletelecomSMSv2Action::class)->execute($data);
    }
}
