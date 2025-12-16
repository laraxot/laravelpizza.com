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
     * @param string $to Numero di telefono del destinatario in formato E.164 (es. +393401234567)
     * @param string $body Contenuto testuale del messaggio
     * @param string|null $from Numero di telefono del mittente (opzionale, può essere definito nella configurazione)
     * @param array|null $media Array di URL di media da allegare al messaggio (immagini, video, documenti)
     * @param array|null $buttons Array di pulsanti interattivi (supportati solo da alcuni provider)
     * @param array|null $template Dati del template per messaggi strutturati (supportati solo da alcuni provider)
     * @param string $type Tipo di messaggio: 'text', 'media', 'template', ecc.
     */
    public function __construct(
        public string $to,
        public string $body,
        public null|string $from = null,
        public null|array $media = null,
        public null|array $buttons = null,
        public null|array $template = null,
        public string $type = 'text',
    ) {}
}
