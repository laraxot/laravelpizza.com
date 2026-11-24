<?php

declare(strict_types=1);

namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

/**
 * Data Transfer Object per i messaggi WhatsApp.
 *
 * Questo DTO standardizza i dati necessari per l'invio di messaggi WhatsApp
 * attraverso diversi provider, garantendo coerenza e tipo-sicurezza.
 */
class WhatsAppData extends Data
{
    /**
     * @param  string  $recipient  Numero di telefono del destinatario in formato E.164 (es. +393401234567)
     * @param  string  $body  Contenuto testuale del messaggio
     * @param  string|null  $from  Numero di telefono del mittente (opzionale, può essere definito nella configurazione)
     * @param  list<string>|null  $media
     * @param  array<string, mixed>|null  $buttons
     * @param  array<string, mixed>|null  $template
     * @param  string  $type  Tipo di messaggio: 'text', 'media', 'template', ecc.
     * @return void
     */
    public function __construct(
        public string $recipient,
        public string $body,
        public ?string $from = null,
        public ?array $media = null,
        public ?array $buttons = null,
        public ?array $template = null,
        public string $type = 'text',
    ) {}
}
