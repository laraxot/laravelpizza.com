<?php

declare(strict_types=1);

namespace Modules\Notify\Actions\SMS;

use Modules\Notify\Datas\SmsData;
use Modules\Notify\Models\Contracts\SmsActionContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * Azione per l'invio di SMS tramite Agile Telecom.
<<<<<<< HEAD
 *
 * @see docs/contracts/send-agiletelecom-sms-action.md
 *
 * @contract docs/contracts/send-agiletelecom-sms-action.md
=======
<<<<<<< HEAD
=======
 *
 * @see docs/contracts/send-agiletelecom-sms-action.md
 * @contract docs/contracts/send-agiletelecom-sms-action.md
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
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
