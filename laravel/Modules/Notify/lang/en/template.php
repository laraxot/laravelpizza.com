<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter template name',
            'help' => 'The identifying name of the template',
            'tooltip' => 'This field is required',
<<<<<<< .merge_file_WVr7u3
            'helper_text' => 'Inserisci un nome descrittivo per il template',
            'description' => '',
        ],
=======
            'helper_text' => 'Enter a descriptive name for the template',
            'description' => ''],
>>>>>>> .merge_file_ZAlErC
        'subject' => [
            'label' => 'Subject',
            'placeholder' => 'Enter notification subject',
            'help' => 'The subject that will appear in the notification',
            'tooltip' => 'This field is required',
<<<<<<< .merge_file_WVr7u3
            'helper_text' => 'Oggetto visualizzato nella notifica (es. oggetto email)',
            'description' => '',
        ],
=======
            'helper_text' => 'Subject shown in the notification (e.g. email subject)',
            'description' => ''],
>>>>>>> .merge_file_ZAlErC
        'body_text' => [
            'label' => 'Text',
            'placeholder' => 'Enter notification text',
            'help' => 'The text content of the notification',
            'tooltip' => 'This field is required',
            'helper_text' => '',
            'description' => '',
        ],
        'body_html' => [
            'label' => 'HTML',
            'placeholder' => 'Enter notification HTML content',
            'help' => 'The HTML content of the notification',
            'tooltip' => 'This field is required',
            'helper_text' => '',
            'description' => '',
        ],
        'preview_data' => [
            'label' => 'Preview Data',
            'placeholder' => 'Enter preview data',
            'help' => 'The data used to display the preview',
            'tooltip' => 'JSON format',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
<<<<<<< .merge_file_WVr7u3
            'tooltip' => 'Descrizione del template',
            'placeholder' => 'es: Template per le notifiche di scadenza',
            'helper_text' => 'Breve descrizione dello scopo del template',
            'description' => '',
        ],
=======
            'tooltip' => 'Template description',
            'placeholder' => 'e.g. Template for expiry notifications',
            'helper_text' => 'Short description of the template\'s purpose',
            'description' => ''],
>>>>>>> .merge_file_ZAlErC
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
                'whatsapp' => 'WhatsApp',
            ],
            'description' => '',
        ],
        'content' => [
            'label' => 'Contenuto',
<<<<<<< .merge_file_WVr7u3
            'tooltip' => 'Corpo del messaggio',
            'placeholder' => 'Inserisci il testo del messaggio',
            'helper_text' => 'Contenuto principale della notifica',
            'description' => '',
        ],
=======
            'tooltip' => 'Message body',
            'placeholder' => 'Enter the message text',
            'helper_text' => 'Main notification content',
            'description' => ''],
>>>>>>> .merge_file_ZAlErC
        'variables' => [
            'label' => 'Variabili',
            'tooltip' => 'Variabili disponibili',
            'placeholder' => '{{nome}}, {{email}}, ecc.',
<<<<<<< .merge_file_WVr7u3
            'helper_text' => 'Variabili che possono essere utilizzate nel template',
            'description' => '',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'tooltip' => 'Stato del template',
            'helper_text' => 'Se attivo, il template può essere utilizzato per l\'invio di notifiche',
            'description' => '',
        ],
=======
            'helper_text' => 'Variables that can be used in the template',
            'description' => ''],
        'is_active' => [
            'label' => 'Active',
            'tooltip' => 'Template status',
            'helper_text' => 'If active, the template can be used to send notifications',
            'description' => ''],
