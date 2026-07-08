<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Cms\Services\PanelService as Panel;
use Modules\IndennitaResponsabilita\Models\LettI;

// ------ models--------

class LettIMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var LettI
     */
    public $row;

    /**
     * Create a new message instance.
     */
    public function __construct(LettI $row)
    {
        $this->row = $row;
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        /*
        $panelContract = Panel::make()->get($this->row);
        $msg = $this->row->messages->keyBy('type');
        $pdf = $panelContract->pdf(
            [
                'pdforientation' => 'P', // Portrait, Landscape
                'out' => 'content_PDF',
                'filename' => 'tmp.pdf',
            ]
        );
        $subject = $msg['mail_oggetto_responsabilita_i']->txt.' - '.$this->row->cognome.' '.$this->row->nome;
        $this->row->myLogs()->create(
            [
                'tbl' => $this->row->getTable(),
                'note' => 'sendMailLettI',
                'data' => $this->row->toArray(),
            ]
        );

        return $this->from('personale@provincia.treviso.it')
            ->subject($subject)
            ->view('indennitaresponsabilita::admin.emails.lett_i')->with('msg', $msg)
            ->attachData((string) $pdf, 'scheda.pdf');
        */
        return $this;
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
