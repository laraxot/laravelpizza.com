<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Modules\Cms\Services\PanelService as Panel;
use Modules\IndennitaResponsabilita\Models\LettF;
use Modules\Xot\Datas\PdfData;
use RuntimeException;

// ------ models--------

class LettFMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var LettF
     */
    public $row;

    /**
     * Create a new message instance.
     */
    public function __construct(LettF $row)
    {
        $this->row = $row;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        // $panelContract = Panel::make()->get($this->row);
        $messages = $this->row->getAttribute('messages');
        if (! is_iterable($messages)) {
            throw new RuntimeException('Messages attribute is not iterable');
        }
        /** @var iterable<int|string, mixed> $messagesIterable */
        $messagesIterable = $messages;
        /** @var Collection<int|string, mixed> $msg */
        $msg = collect($messagesIterable)->keyBy('type');
        /*
        $pdf = $panelContract->pdf(
            [
                'pdforientation' => 'P', // Portrait, Landscape
                'out' => 'content_PDF',
                'filename' => 'tmp.pdf',
            ]
        );
        */
        $pdf = PdfData::make()->fromModel($this->row)->getContent();
        $mailOggetto = $msg->get('mail_oggetto_responsabilita_f');
        // PHPStan Level 10: isset() invece di property_exists() per oggetti (più sicuro e coerente)
        $oggetto = is_object($mailOggetto) && isset($mailOggetto->txt) ? (string) $mailOggetto->txt : 'Indennità Responsabilità';
        $cognome = (string) ($this->row->getAttribute('cognome') ?? '');
        $nome = (string) ($this->row->getAttribute('nome') ?? '');
        $subject = $oggetto.' - '.$cognome.' '.$nome;
        $this->row->myLogs()->create(
            [
                'tbl' => $this->row->getTable(),
                'note' => 'sendMailLettF',
                'data' => $this->row->toArray(),
            ]
        );

        return $this->from('personale@provincia.treviso.it')
            ->subject($subject)
            ->view('indennitaresponsabilita::admin.emails.lett_f')->with('msg', $msg)
            ->attachData((string) $pdf, 'scheda.pdf');
        /*
        ->attach('/path/to/file', [
            'as' => 'scheda.pdf',
            'mime' => 'application/pdf',
        ])
        //*/
        /*
        ->attachFromStorage('/path/to/file', 'name.pdf', [
           'mime' => 'application/pdf'
        ])
        */
    }
}
