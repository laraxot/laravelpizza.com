<?php

declare(strict_types=1);

return [
    'actions' => [
        'authenticate' => [
            'label' => 'authenticate',
            'icon' => 'ui-authenticate',
            'tooltip' => 'authenticate',
        ],
        'login' => [
            'label' => 'login',
            'tooltip' => 'login',
            'icon' => 'login',
        ],
        'request' => [
            'label' => 'request',
            'tooltip' => 'request',
            'icon' => 'request',
        ],
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
        'open' => [
            'label' => 'open',
        ],
        'save' => [
            'label' => 'save',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
        'createAnother' => [
            'label' => 'createAnother',
        ],
        'create' => [
            'label' => 'create',
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
    'fields' => [
        'email' => [
            'label' => 'email',
            'description' => 'email',
            'helper_text' => '',
            'placeholder' => 'email',
        ],
        'password' => [
            'label' => 'password',
            'description' => 'password',
            'helper_text' => '',
            'placeholder' => 'password',
        ],
        'remember' => [
            'label' => 'remember',
            'description' => 'remember',
            'helper_text' => '',
            'placeholder' => 'remember',
        ],
        'cap' => [
            'description' => 'cap',
            'helper_text' => 'cap',
            'placeholder' => 'cap',
            'label' => 'cap',
        ],
        'city' => [
            'description' => 'city',
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
                'helper_text' => 'options.allow_multiple',
                'label' => 'options.allow_multiple',
                'placeholder' => 'options.allow_multiple',
            ],
            'visibility' => [
                'values' => [
                    'description' => 'options.visibility.values',
                    'helper_text' => 'options.visibility.values',
                    'placeholder' => 'options.visibility.values',
                    'label' => 'options.visibility.values',
                ],
                'fieldID' => [
                    'description' => 'options.visibility.fieldID',
                    'helper_text' => 'options.visibility.fieldID',
                    'label' => 'options.visibility.fieldID',
                    'placeholder' => 'options.visibility.fieldID',
                ],
                'active' => [
                    'label' => 'options.visibility.active',
                    'placeholder' => 'options.visibility.active',
                    'helper_text' => 'options.visibility.active',
                    'description' => 'options.visibility.active',
                ],
            ],
            'prefix-icon' => [
                'description' => 'options.prefix-icon',
                'label' => 'options.prefix-icon',
                'placeholder' => 'options.prefix-icon',
                'helper_text' => 'options.prefix-icon',
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
        'itemIsDefault' => [
            'description' => 'itemIsDefault',
            'helper_text' => 'itemIsDefault',
            'placeholder' => 'itemIsDefault',
            'label' => 'itemIsDefault',
        ],
        'zeusData' => [
            1 => [
                'description' => 'zeusData.1',
                'helper_text' => 'zeusData.1',
                'placeholder' => 'zeusData.1',
                'label' => 'zeusData.1',
            ],
            3 => [
                'description' => 'zeusData.3',
                'helper_text' => 'zeusData.3',
                'placeholder' => 'zeusData.3',
                'label' => 'zeusData.3',
            ],
            2 => [
                'description' => 'zeusData.2',
                'helper_text' => 'zeusData.2',
                'placeholder' => 'zeusData.2',
                'label' => 'zeusData.2',
            ],
            [
                'description' => 'zeusData.4',
                'helper_text' => 'zeusData.4',
                'placeholder' => 'zeusData.4',
                'label' => 'zeusData.4',
            ],
        ],
        'user_id' => [
            'label' => 'user_id',
            'placeholder' => 'user_id',
            'helper_text' => 'user_id',
            'description' => 'user_id',
        ],
        'name' => [
            'label' => 'name',
            'placeholder' => 'name',
            'helper_text' => 'name',
            'description' => 'name',
        ],
        'slug' => [
            'label' => 'slug',
            'placeholder' => 'slug',
            'helper_text' => 'slug',
            'description' => 'slug',
        ],
        'category_id' => [
            'label' => 'category_id',
            'placeholder' => 'category_id',
            'helper_text' => 'category_id',
            'description' => 'category_id',
        ],
        'description' => [
            'label' => 'description',
            'placeholder' => 'description',
            'helper_text' => 'description',
            'description' => 'description',
        ],
        'details' => [
            'label' => 'details',
            'placeholder' => 'details',
            'helper_text' => 'details',
            'description' => 'details',
        ],
        'is_active' => [
            'label' => 'is_active',
            'placeholder' => 'is_active',
            'helper_text' => 'is_active',
            'description' => 'is_active',
        ],
        'ordering' => [
            'label' => 'ordering',
            'placeholder' => 'ordering',
            'helper_text' => 'ordering',
            'description' => 'ordering',
        ],
        'start_date' => [
            'label' => 'start_date',
            'placeholder' => 'start_date',
            'helper_text' => 'start_date',
            'description' => 'start_date',
        ],
        'end_date' => [
            'label' => 'end_date',
            'placeholder' => 'end_date',
            'helper_text' => 'end_date',
            'description' => 'end_date',
        ],
        'extensions' => [
            'label' => 'extensions',
            'placeholder' => 'extensions',
            'helper_text' => 'extensions',
            'description' => 'extensions',
        ],
        'sections' => [
            'label' => 'sections',
            'placeholder' => 'sections',
            'helper_text' => 'sections',
            'description' => 'sections',
        ],
        'fields' => [
            'label' => 'fields',
            'placeholder' => 'fields',
            'helper_text' => 'fields',
            'description' => 'fields',
        ],
        'type' => [
            'label' => 'type',
            'placeholder' => 'type',
            'helper_text' => 'type',
            'description' => 'type',
        ],
        'compact' => [
            'label' => 'compact',
            'placeholder' => 'compact',
            'helper_text' => 'compact',
            'description' => 'compact',
        ],
        'aside' => [
            'label' => 'aside',
            'placeholder' => 'aside',
            'helper_text' => 'aside',
            'description' => 'aside',
        ],
        'borderless' => [
            'label' => 'borderless',
            'placeholder' => 'borderless',
            'helper_text' => 'borderless',
            'description' => 'borderless',
        ],
        'icon' => [
            'label' => 'icon',
            'placeholder' => 'icon',
            'helper_text' => 'icon',
            'description' => 'icon',
        ],
        'columns' => [
            'label' => 'columns',
            'placeholder' => 'columns',
            'helper_text' => 'columns',
            'description' => 'columns',
        ],
        'itemKey' => [
            'description' => 'itemKey',
            'helper_text' => 'itemKey',
            'placeholder' => 'itemKey',
            'label' => 'itemKey',
        ],
        'values' => [
            'label' => 'values',
            'placeholder' => 'values',
            'helper_text' => 'values',
            'description' => 'values',
        ],
        'itemValue' => [
            'label' => 'itemValue',
            'placeholder' => 'itemValue',
            'helper_text' => 'itemValue',
            'description' => 'itemValue',
        ],
    ],
    'steps' => [
        'Credenziali' => [
            'label' => 'Credenziali',
        ],
    ],
];
