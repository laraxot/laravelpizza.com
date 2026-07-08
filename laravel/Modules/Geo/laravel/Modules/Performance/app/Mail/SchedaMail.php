<?php

declare(strict_types=1);

namespace Modules\Performance\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Performance\Models\Individuale as Scheda;
use Modules\Xot\Actions\Export\PdfByModelAction;
use RuntimeException;

/**
 * implements ShouldQueue
 */
class SchedaMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public Scheda $scheda;

    /**
     * Create a new message instance.
     */
    public function __construct(Scheda $record)
    {
        $this->scheda = $record;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('personale@provincia.treviso.it', 'Ufficio Personale Provincia di Treviso'),
            // replyTo: [
            //    new Address('taylor@example.com', 'Taylor Otwell'),
            // ],
            subject: strip_tags($this->scheda->option('mail_oggetto')),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'performance::emails.scheda',
            with: [
                'row' => $this->scheda,
                'html' => $this->scheda->option('mail_testo'),
            ],
            // html: 'testo email',
            // text: 'testo email 1',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        // $path = app(MakePdfByRecord::class)->execute(record: $this->scheda, out: 'path');
        $path = app(PdfByModelAction::class)->execute(model: $this->scheda, out: 'path');

        if (! is_string($path)) {
            throw new RuntimeException('Il percorso del PDF deve essere una stringa');
        }

        return [
            Attachment::fromPath($path)
                // ->as('name.pdf')
                ->withMime('application/pdf'),

            /*
            Attachment::fromData(fn () => app(MakePdfByRecord::class)->execute($this->scheda),
                'Scheda.pdf')
                ->withMime('application/pdf'),
            */
        ];
    }
}
