<?php

declare(strict_types=1);

namespace Modules\Xot\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class RecordMail
 *
 * Mailable per l'invio di dati di record via email.
 */
class RecordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array<string, mixed>
     */
    public array $recordData;

    /**
     * Crea una nuova istanza del mailable.
     *
     * @param  array<string, mixed>  $data  I dati del record
     */
    public function __construct(array $data)
    {
        $this->recordData = $data;
    }

    /**
     * Costruisce il messaggio.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->view('xot::emails.record')->with(['data' => $this->recordData]);
    }
}
