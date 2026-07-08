<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Actions\Bulk;

use Filament\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Modules\Progressioni\Mail\SchedaMail;
use Modules\Xot\Actions\Mail\SendMailByRecordsAction;

class SendMailBulkAction extends BulkAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->translateLabel()
            ->label('')
            ->tooltip('send mail')
            ->openUrlInNewTab()
            ->icon('fas-mail-bulk')
            ->action(fn (Collection $records) => app(SendMailByRecordsAction::class)->execute(records: $records, mail_class: SchedaMail::class));
    }
}
