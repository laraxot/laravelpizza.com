<?php

declare(strict_types=1);

return [
    'fields' => [
        'template_id' => [
            'label' => 'Template',
            'placeholder' => 'Seleziona un template',
            'helper_text' => 'Template di notifica usato per l\'invio, se presente',
        ],
        'notifiable_type' => [
            'label' => 'Tipo destinatario',
            'placeholder' => 'Classe del modello destinatario',
            'helper_text' => 'Classe Eloquent del destinatario (relazione polimorfica)',
        ],
        'notifiable_id' => [
            'label' => 'ID destinatario',
            'placeholder' => 'ID del destinatario',
            'helper_text' => 'Identificativo del destinatario (relazione polimorfica)',
        ],
        'channel' => [
            'label' => 'Canale',
            'placeholder' => 'Seleziona un canale',
            'helper_text' => 'Canale di invio (email, sms, whatsapp)',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona uno stato',
            'helper_text' => 'Stato di consegna della notifica',
        ],
        'status_message' => [
            'label' => 'Messaggio di stato',
            'placeholder' => 'Dettaglio errore o esito',
            'helper_text' => 'Messaggio diagnostico restituito dal provider di invio',
        ],
        'data' => [
            'label' => 'Dati',
            'helper_text' => 'Dati aggiuntivi (es. link cliccati)',
        ],
        'metadata' => [
            'label' => 'Metadati',
            'helper_text' => 'Metadati tecnici del provider di invio',
        ],
        'tenant_id' => [
            'label' => 'Tenant',
            'placeholder' => 'ID tenant',
            'helper_text' => 'Tenant proprietario del log',
        ],
        'sent_at' => ['label' => 'Inviata il'],
        'delivered_at' => ['label' => 'Consegnata il'],
        'failed_at' => ['label' => 'Fallita il'],
        'opened_at' => ['label' => 'Aperta il'],
        'clicked_at' => ['label' => 'Cliccata il'],
    ],
    'sections' => [
        'empty' => ['label' => 'empty', 'heading' => 'empty'],
    ],
];
