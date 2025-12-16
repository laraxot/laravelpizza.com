<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Override;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;

/**
 * Azione per l'invio di SMS tramite Agile Telecom.
 */
class SendAgiletelecomSMSAction implements SmsActionContract
{
    #[Override]
    public function execute(SmsData $data): array
    {
        $res = app(SendAgiletelecomSMSv2Action::class)->execute($data);

        return $res;
    }
}
