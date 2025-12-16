<?php

declare(strict_types=1);

namespace Modules\Notify\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Modules\Notify\Datas\WhatsAppData;
use Modules\Notify\Factories\WhatsAppActionFactory;

/**
 * Canale di notifica per l'invio di messaggi WhatsApp.
 *
 * Questo canale utilizza il driver WhatsApp configurato in config/whatsapp.php
 * per inviare messaggi WhatsApp attraverso il provider selezionato.
 */
class WhatsAppChannel
{
    /**
     * Factory per la creazione di azioni WhatsApp.
     */
    private WhatsAppActionFactory $factory;

    /**
     * Crea una nuova istanza del canale.
     */
    public function __construct(WhatsAppActionFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Invia la notifica attraverso il canale WhatsApp.
     *
     * @param mixed $notifiable Entità che riceve la notifica
     * @param Notification $notification Notifica da inviare
     * @return array|null Risultato dell'operazione o null in caso di errore
     * @throws Exception Se la notifica non ha il metodo toWhatsApp o il driver non è supportato
     */
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toWhatsApp')) {
            throw new Exception('Notification does not have toWhatsApp method');
        }

        $whatsAppData = $notification->toWhatsApp($notifiable);

        if (!($whatsAppData instanceof WhatsAppData)) {
            throw new Exception('toWhatsApp method must return an instance of WhatsAppData');
        }

        $action = $this->factory->create();

        return $action->execute($whatsAppData);
    }
}
