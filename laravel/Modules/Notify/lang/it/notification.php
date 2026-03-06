<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Notifica',
        'plural' => 'Notifiche',
    ],
    'navigation' => [
        'name' => 'Gestione Notifiche',
        'plural' => 'Gestione Notifiche',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Gestione centralizzata delle notifiche di sistema',
        ],
        'label' => 'Gestione Notifiche',
        'icon' => 'notify-notification-animated',
        'sort' => 46,
    ],
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'helper_text' => 'Titolo della notifica',
            'placeholder' => 'Inserisci il titolo',
            'tooltip' => '',
            'description' => '',
        ],
        'message' => [
            'label' => 'Messaggio',
            'helper_text' => 'Contenuto della notifica',
            'placeholder' => 'Inserisci il messaggio',
            'tooltip' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Tipo',
            'helper_text' => 'Tipologia di notifica',
            'placeholder' => 'Seleziona il tipo',
            'options' => [
                'system' => 'Sistema',
                'alert' => 'Avviso',
                'info' => 'Informazione',
                'success' => 'Successo',
                'warning' => 'Attenzione',
                'error' => 'Errore',
            ],
            'tooltip' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'helper_text' => 'Stato corrente della notifica',
            'placeholder' => 'Seleziona lo stato',
            'options' => [
                'unread' => 'Non letta',
                'read' => 'Letta',
                'archived' => 'Archiviata',
            ],
            'tooltip' => '',
            'description' => '',
        ],
        'recipient' => [
            'label' => 'Destinatario',
            'helper_text' => 'Utente destinatario della notifica',
            'placeholder' => 'Seleziona il destinatario',
            'tooltip' => '',
            'description' => '',
        ],
        'sent_at' => [
            'label' => 'Inviata il',
            'helper_text' => 'Data e ora di invio della notifica',
            'tooltip' => '',
            'description' => '',
        ],
        'read_at' => [
            'label' => 'Letta il',
            'helper_text' => 'Data e ora di lettura della notifica',
            'tooltip' => '',
            'description' => '',
            'placeholder' => 'read_at',
        ],
        'archived_at' => [
            'label' => 'Archiviata il',
            'helper_text' => 'Data e ora di archiviazione della notifica',
            'tooltip' => '',
            'description' => '',
        ],
        'channel' => [
            'label' => 'Canale',
            'tooltip' => 'Canale di invio della notifica',
            'helper_text' => 'Seleziona il canale attraverso cui inviare la notifica',
            'placeholder' => 'Seleziona un canale',
            'options' => [
                'email' => [
                    'label' => 'Email',
                    'tooltip' => 'Invia tramite email',
                ],
                'sms' => [
                    'label' => 'SMS',
                    'tooltip' => 'Invia tramite SMS',
                ],
                'push' => [
                    'label' => 'Push',
                    'tooltip' => 'Invia come notifica push',
                ],
                'telegram' => [
                    'label' => 'Telegram',
                    'tooltip' => 'Invia tramite Telegram',
                ],
            ],
            'description' => '',
        ],
        'template' => [
            'label' => 'Template',
            'tooltip' => 'Template da utilizzare per la notifica',
            'helper_text' => 'Scegli il modello predefinito per questa notifica',
            'placeholder' => 'Seleziona un template',
            'options' => [
                'subject' => [
                    'label' => 'Oggetto',
                    'tooltip' => 'Oggetto della notifica',
                    'placeholder' => 'es: Notifica importante',
                ],
                'body' => [
                    'label' => 'Corpo',
                    'tooltip' => 'Contenuto principale della notifica',
                    'placeholder' => 'Inserisci il testo della notifica...',
                ],
                'variables' => [
                    'label' => 'Variabili disponibili',
                    'tooltip' => 'Variabili che possono essere utilizzate nel template',
                    'helper_text' => 'Usa {variable} per inserire valori dinamici',
                ],
            ],
            'description' => '',
        ],
        'schedule' => [
            'label' => 'Programmazione',
            'tooltip' => 'Quando inviare la notifica',
            'helper_text' => 'Imposta quando la notifica deve essere inviata',
            'placeholder' => 'Seleziona l\'opzione di programmazione',
            'options' => [
                'immediate' => [
                    'label' => 'Immediata',
                    'tooltip' => 'Invia subito la notifica',
                ],
                'scheduled' => [
                    'label' => 'Programmata',
                    'tooltip' => 'Programma l\'invio per una data specifica',
                ],
                'date' => [
                    'label' => 'Data',
                    'tooltip' => 'Data di invio programmato',
                    'placeholder' => 'es: 01/01/2024',
                ],
                'time' => [
                    'label' => 'Ora',
                    'tooltip' => 'Ora di invio programmato',
                    'placeholder' => 'es: 14:30',
                ],
            ],
            'description' => '',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'id' => [
            'label' => 'id',
        ],
        'notifiable' => [
            'name' => [
                'label' => 'notifiable.name',
            ],
        ],
        'data' => [
            'label' => 'data',
            'placeholder' => 'data',
            'helper_text' => 'data',
            'description' => 'data',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'is_read' => [
            'label' => 'is_read',
        ],
        'is_unread' => [
            'label' => 'is_unread',
        ],
        'notifiable_type' => [
            'label' => 'notifiable_type',
            'placeholder' => 'notifiable_type',
            'helper_text' => 'notifiable_type',
            'description' => 'notifiable_type',
        ],
        'notifiable_id' => [
            'label' => 'notifiable_id',
            'placeholder' => 'notifiable_id',
            'helper_text' => 'notifiable_id',
            'description' => 'notifiable_id',
        ],
        'created_by' => [
            'label' => 'created_by',
            'placeholder' => 'created_by',
            'helper_text' => 'created_by',
            'description' => 'created_by',
        ],
        'updated_by' => [
            'label' => 'updated_by',
            'placeholder' => 'updated_by',
            'helper_text' => 'updated_by',
            'description' => 'updated_by',
        ],
    ],
    'actions' => [
        'mark_as_read' => [
            'label' => 'Segna come letta',
            'tooltip' => 'Marca la notifica come letta',
            'success_message' => 'Notifica segnata come letta',
            'error_message' => 'Errore nel segnare la notifica come letta',
        ],
        'mark_as_unread' => [
            'label' => 'Segna come non letta',
            'tooltip' => 'Marca la notifica come non letta',
            'success_message' => 'Notifica segnata come non letta',
            'error_message' => 'Errore nel segnare la notifica come non letta',
        ],
        'archive' => [
            'label' => 'Archivia',
            'tooltip' => 'Archivia la notifica',
            'success_message' => 'Notifica archiviata con successo',
            'error_message' => 'Errore nell\'archiviazione della notifica',
        ],
        'unarchive' => [
            'label' => 'Ripristina',
            'tooltip' => 'Ripristina la notifica archiviata',
            'success_message' => 'Notifica ripristinata con successo',
            'error_message' => 'Errore nel ripristino della notifica',
        ],
        'send' => [
            'label' => 'Invia',
            'tooltip' => 'Invia la notifica',
            'success_message' => 'Notifica inviata con successo',
            'error_message' => 'Errore nell\'invio della notifica',
        ],
        'resend' => [
            'label' => 'Invia nuovamente',
            'tooltip' => 'Invia nuovamente la notifica',
            'success_message' => 'Notifica inviata nuovamente con successo',
            'error_message' => 'Errore nell\'invio della notifica',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina definitivamente la notifica',
            'success_message' => 'Notifica eliminata con successo',
            'error_message' => 'Errore nell\'eliminazione della notifica',
            'confirmation' => 'Sei sicuro di voler eliminare questa notifica? Questa azione non può essere annullata.',
        ],
    ],
    'messages' => [
        'no_notifications' => 'Non hai notifiche',
        'all_read' => 'Tutte le notifiche sono state lette',
        'mark_all_read' => 'Segna tutte come lette',
        'notification_sent' => 'Notifica inviata con successo',
        'notification_error' => 'Si è verificato un errore durante l\'invio della notifica',
        'delete_confirmation' => 'Sei sicuro di voler eliminare questa notifica?',
        'batch_action_confirmation' => 'Sei sicuro di voler eseguire questa azione su tutte le notifiche selezionate?',
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
    ],
    'label' => 'Notification',
    'plural_label' => 'Notification (Plurale)',
];
