<?php

declare(strict_types=1);

namespace Modules\Progressioni\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;
use Modules\Progressioni\Actions\MakePdfByRecord;
use Modules\Progressioni\Models\Progressioni;
use Modules\Progressioni\Models\Scheda;

class SchedaMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public Scheda|Progressioni $scheda;

    /**
     * Create a new message instance.
     */
    public function __construct(Scheda|Progressioni $scheda)
    {
        $this->scheda = $scheda;
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
            subject: strip_tags($this->scheda->msg('mail_oggetto') ?? ''),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'progressioni::emails.scheda',
            with: [
                'row' => $this->scheda,
                'html' => $this->scheda->msg('mail_testo'),
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
        $path = app(MakePdfByRecord::class)->execute(record: $this->scheda, out: 'path');

        if (! is_string($path)) {
            throw new InvalidArgumentException('Path must be a string');
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
