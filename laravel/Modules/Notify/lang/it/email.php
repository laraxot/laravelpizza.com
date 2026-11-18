<?php

declare(strict_types=1);

return [
    'form' => [
        'to' => [
            'label' => 'Destinatario',
            'helper' => 'Indirizzo email a cui inviare la prova',
        ],
        'subject' => [
            'label' => 'Oggetto',
        ],
        'body_html' => [
            'label' => 'Testo',
            'helper' => 'Contenuto del messaggio (HTML ammesso)',
        ],
        'template' => [
            'label' => 'Modello',
            'helper' => 'Facoltativo: usa un modello salvato',
        ],
        'add_attachments' => [
            'label' => 'Allegati',
            'helper' => 'Facoltativo',
        ],
    ],
    'actions' => [
        'send' => 'Invia',
    ],
];
