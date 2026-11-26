<?php

declare(strict_types=1);

return [
    'fields' => [
        'command' => ['label' => 'Comando', 'placeholder' => 'Seleziona un comando', 'helper_text' => 'Comando Artisan da eseguire a orari prestabiliti', 'description' => 'Comando Artisan da eseguire a orari prestabiliti'],
        'params' => ['label' => 'Argomenti', 'placeholder' => 'Argomenti', 'helper_text' => 'Argomenti del comando scelto', 'description' => 'Argomenti del comando scelto'],
        'name' => ['label' => 'Nome', 'placeholder' => 'Nome', 'helper_text' => 'Nome', 'description' => 'Nome'],
        'value' => ['label' => 'Valore', 'placeholder' => 'Valore', 'helper_text' => '', 'description' => 'Valore'],
        'options_with_value' => ['label' => 'Opzioni con valore', 'placeholder' => 'Opzioni con valore', 'helper_text' => 'Opzioni del comando che richiedono un valore', 'description' => 'Opzioni del comando che richiedono un valore'],
        'type' => ['label' => 'Tipo', 'placeholder' => 'Tipo', 'helper_text' => 'Tipo del valore', 'description' => 'Tipo del valore'],
        'expression' => ['label' => 'Espressione cron', 'placeholder' => '* * * * *', 'helper_text' => 'Pianificazione in formato cron, per esempio * * * * * (ogni minuto)', 'description' => 'Pianificazione in formato cron'],
        'environments' => ['label' => 'Ambienti', 'placeholder' => 'Ambienti', 'helper_text' => 'Ambienti in cui il job viene eseguito', 'description' => 'Ambienti in cui il job viene eseguito'],
        'log_filename' => ['label' => 'File di log', 'placeholder' => 'File di log', 'helper_text' => 'File in cui salvare l\'output del job', 'description' => 'File in cui salvare l\'output del job'],
        'webhook_before' => ['label' => 'Webhook prima dell\'esecuzione', 'placeholder' => 'https://', 'helper_text' => 'URL richiamato prima dell\'esecuzione', 'description' => 'URL richiamato prima dell\'esecuzione'],
        'webhook_after' => ['label' => 'Webhook dopo l\'esecuzione', 'placeholder' => 'https://', 'helper_text' => 'URL richiamato dopo l\'esecuzione', 'description' => 'URL richiamato dopo l\'esecuzione'],
        'email_output' => ['label' => 'Email con l\'output', 'placeholder' => 'email@example.com', 'helper_text' => 'Indirizzo a cui inviare l\'output del job', 'description' => 'Indirizzo a cui inviare l\'output del job'],
        'sendmail_success' => ['label' => 'Email in caso di successo', 'placeholder' => 'Email in caso di successo', 'helper_text' => 'Invia l\'output via email se il job riesce', 'description' => 'Invia l\'output via email se il job riesce'],
        'sendmail_error' => ['label' => 'Email in caso di errore', 'placeholder' => 'Email in caso di errore', 'helper_text' => 'Invia l\'output via email se il job fallisce', 'description' => 'Invia l\'output via email se il job fallisce'],
        'log_success' => ['label' => 'Log in caso di successo', 'placeholder' => 'Log in caso di successo', 'helper_text' => 'Registra l\'output se il job riesce', 'description' => 'Registra l\'output se il job riesce'],
        'log_error' => ['label' => 'Log in caso di errore', 'placeholder' => 'Log in caso di errore', 'helper_text' => 'Registra l\'output se il job fallisce', 'description' => 'Registra l\'output se il job fallisce'],
        'even_in_maintenance_mode' => ['label' => 'Esegui anche in manutenzione', 'placeholder' => 'Esegui anche in manutenzione', 'helper_text' => 'Esegue il job anche con l\'applicazione in manutenzione', 'description' => 'Esegue il job anche con l\'applicazione in manutenzione'],
        'without_overlapping' => ['label' => 'Senza sovrapposizione', 'placeholder' => 'Senza sovrapposizione', 'helper_text' => 'Non avvia una nuova esecuzione finché la precedente è in corso', 'description' => 'Non avvia una nuova esecuzione finché la precedente è in corso'],
        'on_one_server' => ['label' => 'Su un solo server', 'placeholder' => 'Su un solo server', 'helper_text' => 'Esegue il job su un solo server quando ce ne sono più', 'description' => 'Esegue il job su un solo server quando ce ne sono più'],
        'run_in_background' => ['label' => 'Esegui in background', 'placeholder' => 'Esegui in background', 'helper_text' => 'Esegue il job in background', 'description' => 'Esegue il job in background'],
    ],
    'sections' => [
        'empty' => ['label' => 'Generale', 'heading' => 'Generale'],
    ],
];
