<?php

declare(strict_types=1);


return [
    'resource' => [
        'name' => 'Notifica',
    ],
    'navigation' => [
        'name' => 'Notifica',
        'plural' => 'Notifiche',
        'group' => 'Sistema',
        'label' => 'Notifiche',
        'icon' => 'notify-bell-animated',
        'sort' => '45',
    ],
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'tooltip' => 'Titolo della notifica',
            'placeholder' => 'es: Aggiornamento sistema',
            'help' => 'Inserisci un titolo chiaro e conciso',
        ],
        'message' => [
            'label' => 'Messaggio',
            'tooltip' => 'Contenuto della notifica',
            'placeholder' => 'es: Il sistema verrà aggiornato alle ore...',
            'help' => 'Inserisci il messaggio completo della notifica',
        ],
        'type' => [
            'label' => 'Tipo',
            'tooltip' => 'Tipo di notifica',
            'options' => [
                'system' => [
                    'label' => 'Sistema',
                    'tooltip' => 'Notifiche di sistema e manutenzione',
                ],
                'alert' => [
                    'label' => 'Avviso',
                    'tooltip' => 'Avvisi importanti',
                ],
                'info' => [
                    'label' => 'Informazione',
                    'tooltip' => 'Informazioni generali',
                ],
                'success' => [
                    'label' => 'Successo',
                    'tooltip' => 'Operazioni completate con successo',
                ],
                'warning' => [
                    'label' => 'Attenzione',
                    'tooltip' => 'Avvisi che richiedono attenzione',
                ],
                'error' => [
                    'label' => 'Errore',
                    'tooltip' => 'Errori e problemi',
                ],
            ],
        ],
        'status' => [
            'label' => 'Stato',
            'tooltip' => 'Stato corrente della notifica',
            'options' => [
                'unread' => [
                    'label' => 'Non letta',
                    'tooltip' => 'Notifica non ancora visualizzata',
                ],
                'read' => [
                    'label' => 'Letta',
                    'tooltip' => 'Notifica già visualizzata',
                ],
                'archived' => [
                    'label' => 'Archiviata',
                    'tooltip' => 'Notifica spostata nell\'archivio',
                ],
            ],
        ],
        'recipient' => [
            'label' => 'Destinatario',
            'tooltip' => 'Utente o gruppo destinatario della notifica',
            'placeholder' => 'es: mario.rossi@example.com',
            'help' => 'Seleziona uno o più destinatari',
        ],
        'sent_at' => [
            'label' => 'Inviata il',
            'tooltip' => 'Data e ora di invio della notifica',
        ],
        'read_at' => [
            'label' => 'Letta il',
            'tooltip' => 'Data e ora di lettura della notifica',
        ],
        'archived_at' => [
            'label' => 'Archiviata il',
            'tooltip' => 'Data e ora di archiviazione della notifica',
        ],
    ],
    'actions' => [
        'mark_as_read' => [
            'label' => 'Segna come letta',
            'tooltip' => 'Segna questa notifica come letta',
            'icon' => 'heroicon-o-check',
            'color' => 'success',
        ],
        'mark_as_unread' => [
            'label' => 'Segna come non letta',
            'tooltip' => 'Segna questa notifica come non letta',
            'icon' => 'heroicon-o-x-circle',
            'color' => 'warning',
        ],
        'archive' => [
            'label' => 'Archivia',
            'tooltip' => 'Sposta questa notifica nell\'archivio',
            'icon' => 'heroicon-o-archive-box',
            'color' => 'info',
        ],
        'unarchive' => [
            'label' => 'Ripristina',
            'tooltip' => 'Ripristina questa notifica dall\'archivio',
            'icon' => 'heroicon-o-archive-box-arrow-down',
            'color' => 'primary',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina definitivamente questa notifica',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'confirmation' => [
                'title' => 'Conferma eliminazione',
                'message' => 'Sei sicuro di voler eliminare questa notifica?',
                'confirm' => 'Sì, elimina',
                'cancel' => 'No, annulla',
            ],
        ],
        'mark_all_read' => [
            'label' => 'Segna tutte come lette',
            'tooltip' => 'Segna tutte le notifiche come lette',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'success',
        ],
        'archive_all' => [
            'label' => 'Archivia tutte',
            'tooltip' => 'Sposta tutte le notifiche nell\'archivio',
            'icon' => 'heroicon-o-archive-box-arrow-down',
            'color' => 'info',
            'confirmation' => [
                'title' => 'Conferma archiviazione',
                'message' => 'Sei sicuro di voler archiviare tutte le notifiche?',
                'confirm' => 'Sì, archivia tutte',
                'cancel' => 'No, annulla',
            ],
        ],
        'delete_all' => [
            'label' => 'Elimina tutte',
            'tooltip' => 'Elimina definitivamente tutte le notifiche',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'confirmation' => [
                'title' => 'Conferma eliminazione',
                'message' => 'Sei sicuro di voler eliminare tutte le notifiche?',
                'confirm' => 'Sì, elimina tutte',
                'cancel' => 'No, annulla',
            ],
        ],
    ],
    'messages' => [
        'no_notifications' => 'Nessuna notifica',
        'success_sent' => 'Notifica inviata con successo',
        'error_sent' => 'Errore nell\'invio della notifica',
    ],
    'filters' => [
        'all' => [
            'label' => 'Tutte',
            'tooltip' => 'Mostra tutte le notifiche',
        ],
        'unread' => [
            'label' => 'Non lette',
            'tooltip' => 'Mostra solo le notifiche non lette',
        ],
        'read' => [
            'label' => 'Lette',
            'tooltip' => 'Mostra solo le notifiche lette',
        ],
        'archived' => [
            'label' => 'Archiviate',
            'tooltip' => 'Mostra solo le notifiche archiviate',
        ],
        'type' => [
            'label' => 'Tipo',
            'tooltip' => 'Filtra per tipo di notifica',
        ],
        'date' => [
            'label' => 'Data',
            'tooltip' => 'Filtra per data',
        ],
    ],
    'badges' => [
        'unread' => [
            'label' => 'Non letta',
            'tooltip' => 'Questa notifica non è ancora stata letta',
        ],
        'priority' => [
            'label' => 'Priorità',
            'tooltip' => 'Livello di priorità della notifica',
            'options' => [
                'high' => [
                    'label' => 'Alta priorità',
                    'tooltip' => 'Richiede attenzione immediata',
                ],
                'medium' => [
                    'label' => 'Media priorità',
                    'tooltip' => 'Richiede attenzione in giornata',
                ],
                'low' => [
                    'label' => 'Bassa priorità',
                    'tooltip' => 'Può essere gestita in seguito',
                ],
            ],
        ],
    ],
    'template' => [
        'navigation' => [
            'label' => 'Template Notifiche',
            'plural' => 'Template Notifiche',
            'group' => 'Sistema',
        ],
        'form' => [
            'name' => [
                'label' => 'Nome',
                'helper' => 'Nome univoco del template',
            ],
            'subject' => [
                'label' => 'Oggetto',
                'helper' => 'Oggetto della notifica',
            ],
            'type' => [
                'label' => 'Tipo',
                'helper' => 'Tipo di notifica',
            ],
            'body_text' => [
                'label' => 'Testo',
                'helper' => 'Versione testuale della notifica',
            ],
            'body_html' => [
                'label' => 'HTML',
                'helper' => 'Versione HTML della notifica',
            ],
            'preview_data' => [
                'label' => 'Dati Preview',
                'helper' => 'Dati JSON per il preview',
            ],
            'attachments' => [
                'label' => 'Allegati',
                'helper' => 'Allegati alla notifica (max 5 file, 5MB ciascuno)',
            ],
        ],
        'preview' => [
            'title' => 'Anteprima Template',
            'subheading' => 'Visualizza come apparirà la notifica',
            'text_version' => 'Versione Testuale',
            'html_version' => 'Versione HTML',
        ],
    ],
    'enums' => [
        'notification_type' => [
            'email' => 'Email',
            'sms' => 'SMS',
            'push' => 'Notifica Push',
        ],
    ],
];
