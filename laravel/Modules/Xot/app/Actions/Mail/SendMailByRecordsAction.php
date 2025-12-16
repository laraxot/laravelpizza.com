<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Mail;

use Illuminate\Database\Eloquent\Collection;
use Spatie\QueueableAction\QueueableAction;

class SendMailByRecordsAction
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(Collection $records, string $mail_class): bool
    {
        foreach ($records as $record) {
            app(SendMailByRecordAction::class)->execute($record, $mail_class);
        }

        return true;
    }
}
