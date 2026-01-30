<?php

declare(strict_types=1);

namespace Modules\Notify\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Notify\Actions\DetermineSeasonalContentViewPathAction;

class ChristmasGreetingMailable extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $recipientName = 'Cliente Valutato',
        public string $senderName = 'Il Team del nostro Studio',
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address((string) env('MAIL_FROM_ADDRESS', 'hello@example.com'), $this->senderName),
            subject: 'Auguri di Buone Feste e Informazioni Importanti!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Dynamically determine the seasonal content view path using the action
        $seasonalContentViewPath = app(DetermineSeasonalContentViewPathAction::class)->execute('base-content');

        return new Content(
            view: $seasonalContentViewPath, // Use the determined content view
            with: [
                'recipientName' => $this->recipientName,
                'senderName' => $this->senderName,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
