<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Template Email',
        'plural' => 'Template Email',
        'label' => 'Template Email',
        'group' => 'Configurazione',
        'icon' => 'heroicon-o-envelope',
        'sort' => 90,
    ],
    'label' => 'Template Email',
    'plural_label' => 'Template Email',
    'fields' => [
        'mailable' => [
            'label' => 'Classe Mailable',
            'placeholder' => 'Es: Modules\\Progressioni\\Mail\\WelcomeMail',
            'help' => 'FQCN della classe Mailable Laravel',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Nome descrittivo del template',
            'help' => 'Nome leggibile per identificare il template',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'progressioni-benvenuto',
            'help' => 'Identificativo univoco URL-friendly',
        ],
        'subject' => [
            'label' => 'Oggetto',
            'placeholder' => 'Oggetto dell\'email',
            'help' => 'Testo dell\'oggetto email (supporta variabili {{name}})',
        ],
        'html_template' => [
            'label' => 'Template HTML',
            'placeholder' => 'Template HTML dell\'email',
            'help' => 'Corpo email in formato HTML (supporta variabili)',
        ],
        'text_template' => [
            'label' => 'Template Testo',
            'placeholder' => 'Template testo semplice',
            'help' => 'Versione testo semplice dell\'email',
        ],
        'sms_template' => [
            'label' => 'Template SMS',
            'placeholder' => 'Template per SMS',
            'help' => 'Template per notifiche SMS (opzionale)',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Template',
            'success' => 'Template creato con successo',
            'error' => 'Errore durante la creazione del template',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Template aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Template eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
            'confirmation' => 'Sei sicuro di voler eliminare questo template?',
            'tooltip' => 'delete',
            'icon' => 'delete',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'cancel',
            'label' => 'cancel',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'save' => [
            'tooltip' => 'save',
            'icon' => 'save',
            'label' => 'save',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'activeLocale' => [
            'tooltip' => 'activeLocale',
        ],
        'applyTableColumnManager' => [
            'tooltip' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
        ],
    ],
];
