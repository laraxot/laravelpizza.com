<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Notification',
    ],
    'navigation' => [
        'name' => 'Notification',
        'plural' => 'Notifications',
        'group' => 'Sistema',
        'label' => 'Notifications',
        'icon' => 'notify-bell-animated',
        'sort' => '45',
    ],
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'tooltip' => 'Notification title',
            'placeholder' => 'e.g. System update',
            'help' => 'Enter a clear, concise title',
            'helper_text' => '',
            'description' => '',
        ],
        'message' => [
            'label' => 'Message',
            'tooltip' => 'Notification content',
            'placeholder' => 'e.g. The system will be updated at...',
            'help' => 'Enter the full notification message',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Tipo',
            'tooltip' => 'Notification type',
            'options' => [
                'system' => [
                    'label' => 'Sistema',
                    'tooltip' => 'System and maintenance notifications',
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
                    'tooltip' => 'Operations completed successfully',
                ],
                'warning' => [
                    'label' => 'Attenzione',
                    'tooltip' => 'Warnings that need attention',
                ],
                'error' => [
                    'label' => 'Error',
                    'tooltip' => 'Errori e problemi',
                ],
            ],
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => 'Current notification status',
            'options' => [
                'unread' => [
                    'label' => 'Non letta',
                    'tooltip' => 'Notification not yet viewed',
                ],
                'read' => [
                    'label' => 'Letta',
                    'tooltip' => 'Notification already viewed',
                ],
                'archived' => [
                    'label' => 'Archiviata',
                    'tooltip' => 'Notification moved to the archive',
                ],
            ],
            'helper_text' => '',
            'description' => '',
        ],
        'recipient' => [
            'label' => 'Recipient',
            'tooltip' => 'User or group receiving the notification',
            'placeholder' => 'es: mario.rossi@example.com',
            'help' => 'Select one or more recipients',
            'helper_text' => '',
            'description' => '',
        ],
        'sent_at' => [
            'label' => 'Sent at',
            'tooltip' => 'Notification send date and time',
            'helper_text' => '',
            'description' => '',
        ],
        'read_at' => [
            'label' => 'Read at',
            'tooltip' => 'Notification read date and time',
            'helper_text' => '',
            'description' => '',
        ],
        'archived_at' => [
            'label' => 'Archived at',
            'tooltip' => 'Notification archive date and time',
            'helper_text' => '',
            'description' => '',
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
            'label' => 'Mark as unread',
            'tooltip' => 'Mark this notification as unread',
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
            'label' => 'Delete',
            'tooltip' => 'Permanently delete this notification',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'confirmation' => [
                'title' => 'Conferma eliminazione',
                'message' => 'Are you sure you want to delete this notification?',
                'confirm' => 'Yes, delete',
                'cancel' => 'No, annulla',
            ],
        ],
        'mark_all_read' => [
            'label' => 'Segna tutte come lette',
            'tooltip' => 'Mark all notifications as read',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'success',
        ],
        'archive_all' => [
            'label' => 'Archivia tutte',
            'tooltip' => 'Move all notifications to the archive',
            'icon' => 'heroicon-o-archive-box-arrow-down',
            'color' => 'info',
            'confirmation' => [
                'title' => 'Conferma archiviazione',
                'message' => 'Are you sure you want to archive all notifications?',
                'confirm' => 'Yes, archive all',
                'cancel' => 'No, annulla',
            ],
        ],
        'delete_all' => [
            'label' => 'Delete all',
            'tooltip' => 'Permanently delete all notifications',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'confirmation' => [
                'title' => 'Conferma eliminazione',
                'message' => 'Are you sure you want to delete all notifications?',
                'confirm' => 'Yes, delete all',
                'cancel' => 'No, annulla',
            ],
        ],
    ],
    'messages' => [
        'no_notifications' => 'No notifications',
        'success_sent' => 'Notification sent successfully',
        'error_sent' => 'Error sending the notification',
    ],
    'filters' => [
        'all' => [
            'label' => 'All',
            'tooltip' => 'Show all notifications',
        ],
        'unread' => [
            'label' => 'Non lette',
            'tooltip' => 'Show only unread notifications',
        ],
        'read' => [
            'label' => 'Lette',
            'tooltip' => 'Show only read notifications',
        ],
        'archived' => [
            'label' => 'Archiviate',
            'tooltip' => 'Show only archived notifications',
        ],
        'type' => [
            'label' => 'Tipo',
            'tooltip' => 'Filter by notification type',
        ],
        'date' => [
            'label' => 'Date',
            'tooltip' => 'Filter by date',
        ],
    ],
    'badges' => [
        'unread' => [
            'label' => 'Non letta',
            'tooltip' => 'This notification has not been read yet',
        ],
        'priority' => [
            'label' => 'Priority',
            'tooltip' => 'Notification priority level',
            'options' => [
                'high' => [
                    'label' => 'High priority',
                    'tooltip' => 'Richiede attenzione immediata',
                ],
                'medium' => [
                    'label' => 'Medium priority',
                    'tooltip' => 'Richiede attenzione in giornata',
                ],
                'low' => [
                    'label' => 'Low priority',
                    'tooltip' => 'Can be handled later',
                ],
            ],
        ],
    ],
    'template' => [
        'navigation' => [
            'label' => 'Notification Templates',
            'plural' => 'Notification Templates',
            'group' => 'Sistema',
        ],
        'form' => [
            'name' => [
                'label' => 'Name',
                'helper' => 'Unique template name',
            ],
            'subject' => [
                'label' => 'Subject',
                'helper' => 'Notification subject',
            ],
            'type' => [
                'label' => 'Tipo',
                'helper' => 'Notification type',
            ],
            'body_text' => [
                'label' => 'Text',
                'helper' => 'Plain-text version of the notification',
            ],
            'body_html' => [
                'label' => 'HTML',
                'helper' => 'HTML version of the notification',
            ],
            'preview_data' => [
                'label' => 'Dati Preview',
                'helper' => 'JSON data for the preview',
            ],
            'attachments' => [
                'label' => 'Allegati',
                'helper' => 'Allegati alla notifica (max 5 file, 5MB ciascuno)',
            ],
        ],
        'preview' => [
            'title' => 'Anteprima Template',
            'subheading' => 'Show how the notification will look',
            'text_version' => 'Versione Testuale',
            'html_version' => 'Versione HTML',
        ],
    ],
    'enums' => [
        'notification_type' => [
            'email' => 'Email',
            'sms' => 'SMS',
            'push' => 'Push Notification',
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'alert' => [
        'sent' => [
            'message' => 'Alert Sent',
        ],
    ],
];
