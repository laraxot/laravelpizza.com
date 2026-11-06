<?php

declare(strict_types=1);

return [
    'modal' => [
        'heading' => 'Conferma password',
        'description' => 'Inserisci la password attuale per continuare.',
    ],
    'fields' => [
        'current_password' => [
            'label' => 'Password attuale',
            'placeholder' => 'Inserisci la password attuale',
            'helper_text' => 'Serve a confermare che sei tu a eseguire l\'azione.',
            'description' => 'Password dell\'account autenticato',
        ],
    ],
];
