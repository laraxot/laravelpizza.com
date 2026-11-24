<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => ['label' => 'ID'],
        'created_at' => ['label' => 'Creato il'],
        'channel' => ['label' => 'Canale'],
        'status' => ['label' => 'Stato'],
        'notifiable_type' => ['label' => 'Tipo destinatario'],
        'notifiable_id' => ['label' => 'ID destinatario'],
        'status_message' => ['label' => 'Messaggio di stato'],
        'sent_at' => ['label' => 'Inviata il'],
    ],
    'actions' => [
        'create' => ['label' => 'Nuovo log', 'icon' => 'create', 'tooltip' => 'Crea un nuovo log di notifica'],
    ],
];
