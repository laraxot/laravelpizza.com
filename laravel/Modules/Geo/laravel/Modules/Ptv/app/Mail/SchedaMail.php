<?php

declare(strict_types=1);

namespace Modules\Ptv\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Ptv\Actions\Pdf\MakePdfByRecord;
use Modules\Ptv\Models\Contracts\SchedaContract;

class SchedaMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public SchedaContract $record;

    /**
     * Crea una nuova istanza del messaggio.
     */
    public function __construct(SchedaContract $record)
    {
        $this->record = $record;
    }

    /**
     * Definisce l'envelope del messaggio.
     */
    public function envelope(): Envelope
    {
        // @phpstan-ignore-next-line method.notFound
        return new Envelope(from: new Address('personale@provincia.treviso.it', 'Ufficio Personale Provincia di Treviso'), subject: strip_tags($this->record->msg('mail_oggetto')));
    }

    /**
     * Definisce il contenuto del messaggio.
     */
    public function content(): Content
    {
        return new Content(view: 'ptv::emails.scheda', with: [
            'row' => $this->record,
            // @phpstan-ignore-next-line method.notFound
            'html' => $this->record->msg('mail_testo'),
        ]);
    }

    /**
     * Definisce gli allegati del messaggio.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $path = app(MakePdfByRecord::class)->execute(record: $this->record, out: 'path');

        return [
            Attachment::fromPath((string) $path)
                ->withMime('application/pdf'),
        ];
    }
}
