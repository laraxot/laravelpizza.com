<?php

declare(strict_types=1);

return [
    'view' => [
        'running_notice' => [
            'message' => 'Der Befehl wird ausgeführt. Bitte schließen Sie dieses Fenster nicht.',
        ],
        'actions_disabled' => [
            'description' => 'Andere Aktionen sind deaktiviert, bis der Befehl abgeschlossen ist.',
        ],
        'running_command' => [
            'message' => 'Befehl wird ausgeführt: php artisan',
        ],
        'waiting_output' => [
            'message' => 'Warten auf Ausgabe...',
        ],
        'select_command' => [
            'label' => 'Wählen Sie oben einen Befehl aus, um zu beginnen.',
        ],
        'scroll' => [
            'helper_text' => 'Mit dem Mausrad können Sie durch die Ausgabe scrollen.',
        ],
    ],
    'status' => [
        'completed' => [
            'message' => 'Abgeschlossen',
        ],
        'failed' => [
            'message' => 'Fehlgeschlagen',
        ],
        'running' => [
            'message' => 'Wird ausgeführt...',
        ],
    ],
];
