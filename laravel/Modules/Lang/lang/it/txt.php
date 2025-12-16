<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci la tua email',
            'tooltip' => 'Usa un indirizzo email valido',
            'icon' => 'heroicon-o-mail',
            'description' => 'email',
            'helper_text' => '',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la tua password',
            'tooltip' => 'La password deve contenere almeno 8 caratteri',
            'icon' => 'heroicon-o-lock-closed',
            'description' => 'password',
            'helper_text' => '',
        ],
        'remember' => [
            'label' => 'Ricordami',
            'tooltip' => 'Mantieni l\'accesso attivo su questo dispositivo',
            'description' => 'remember',
            'helper_text' => '',
            'placeholder' => 'remember',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'options' => [
            'prefix-icon-color' => [
                'description' => 'options.prefix-icon-color',
                'helper_text' => 'options.prefix-icon-color',
                'placeholder' => 'options.prefix-icon-color',
                'label' => 'options.prefix-icon-color',
            ],
            'allow_multiple' => [
                'description' => 'options.allow_multiple',
                'label' => 'options.allow_multiple',
                'placeholder' => 'options.allow_multiple',
                'helper_text' => 'options.allow_multiple',
            ],
            'visibility' => [
                'values' => [
                    'description' => 'options.visibility.values',
                    'label' => 'options.visibility.values',
                    'placeholder' => 'options.visibility.values',
                    'helper_text' => 'options.visibility.values',
                ],
                'active' => [
                    'label' => 'options.visibility.active',
                    'placeholder' => 'options.visibility.active',
                    'helper_text' => 'options.visibility.active',
                    'description' => 'options.visibility.active',
                ],
                'fieldID' => [
                    'label' => 'options.visibility.fieldID',
                    'placeholder' => 'options.visibility.fieldID',
                    'helper_text' => 'options.visibility.fieldID',
                    'description' => 'options.visibility.fieldID',
                ],
            ],
            'confirmation-message' => [
                'label' => 'options.confirmation-message',
                'placeholder' => 'options.confirmation-message',
                'helper_text' => 'options.confirmation-message',
                'description' => 'options.confirmation-message',
            ],
            'require-login' => [
                'label' => 'options.require-login',
                'placeholder' => 'options.require-login',
                'helper_text' => 'options.require-login',
                'description' => 'options.require-login',
            ],
            'one-entry-per-user' => [
                'label' => 'options.one-entry-per-user',
                'placeholder' => 'options.one-entry-per-user',
                'helper_text' => 'options.one-entry-per-user',
                'description' => 'options.one-entry-per-user',
            ],
            'show-as' => [
                'label' => 'options.show-as',
                'placeholder' => 'options.show-as',
                'helper_text' => 'options.show-as',
                'description' => 'options.show-as',
            ],
            'emails-notification' => [
                'label' => 'options.emails-notification',
                'placeholder' => 'options.emails-notification',
                'helper_text' => 'options.emails-notification',
                'description' => 'options.emails-notification',
            ],
            'primary_color' => [
                'label' => 'options.primary_color',
                'placeholder' => 'options.primary_color',
                'helper_text' => 'options.primary_color',
                'description' => 'options.primary_color',
            ],
            'logo' => [
                'label' => 'options.logo',
                'placeholder' => 'options.logo',
                'helper_text' => 'options.logo',
                'description' => 'options.logo',
            ],
            'cover' => [
                'label' => 'options.cover',
                'placeholder' => 'options.cover',
                'helper_text' => 'options.cover',
                'description' => 'options.cover',
            ],
            'prefix-icon' => [
                'description' => 'options.prefix-icon',
                'helper_text' => 'options.prefix-icon',
                'placeholder' => 'options.prefix-icon',
                'label' => 'options.prefix-icon',
            ],
            'htmlId' => [
                'label' => 'options.htmlId',
                'placeholder' => 'options.htmlId',
                'helper_text' => 'options.htmlId',
                'description' => 'options.htmlId',
            ],
            'hint' => [
                'text' => [
                    'label' => 'options.hint.text',
                    'placeholder' => 'options.hint.text',
                    'helper_text' => 'options.hint.text',
                    'description' => 'options.hint.text',
                ],
                'icon' => [
                    'label' => 'options.hint.icon',
                    'placeholder' => 'options.hint.icon',
                    'helper_text' => 'options.hint.icon',
                    'description' => 'options.hint.icon',
                ],
                'color' => [
                    'label' => 'options.hint.color',
                    'placeholder' => 'options.hint.color',
                    'helper_text' => 'options.hint.color',
                    'description' => 'options.hint.color',
                ],
                'icon-tooltip' => [
                    'label' => 'options.hint.icon-tooltip',
                    'placeholder' => 'options.hint.icon-tooltip',
                    'helper_text' => 'options.hint.icon-tooltip',
                    'description' => 'options.hint.icon-tooltip',
                ],
            ],
            'is_required' => [
                'label' => 'options.is_required',
                'placeholder' => 'options.is_required',
                'helper_text' => 'options.is_required',
                'description' => 'options.is_required',
            ],
            'column_span_full' => [
                'label' => 'options.column_span_full',
                'placeholder' => 'options.column_span_full',
                'helper_text' => 'options.column_span_full',
                'description' => 'options.column_span_full',
            ],
            'hidden_label' => [
                'label' => 'options.hidden_label',
                'placeholder' => 'options.hidden_label',
                'helper_text' => 'options.hidden_label',
                'description' => 'options.hidden_label',
            ],
            'dataSource' => [
                'label' => 'options.dataSource',
                'placeholder' => 'options.dataSource',
                'helper_text' => 'options.dataSource',
                'description' => 'options.dataSource',
            ],
            'dateType' => [
                'label' => 'options.dateType',
                'placeholder' => 'options.dateType',
                'helper_text' => 'options.dateType',
                'description' => 'options.dateType',
            ],
            'minValue' => [
                'label' => 'options.minValue',
                'placeholder' => 'options.minValue',
                'helper_text' => 'options.minValue',
                'description' => 'options.minValue',
            ],
            'maxValue' => [
                'label' => 'options.maxValue',
                'placeholder' => 'options.maxValue',
                'helper_text' => 'options.maxValue',
                'description' => 'options.maxValue',
            ],
            'suffix' => [
                'label' => 'options.suffix',
                'placeholder' => 'options.suffix',
                'helper_text' => 'options.suffix',
                'description' => 'options.suffix',
            ],
            'suffix-icon' => [
                'label' => 'options.suffix-icon',
                'placeholder' => 'options.suffix-icon',
                'helper_text' => 'options.suffix-icon',
                'description' => 'options.suffix-icon',
            ],
            'suffix-icon-color' => [
                'label' => 'options.suffix-icon-color',
                'placeholder' => 'options.suffix-icon-color',
                'helper_text' => 'options.suffix-icon-color',
                'description' => 'options.suffix-icon-color',
            ],
            'prefix' => [
                'label' => 'options.prefix',
                'placeholder' => 'options.prefix',
                'helper_text' => 'options.prefix',
                'description' => 'options.prefix',
            ],
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'value' => [
            'description' => 'value',
            'helper_text' => '',
            'placeholder' => 'value',
            'label' => 'value',
        ],
        'values-list' => [
            'description' => 'values-list',
            'helper_text' => '',
            'placeholder' => 'values-list',
            'label' => 'values-list',
        ],
        'user_id' => [
            'label' => 'user_id',
            'placeholder' => 'user_id',
            'helper_text' => '',
            'description' => 'user_id',
        ],
        'name' => [
            'label' => 'name',
            'placeholder' => 'name',
            'helper_text' => '',
            'description' => 'name',
        ],
        'slug' => [
            'label' => 'slug',
            'placeholder' => 'slug',
            'helper_text' => '',
            'description' => 'slug',
        ],
        'category_id' => [
            'label' => 'category_id',
            'placeholder' => 'category_id',
            'helper_text' => '',
            'description' => 'category_id',
        ],
        'description' => [
            'label' => 'description',
            'placeholder' => 'description',
            'helper_text' => '',
            'description' => 'description',
        ],
        'details' => [
            'label' => 'details',
            'placeholder' => 'details',
            'helper_text' => '',
            'description' => 'details',
        ],
        'is_active' => [
            'label' => 'is_active',
            'placeholder' => 'is_active',
            'helper_text' => '',
            'description' => 'is_active',
        ],
        'ordering' => [
            'label' => 'ordering',
            'placeholder' => 'ordering',
            'helper_text' => '',
            'description' => 'ordering',
        ],
        'start_date' => [
            'label' => 'start_date',
            'placeholder' => 'start_date',
            'helper_text' => '',
            'description' => 'start_date',
        ],
        'end_date' => [
            'label' => 'end_date',
            'placeholder' => 'end_date',
            'helper_text' => '',
            'description' => 'end_date',
        ],
        'extensions' => [
            'label' => 'extensions',
            'placeholder' => 'extensions',
            'helper_text' => '',
            'description' => 'extensions',
        ],
        'sections' => [
            'label' => 'sections',
            'placeholder' => 'sections',
            'helper_text' => '',
            'description' => 'sections',
        ],
        'fields' => [
            'label' => 'fields',
            'placeholder' => 'fields',
            'helper_text' => '',
            'description' => 'fields',
        ],
        'type' => [
            'label' => 'type',
            'placeholder' => 'type',
            'helper_text' => '',
            'description' => 'type',
        ],
        'compact' => [
            'label' => 'compact',
            'placeholder' => 'compact',
            'helper_text' => '',
            'description' => 'compact',
        ],
        'aside' => [
            'label' => 'aside',
            'placeholder' => 'aside',
            'helper_text' => '',
            'description' => 'aside',
        ],
        'borderless' => [
            'label' => 'borderless',
            'placeholder' => 'borderless',
            'helper_text' => '',
            'description' => 'borderless',
        ],
        'icon' => [
            'label' => 'icon',
            'placeholder' => 'icon',
            'helper_text' => '',
            'description' => 'icon',
        ],
        'columns' => [
            'label' => 'columns',
            'placeholder' => 'columns',
            'helper_text' => '',
            'description' => 'columns',
        ],
        'itemIsDefault' => [
            'description' => 'itemIsDefault',
            'helper_text' => '',
            'placeholder' => 'itemIsDefault',
            'label' => 'itemIsDefault',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'isActive' => [
            'description' => 'isActive',
            'helper_text' => '',
            'placeholder' => 'isActive',
            'label' => 'isActive',
        ],
        'status' => [
            'label' => 'status',
        ],
        'notes' => [
            'description' => 'notes',
        ],
        'responses_count' => [
            'description' => 'responses_count',
            'helper_text' => '',
            'placeholder' => 'responses_count',
            'label' => 'responses_count',
        ],
        'itemKey' => [
            'description' => 'itemKey',
            'helper_text' => '',
            'placeholder' => 'itemKey',
            'label' => 'itemKey',
        ],
        'forms_count' => [
            'description' => 'forms_count',
            'helper_text' => '',
            'placeholder' => 'forms_count',
            'label' => 'forms_count',
        ],
        'responses_exists' => [
            'description' => 'responses_exists',
            'helper_text' => '',
            'placeholder' => 'responses_exists',
            'label' => 'responses_exists',
        ],
        'logo' => [
            'description' => 'logo',
            'helper_text' => '',
        ],
        'category' => [
            'name' => [
                'description' => 'category.name',
                'helper_text' => '',
            ],
        ],
        'test_date' => [
            'label' => 'test_date',
            'placeholder' => 'test_date',
            'helper_text' => 'test_date',
            'description' => 'test_date',
        ],
        'test' => [
            'label' => 'test',
            'placeholder' => 'test',
            'helper_text' => 'test',
            'description' => 'test',
        ],
    ],
    'actions' => [
        'authenticate' => [
            'label' => 'Autentica',
            'tooltip' => 'Effettua il login nel sistema',
            'icon' => 'ui-login',
            'color' => 'primary',
        ],
        'login' => [
            'label' => 'Accedi',
            'tooltip' => 'Accedi con le tue credenziali',
            'icon' => 'heroicon-o-key',
            'color' => 'success',
        ],
        'request' => [
            'label' => 'request',
            'tooltip' => 'request',
            'icon' => 'request',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
        'save' => [
            'label' => 'save',
        ],
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
        'open' => [
            'label' => 'open',
        ],
        'create' => [
            'label' => 'create',
        ],
        'createAnother' => [
            'label' => 'createAnother',
        ],
        'hidePassword' => [
            'icon' => 'hidePassword',
            'label' => 'hidePassword',
            'tooltip' => 'hidePassword',
        ],
        'showPassword' => [
            'icon' => 'ui-showPassword',
            'label' => 'showPassword',
            'tooltip' => 'showPassword',
        ],
    ],
];
