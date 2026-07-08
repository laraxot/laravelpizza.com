<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\IndennitaResponsabilita\Mail\SchedaMail;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita as Scheda;
use Modules\IndennitaResponsabilita\Models\MyLog;
use Modules\Notify\Datas\EmailData;
use Modules\Notify\Datas\SmtpData;
use Spatie\QueueableAction\QueueableAction;

class SendMailByRecord
{
    use QueueableAction;

    /**
     * Send email for a specific Indennita Responsabilita record.
     */
    public function execute(Scheda $record): bool
    {
        if ($record->ratings->sum('pivot.value') == 0) {
            return false;
        }

        $data = [
            'to' => $record->email,
            // 'to'=>'marco.sottana@gmail.com',
            'subject' => $record->msg('mail_oggetto'),
            'body_html' => $record->msg('mail_testo'),
            'attachments' => [
                app(MakePdfByRecord::class)->execute(record: $record, out: 'path'),
            ],
        ];
        $emailData = EmailData::from($data);
        SmtpData::make()->send($emailData);
        // Mail::to($to)->send(new SchedaMail($record));
        MyLog::create([
            'id_tbl' => $record->id,
            'tbl' => $record->getTable(),
            'act' => 'sendMail',
            'handle' => Auth::id() ?? 0,
        ]);

        return true;
    }
}
