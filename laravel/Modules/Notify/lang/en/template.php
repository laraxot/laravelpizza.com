<?php

declare(strict_types=1);

return [
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
    'resource' => [
        'name' => 'Template Notifiche',
        'plural' => 'Template Notifiche',
    ],
    'navigation' => [
        'name' => 'Template Notifiche',
        'plural' => 'Template Notifiche',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Gestione dei modelli per le notifiche',
        ],
        'label' => 'Template Notifiche',
        'icon' => 'notify-template-animated',
        'sort' => 48,
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome identificativo del template',
            'placeholder' => 'es: Notifica Scadenza',
            'helper_text' => 'Inserisci un nome descrittivo per il template',
            'help' => 'Inserisci un nome descrittivo per il template',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'tooltip' => 'Descrizione del template',
            'placeholder' => 'es: Template per le notifiche di scadenza',
            'helper_text' => 'Breve descrizione dello scopo del template',
            'description' => '',
        ],
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
                'whatsapp' => 'WhatsApp',
            ],
            'description' => '',
        ],
        'subject' => [
            'label' => 'Oggetto',
            'tooltip' => 'Oggetto della notifica',
            'placeholder' => 'es: Promemoria appuntamento',
            'helper_text' => 'Oggetto visualizzato nella notifica (es. oggetto email]',
            'description' => '',
        ],
        'content' => [
            'label' => 'Contenuto',
            'tooltip' => 'Corpo del messaggio',
            'placeholder' => 'Inserisci il testo del messaggio',
            'helper_text' => 'Contenuto principale della notifica',
            'description' => '',
        ],
<<<<<<< HEAD
=======
=======
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter template name',
            'help' => 'The identifying name of the template',
            'tooltip' => 'This field is required',
            'helper_text' => 'Enter a descriptive name for the template',
            'description' => ''],
        'subject' => [
            'label' => 'Subject',
            'placeholder' => 'Enter notification subject',
            'help' => 'The subject that will appear in the notification',
            'tooltip' => 'This field is required',
            'helper_text' => 'Subject shown in the notification (e.g. email subject)',
            'description' => ''],
        'body_text' => [
            'label' => 'Text',
            'placeholder' => 'Enter notification text',
            'help' => 'The text content of the notification',
            'tooltip' => 'This field is required',
            'helper_text' => '',
            'description' => ''],
        'body_html' => [
            'label' => 'HTML',
            'placeholder' => 'Enter notification HTML content',
            'help' => 'The HTML content of the notification',
            'tooltip' => 'This field is required',
            'helper_text' => '',
            'description' => ''],
        'preview_data' => [
            'label' => 'Preview Data',
            'placeholder' => 'Enter preview data',
            'help' => 'The data used to display the preview',
            'tooltip' => 'JSON format',
            'helper_text' => '',
            'description' => ''],
        'description' => [
            'label' => 'Descrizione',
            'tooltip' => 'Template description',
            'placeholder' => 'e.g. Template for expiry notifications',
            'helper_text' => 'Short description of the template\'s purpose',
            'description' => ''],
        'type' => [
            'label' => 'Tipo',
            'tooltip' => 'Notification type',
            'placeholder' => 'Select the notification type',
            'helper_text' => 'The type determines the channel used to send the notification',
            'options' => [
                'email' => 'Email',
                'sms' => 'SMS',
                'push' => 'Push Notification',
                'telegram' => 'Telegram',
                'whatsapp' => 'WhatsApp'],
            'description' => ''],
        'content' => [
            'label' => 'Contenuto',
            'tooltip' => 'Message body',
            'placeholder' => 'Enter the message text',
            'helper_text' => 'Main notification content',
            'description' => ''],
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
        'variables' => [
            'label' => 'Variabili',
            'tooltip' => 'Variabili disponibili',
            'placeholder' => '{{nome}}, {{email}}, ecc.',
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
            'helper_text' => 'Variabili che possono essere utilizzate nel template',
            'description' => '',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'tooltip' => 'Stato del template',
            'helper_text' => 'Se attivo, il template può essere utilizzato per l\'invio di notifiche',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data creazione',
            'tooltip' => 'Data di creazione del template',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima modifica',
            'tooltip' => 'Data dell\'ultima modifica del template',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'preview' => [
            'label' => 'Anteprima',
            'tooltip' => 'Visualizza anteprima del template',
            'icon' => 'heroicon-o-eye',
            'success_message' => 'Anteprima generata con successo',
            'error_message' => 'Errore nella generazione dell\'anteprima',
        ],
        'duplicate' => [
            'label' => 'Duplica',
            'tooltip' => 'Crea una copia del template',
            'icon' => 'heroicon-o-document-duplicate',
            'success_message' => 'Template duplicato con successo',
            'error_message' => 'Errore nella duplicazione del template',
        ],
        'test' => [
            'label' => 'Test',
            'tooltip' => 'Invia una notifica di test',
            'icon' => 'heroicon-o-paper-airplane',
            'success_message' => 'Notifica di test inviata con successo',
            'error_message' => 'Errore nell\'invio della notifica di test',
        ],
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
        'confirmation' => 'Sei sicuro di voler procedere con questa operazione?',
        'template_created' => 'Il template è stato creato con successo',
        'template_updated' => 'Il template è stato aggiornato con successo',
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
<<<<<<< HEAD
=======
=======
            'helper_text' => 'Variables that can be used in the template',
            'description' => ''],
        'is_active' => [
            'label' => 'Active',
            'tooltip' => 'Template status',
            'helper_text' => 'If active, the template can be used to send notifications',
            'description' => ''],
        'created_at' => [
            'label' => 'Created at',
            'tooltip' => 'Template creation date',
            'helper_text' => '',
            'description' => ''],
        'updated_at' => [
            'label' => 'Ultima modifica',
            'tooltip' => 'Template last modified date',
            'helper_text' => '',
            'description' => '']],
    'navigation' => [
        'label' => 'Notification Templates',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Manage notification templates'],
        'icon' => 'heroicon-o-bell',
        'name' => 'Notification Templates',
        'plural' => 'Notification Templates',
        'sort' => '48'],
    'messages' => [
        'success' => [
            'created' => 'Template created successfully',
            'updated' => 'Template updated successfully',
            'deleted' => 'Template deleted successfully'],
        'errors' => [
            'not_found' => 'Template not found',
            'unauthorized' => 'Unauthorized'],
        'error' => 'An error occurred during the operation',
        'confirmation' => 'Are you sure you want to proceed with this operation?',
        'template_created' => 'The template was created successfully',
        'template_updated' => 'The template was updated successfully',
        'template_deleted' => 'The template was deleted successfully'],
    'resource' => [
        'name' => 'Notification Templates',
        'plural' => 'Notification Templates'],
    'actions' => [
        'preview' => [
            'label' => 'Anteprima',
            'tooltip' => 'Preview the template',
            'icon' => 'heroicon-o-eye',
            'success_message' => 'Preview generated successfully',
            'error_message' => 'Error generating the preview'],
        'duplicate' => [
            'label' => 'Duplica',
            'tooltip' => 'Create a copy of the template',
            'icon' => 'heroicon-o-document-duplicate',
            'success_message' => 'Template duplicated successfully',
            'error_message' => 'Error duplicating the template'],
        'test' => [
            'label' => 'Test',
            'tooltip' => 'Send a test notification',
            'icon' => 'heroicon-o-paper-airplane',
            'success_message' => 'Test notification sent successfully',
            'error_message' => 'Error sending the test notification']],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label'];
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
