<?php

declare(strict_types=1);


return [
    'resource' => [
        'name' => 'Contact',
    ],
    'navigation' => [
        'name' => 'contatto',
        'plural' => 'contatti',
        'group' => 'Sistema',
        'label' => 'Contatto',
        'sort' => '49',
        'icon' => 'notify-contact-animated',
        'description' => 'Gestione del singolo contatto per le notifiche',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome del contatto',
            'placeholder' => 'es: Mario Rossi',
            'help' => 'Inserisci il nome completo del contatto',
        ],
        'email' => [
            'label' => 'Email',
            'tooltip' => 'Indirizzo email del contatto',
            'placeholder' => 'es: mario.rossi@example.com',
            'help' => 'Inserisci un indirizzo email valido',
        ],
        'phone' => [
            'label' => 'Telefono',
            'tooltip' => 'Numero di telefono del contatto',
            'placeholder' => 'es: +39 123 456 7890',
            'help' => 'Inserisci il numero con prefisso internazionale',
        ],
        'telegram_chat_id' => [
            'label' => 'Chat ID Telegram',
            'tooltip' => 'ID della chat Telegram del contatto',
            'placeholder' => 'es: 123456789',
            'help' => 'ID numerico fornito dal bot Telegram',
        ],
        'group' => [
            'label' => 'Gruppo',
            'tooltip' => 'Gruppo di appartenenza del contatto',
            'placeholder' => 'es: Amministrazione',
            'help' => 'Seleziona il gruppo di appartenenza',
            'options' => [
                'admin' => [
                    'label' => 'Amministratore',
                    'tooltip' => 'Staff amministrativo',
                ],
                'user' => [
                    'label' => 'Utente',
                    'tooltip' => 'Utente standard',
                ],
                'support' => [
                    'label' => 'Supporto',
                    'tooltip' => 'Team di supporto',
                ],
            ],
        ],
        'channels' => [
            'label' => 'Canali',
            'tooltip' => 'Canali di notifica preferiti',
            'help' => 'Seleziona i canali per l\'invio delle notifiche',
            'options' => [
                'email' => [
                    'label' => 'Email',
                    'tooltip' => 'Notifiche via email',
                ],
                'sms' => [
                    'label' => 'SMS',
                    'tooltip' => 'Notifiche via SMS',
                ],
                'telegram' => [
                    'label' => 'Telegram',
                    'tooltip' => 'Notifiche via Telegram',
                ],
                'push' => [
                    'label' => 'Push',
                    'tooltip' => 'Notifiche push sul browser',
                ],
            ],
        ],
        'preferences' => [
            'label' => 'Preferenze',
            'tooltip' => 'Preferenze di notifica',
            'help' => 'Configura le preferenze personali',
            'options' => [
                'frequency' => [
                    'label' => 'Frequenza',
                    'tooltip' => 'Frequenza di invio delle notifiche',
                    'options' => [
                        'immediate' => [
                            'label' => 'Immediata',
                            'tooltip' => 'Invia le notifiche immediatamente',
                        ],
                        'daily' => [
                            'label' => 'Giornaliera',
                            'tooltip' => 'Raggruppa le notifiche in un digest giornaliero',
                        ],
                        'weekly' => [
                            'label' => 'Settimanale',
                            'tooltip' => 'Raggruppa le notifiche in un digest settimanale',
                        ],
                    ],
                ],
                'quiet_hours' => [
                    'label' => 'Ore di silenzio',
                    'tooltip' => 'Periodo in cui non inviare notifiche',
                    'help' => 'Le notifiche verranno inviate al termine del periodo',
                ],
            ],
        ],
        'is_active' => [
            'label' => 'Attivo',
            'tooltip' => 'Stato di attivazione del contatto',
            'help' => 'Disattiva temporaneamente le notifiche',
        ],
        'last_notified_at' => [
            'label' => 'Ultima notifica',
            'tooltip' => 'Data e ora dell\'ultima notifica inviata',
        ],
    ],
    'actions' => [
        'import' => [
            'name' => 'Importa da file',
            'fields' => [
                'import_file' => 'Seleziona un file XLS o CSV da caricare',
            ],
        ],
        'export' => [
            'name' => 'Esporta dati',
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => 'Nome area',
                'parent_name' => 'Nome area livello superiore',
            ],
        ],
        'test_notification' => [
            'label' => 'Invia test',
            'tooltip' => 'Invia una notifica di test',
            'icon' => 'heroicon-o-paper-airplane',
            'color' => 'primary',
            'confirmation' => [
                'title' => 'Conferma invio test',
                'message' => 'Vuoi inviare una notifica di test?',
                'confirm' => 'Sì, invia',
                'cancel' => 'No, annulla',
            ],
        ],
        'verify' => [
            'label' => 'Verifica contatto',
            'tooltip' => 'Verifica la validità del contatto',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'warning',
        ],
    ],
    'messages' => [
        'created' => [
            'title' => 'Contatto Creato',
            'message' => 'Il contatto è stato creato con successo',
        ],
        'updated' => [
            'title' => 'Contatto Aggiornato',
            'message' => 'Il contatto è stato aggiornato con successo',
        ],
        'deleted' => [
            'title' => 'Contatto Eliminato',
            'message' => 'Il contatto è stato eliminato con successo',
        ],
        'test_sent' => [
            'title' => 'Test Inviato',
            'message' => 'La notifica di test è stata inviata con successo',
        ],
        'test_failed' => [
            'title' => 'Errore Test',
            'message' => 'Impossibile inviare la notifica di test: :error',
        ],
        'verified' => [
            'title' => 'Verifica Completata',
            'message' => 'Il contatto è stato verificato con successo',
        ],
        'verification_failed' => [
            'title' => 'Errore Verifica',
            'message' => 'Impossibile verificare il contatto: :error',
        ],
    ],
];
