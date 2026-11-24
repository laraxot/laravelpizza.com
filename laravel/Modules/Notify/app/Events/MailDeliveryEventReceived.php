<?php

declare(strict_types=1);

namespace Modules\Notify\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\Notify\Datas\MailDeliveryEventData;

/**
 * Un provider email ha riferito cosa e' successo a un messaggio (consegnato, rimbalzato, spam, ...).
 * Il modulo Notify non decide cosa farne: lo ascolta il modulo del progetto (es. segnare un cliente
 * con email non valida, o una prenotazione la cui conferma non e' arrivata).
 */
final class MailDeliveryEventReceived
{
    use Dispatchable;

    public function __construct(public readonly MailDeliveryEventData $event) {}
}
