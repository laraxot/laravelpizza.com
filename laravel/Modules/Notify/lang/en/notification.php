<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Notifica',
        'plural' => 'Notifiche',
    ],
    'navigation' => [
        'name' => 'Notification Management',
        'plural' => 'Notification Management',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Gestione centralizzata delle notifiche di sistema',
        ],
        'label' => 'Gestione Notifiche',
        'icon' => 'notify-notification-animated',
        'sort' => '46',
    ],
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'helper_text' => 'Notification title',
            'placeholder' => 'Enter the title',
            'tooltip' => '',
            'description' => '',
        ],
        'message' => [
            'label' => 'Message',
            'helper_text' => 'Notification content',
            'placeholder' => 'Enter the message',
            'tooltip' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Tipo',
            'helper_text' => 'Notification type',
            'placeholder' => 'Select the type',
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
            'label' => 'Status',
            'helper_text' => 'Current notification status',
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
            'label' => 'Recipient',
            'helper_text' => 'User receiving the notification',
            'placeholder' => 'Select the recipient',
            'tooltip' => '',
            'description' => '',
        ],
        'sent_at' => [
            'label' => 'Sent at',
            'helper_text' => 'Notification send date and time',
            'tooltip' => '',
            'description' => '',
        ],
        'read_at' => [
            'label' => 'Read at',
            'helper_text' => 'Notification read date and time',
            'tooltip' => '',
            'description' => '',
        ],
        'archived_at' => [
            'label' => 'Archived at',
            'helper_text' => 'Notification archive date and time',
            'tooltip' => '',
            'description' => '',
        ],
        'channel' => [
            'label' => 'Channel',
            'tooltip' => 'Channel used to send the notification',
            'helper_text' => 'Select the channel to send the notification through',
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
            'tooltip' => 'Template to use for the notification',
            'helper_text' => 'Choose the default template for this notification',
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
            'tooltip' => 'When to send the notification',
            'helper_text' => 'Set when the notification should be sent',
            'placeholder' => 'Select the scheduling option',
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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
        'all_read' => 'All notifications have been read',
        'mark_all_read' => 'Segna tutte come lette',
        'notification_sent' => 'Notifica inviata con successo',
        'notification_error' => 'Si è verificato un errore durante l\'invio della notifica',
        'delete_confirmation' => 'Sei sicuro di voler eliminare questa notifica?',
        'batch_action_confirmation' => 'Sei sicuro di voler eseguire questa azione su tutte le notifiche selezionate?',
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
