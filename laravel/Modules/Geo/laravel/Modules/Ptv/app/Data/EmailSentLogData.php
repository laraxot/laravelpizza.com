<?php

declare(strict_types=1);

namespace Modules\Ptv\Data;

use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\User\Models\User;
use Spatie\LaravelData\Data;

/**
 * Data Transfer Object per logging invio email riuscito.
 *
 * Questo DTO incapsula tutti i dati necessari per registrare
 * l'activity log di un invio email riuscito, seguendo il principio
 * Clean Code di non superare mai 3 parametri per metodo.
 */
class EmailSentLogData extends Data
{
    /**
     * @param  SchedaContract  $record  Record della scheda inviata
     * @param  User  $user  Utente che ha inviato l'email
     * @param  string  $template  Template email utilizzato
     * @param  string  $recipient  Destinatario email
     * @param  string  $filename  Nome file PDF allegato
     * @param  string  $pdfContent  Contenuto PDF binario (per calcolo dimensione)
     */
    public function __construct(
        public readonly SchedaContract $record,
        public readonly User $user,
        public readonly string $template,
        public readonly string $recipient,
        public readonly string $filename,
        public readonly string $pdfContent,
    ) {}
}
