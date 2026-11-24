<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Template Notifiche',
<<<<<<< HEAD
        'plural' => 'Template Notifiche',
    ],
=======
        'plural' => 'Template Notifiche'],
>>>>>>> laraxot/dev
    'navigation' => [
        'name' => 'Template Notifiche',
        'plural' => 'Template Notifiche',
        'group' => [
            'name' => 'Sistema',
<<<<<<< HEAD
            'description' => 'Gestione dei modelli per le notifiche',
        ],
        'label' => 'Template Notifiche',
        'icon' => 'notify-template-animated',
        'sort' => 48,
    ],
=======
            'description' => 'Gestione dei modelli per le notifiche'],
        'label' => 'Template Notifiche',
        'icon' => 'notify-template-animated',
        'sort' => 48],
>>>>>>> laraxot/dev
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome identificativo del template',
            'placeholder' => 'es: Notifica Scadenza',
            'helper_text' => 'Inserisci un nome descrittivo per il template',
            'help' => 'Inserisci un nome descrittivo per il template',
<<<<<<< HEAD
            'description' => '',
        ],
=======
            'description' => ''],
>>>>>>> laraxot/dev
        'description' => [
            'label' => 'Descrizione',
            'tooltip' => 'Descrizione del template',
            'placeholder' => 'es: Template per le notifiche di scadenza',
            'helper_text' => 'Breve descrizione dello scopo del template',
<<<<<<< HEAD
            'description' => '',
        ],
=======
            'description' => ''],
>>>>>>> laraxot/dev
        'type' => [
            'label' => 'Tipo',
            'tooltip' => 'Tipologia di notifica',
            'placeholder' => 'Seleziona il tipo di notifica',
            'helper_text' => 'Il tipo determina il canale di invio della notifica',
            'options' => [
                'email' => 'Email',
                'sms' => 'SMS',
                'push' => 'Notifica Push',
                'telegram' => 'Telegram',
<<<<<<< HEAD
                'whatsapp' => 'WhatsApp',
            ],
            'description' => '',
        ],
=======
                'whatsapp' => 'WhatsApp'],
            'description' => ''],
>>>>>>> laraxot/dev
        'subject' => [
            'label' => 'Oggetto',
            'tooltip' => 'Oggetto della notifica',
            'placeholder' => 'es: Promemoria appuntamento',
            'helper_text' => 'Oggetto visualizzato nella notifica (es. oggetto email]',
<<<<<<< HEAD
            'description' => '',
        ],
=======
            'description' => ''],
>>>>>>> laraxot/dev
        'content' => [
            'label' => 'Contenuto',
            'tooltip' => 'Corpo del messaggio',
            'placeholder' => 'Inserisci il testo del messaggio',
            'helper_text' => 'Contenuto principale della notifica',
<<<<<<< HEAD
            'description' => '',
        ],
=======
            'description' => ''],
>>>>>>> laraxot/dev
        'variables' => [
            'label' => 'Variabili',
            'tooltip' => 'Variabili disponibili',
            'placeholder' => '{{nome}}, {{email}}, ecc.',
            'helper_text' => 'Variabili che possono essere utilizzate nel template',
<<<<<<< HEAD
            'description' => '',
        ],
=======
            'description' => ''],
>>>>>>> laraxot/dev
        'is_active' => [
            'label' => 'Attivo',
            'tooltip' => 'Stato del template',
            'helper_text' => 'Se attivo, il template può essere utilizzato per l\'invio di notifiche',
<<<<<<< HEAD
            'description' => '',
        ],
=======
            'description' => ''],
>>>>>>> laraxot/dev
        'created_at' => [
            'label' => 'Data creazione',
            'tooltip' => 'Data di creazione del template',
            'helper_text' => '',
<<<<<<< HEAD
            'description' => '',
        ],
=======
            'description' => ''],
>>>>>>> laraxot/dev
        'updated_at' => [
            'label' => 'Ultima modifica',
            'tooltip' => 'Data dell\'ultima modifica del template',
            'helper_text' => '',
<<<<<<< HEAD
            'description' => '',
        ],
    ],
=======
            'description' => '']],
>>>>>>> laraxot/dev
    'actions' => [
        'preview' => [
            'label' => 'Anteprima',
            'tooltip' => 'Visualizza anteprima del template',
            'icon' => 'heroicon-o-eye',
            'success_message' => 'Anteprima generata con successo',
<<<<<<< HEAD
            'error_message' => 'Errore nella generazione dell\'anteprima',
        ],
=======
            'error_message' => 'Errore nella generazione dell\'anteprima'],
>>>>>>> laraxot/dev
        'duplicate' => [
            'label' => 'Duplica',
            'tooltip' => 'Crea una copia del template',
            'icon' => 'heroicon-o-document-duplicate',
            'success_message' => 'Template duplicato con successo',
<<<<<<< HEAD
            'error_message' => 'Errore nella duplicazione del template',
        ],
=======
            'error_message' => 'Errore nella duplicazione del template'],
>>>>>>> laraxot/dev
        'test' => [
            'label' => 'Test',
            'tooltip' => 'Invia una notifica di test',
            'icon' => 'heroicon-o-paper-airplane',
            'success_message' => 'Notifica di test inviata con successo',
<<<<<<< HEAD
            'error_message' => 'Errore nell\'invio della notifica di test',
        ],
    ],
=======
            'error_message' => 'Errore nell\'invio della notifica di test']],
>>>>>>> laraxot/dev
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
        'confirmation' => 'Sei sicuro di voler procedere con questa operazione?',
        'template_created' => 'Il template è stato creato con successo',
        'template_updated' => 'Il template è stato aggiornato con successo',
<<<<<<< HEAD
        'template_deleted' => 'Il template è stato eliminato con successo',
    ],
    'label' => 'Template',
    'plural_label' => 'Template (Plurale)',
    'form' => [
        'name' => [
            'helper' => 'Nome interno del modello, per ritrovarlo',
        ],
        'subject' => [
            'helper' => 'Oggetto del messaggio; puoi usare le variabili tra doppie graffe',
        ],
        'type' => [
            'helper' => 'Canale del messaggio',
        ],
        'body_text' => [
            'helper' => 'Versione solo testo',
        ],
        'body_html' => [
            'helper' => 'Versione HTML',
        ],
        'preview_data' => [
            'helper' => 'Dati di esempio in JSON per l\'anteprima',
        ],
        'attachments' => [
            'helper' => 'File allegati al messaggio',
        ],
    ],
];
=======
        'template_deleted' => 'Il template è stato eliminato con successo'],
    'label' => 'Template',
    'plural_label' => 'Template (Plurale)'];
>>>>>>> laraxot/dev