>>>>>>> .merge_file_ZAlErC
        'created_at' => [
            'label' => 'Created at',
            'tooltip' => 'Template creation date',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima modifica',
            'tooltip' => 'Template last modified date',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'navigation' => [
        'label' => 'Notification Templates',
        'group' => [
            'name' => 'Sistema',
<<<<<<< .merge_file_WVr7u3
            'description' => 'Gestione dei modelli per le notifiche',
        ],
        'icon' => 'heroicon-o-bell',
        'name' => 'Template Notifiche',
        'plural' => 'Template Notifiche',
        'sort' => '48',
    ],
=======
            'description' => 'Manage notification templates'],
        'icon' => 'heroicon-o-bell',
        'name' => 'Notification Templates',
        'plural' => 'Notification Templates',
        'sort' => '48'],
>>>>>>> .merge_file_ZAlErC
    'messages' => [
        'success' => [
            'created' => 'Template created successfully',
            'updated' => 'Template updated successfully',
            'deleted' => 'Template deleted successfully',
        ],
        'errors' => [
            'not_found' => 'Template not found',
<<<<<<< .merge_file_WVr7u3
            'unauthorized' => 'Unauthorized',
        ],
        'error' => 'Si è verificato un errore durante l\'operazione',
        'confirmation' => 'Sei sicuro di voler procedere con questa operazione?',
        'template_created' => 'Il template è stato creato con successo',
        'template_updated' => 'Il template è stato aggiornato con successo',
        'template_deleted' => 'Il template è stato eliminato con successo',
    ],
    'resource' => [
        'name' => 'Template Notifiche',
        'plural' => 'Template Notifiche',
    ],
=======
            'unauthorized' => 'Unauthorized'],
        'error' => 'An error occurred during the operation',
        'confirmation' => 'Are you sure you want to proceed with this operation?',
        'template_created' => 'The template was created successfully',
        'template_updated' => 'The template was updated successfully',
        'template_deleted' => 'The template was deleted successfully'],
    'resource' => [
        'name' => 'Notification Templates',
        'plural' => 'Notification Templates'],
>>>>>>> .merge_file_ZAlErC
    'actions' => [
        'preview' => [
            'label' => 'Anteprima',
            'tooltip' => 'Preview the template',
            'icon' => 'heroicon-o-eye',
<<<<<<< .merge_file_WVr7u3
            'success_message' => 'Anteprima generata con successo',
            'error_message' => 'Errore nella generazione dell\'anteprima',
        ],
=======
            'success_message' => 'Preview generated successfully',
            'error_message' => 'Error generating the preview'],
>>>>>>> .merge_file_ZAlErC
        'duplicate' => [
            'label' => 'Duplica',
            'tooltip' => 'Create a copy of the template',
            'icon' => 'heroicon-o-document-duplicate',
<<<<<<< .merge_file_WVr7u3
            'success_message' => 'Template duplicato con successo',
            'error_message' => 'Errore nella duplicazione del template',
        ],
=======
            'success_message' => 'Template duplicated successfully',
            'error_message' => 'Error duplicating the template'],
>>>>>>> .merge_file_ZAlErC
        'test' => [
            'label' => 'Test',
            'tooltip' => 'Send a test notification',
            'icon' => 'heroicon-o-paper-airplane',
<<<<<<< .merge_file_WVr7u3
            'success_message' => 'Notifica di test inviata con successo',
            'error_message' => 'Errore nell\'invio della notifica di test',
        ],
    ],
=======
            'success_message' => 'Test notification sent successfully',
            'error_message' => 'Error sending the test notification']],
>>>>>>> .merge_file_ZAlErC
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'form' => [
        'name' => [
            'helper' => 'Internal name, to find the template again',
        ],
        'subject' => [
            'helper' => 'Message subject; you can use variables in double braces',
        ],
        'type' => [
            'helper' => 'Message channel',
        ],
        'body_text' => [
            'helper' => 'Plain text version',
        ],
        'body_html' => [
            'helper' => 'HTML version',
        ],
        'preview_data' => [
            'helper' => 'Sample JSON data for the preview',
        ],
        'attachments' => [
            'helper' => 'Files attached to the message',
        ],
    ],
];
