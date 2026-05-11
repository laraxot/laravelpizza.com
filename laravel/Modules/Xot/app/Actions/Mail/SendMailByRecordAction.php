<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Mail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Notify\Datas\EmailData;
use Modules\Notify\Datas\SmtpData;
use Modules\Xot\Actions\Export\PdfByModelAction;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class SendMailByRecordAction
{
    use QueueableAction;

    /**
     * Invia una mail utilizzando un record come dati.
     *
     * @param Model  $record    Il record da utilizzare come dati per la mail
     * @param string $mailClass La classe Mailable da utilizzare
     */
    public function execute(Model $record, string $mailClass): void
    {
        Assert::classExists($mailClass);
        // Expected an implementation of "Illuminate\Mail\Mailable". Got: "Modules\Performance\Mail\SchedaMail"
        // Assert::implementsInterface($mailClass, Mailable::class);

        // Utilizziamo il container per istanziare la classe Mailable
        // in modo che possa ricevere le dipendenze necessarie
        // @var Mailable $mail
        // $mail = app($mailClass, ['record' => $record]);
        // Mail::send($mail);
        // dddx(Mail::to($record)->send(new $mailClass($record)));
        // $res=Mail::to('marco.sottana@gmail.com')->send($mail);

        // Verifica che il model abbia le proprietà/metodi necessari
        if (($record->email ?? null) === null || empty($record->email)) {
            throw new \InvalidArgumentException('Model must have email property');
        }

        if (! method_exists($record, 'option')) {
            throw new \InvalidArgumentException('Model must implement option method');
        }

        if (! method_exists($record, 'myLogs')) {
            throw new \InvalidArgumentException('Model ['.$record::class.'] must implement myLogs method');
        }

        $to = $record->email;
        // $to = 'marco.sottana@gmail.com'; //4 debug non cancellare
        $subject = $record->option('mail_oggetto');
        $bodyHtml = $record->option('mail_testo');

        if (! \is_string($to)) {
            throw new \InvalidArgumentException('Email must be a string');
        }
        if (! \is_string($subject)) {
            $subject = '';
        }
        if (! \is_string($bodyHtml)) {
            $bodyHtml = '';
        }

        $emailData = new EmailData(
            recipient: $to,
            subject: $subject,
            body_html: $bodyHtml,
            attachments: [
                app(PdfByModelAction::class)->execute(
                    model: $record,
                    out: 'path',
                ),
            ],
        );
        SmtpData::make()->send($emailData);

        /** @var Relation $logs */
        $logs = $record->myLogs();
        $logs->create([
            'act' => 'sendMail',
            'handle' => authId(),
        ]);
    }
}
