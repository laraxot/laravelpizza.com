<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Ambiente',
        'plural' => 'Ambiente',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Environment variable and system configuration management',
        ],
        'label' => 'Environment',
        'sort' => '12',
        'icon' => 'xot-env',
    ],
    'fields' => [
        'key' => [
            'label' => 'Chiave',
            'placeholder' => 'Enter the key (e.g. APP_NAME)',
            'help' => 'Environment variable name in uppercase',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'value' => [
            'label' => 'Value',
            'placeholder' => 'Enter the value',
            'help' => 'Environment variable value',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Select the variable type',
            'help' => 'Variable data type',
            'options' => [
                'string' => 'Testo',
                'integer' => 'Numero intero',
                'float' => 'Numero decimale',
                'boolean' => 'Booleano',
                'array' => 'Array',
                'null' => 'Nullo',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'environment' => [
            'label' => 'Ambiente',
            'placeholder' => 'Select the target environment',
            'help' => 'Environment in which the variable is active',
            'options' => [
                'local' => 'Sviluppo locale',
                'testing' => 'Test',
                'staging' => 'Pre-produzione',
                'production' => 'Produzione',
                'all' => 'All environments',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_sensitive' => [
            'label' => 'Dato Sensibile',
            'help' => 'Whether the value contains sensitive data to mask',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Description',
            'placeholder' => 'Enter a description',
            'help' => 'Detailed description of the variable\'s purpose',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'group' => [
            'label' => 'Gruppo',
            'placeholder' => 'Select the group',
            'help' => 'Functional group of the variable',
            'options' => [
                'app' => 'Applicazione',
                'database' => 'Database',
                'mail' => 'Email',
                'queue' => 'Code',
                'cache' => 'Cache',
                'services' => 'Servizi',
                'other' => 'Altro',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'telegram_bot_token' => [
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'New Variable',
            'success' => 'Environment variable created successfully',
            'error' => 'Error while creating the variable',
        ],
        'edit' => [
            'label' => 'Edit',
            'success' => 'Environment variable updated successfully',
            'error' => 'Error while updating the variable',
        ],
        'delete' => [
            'label' => 'Delete',
            'success' => 'Environment variable deleted successfully',
            'error' => 'Error while deleting the variable',
        ],
        'backup' => [
            'label' => 'Backup',
            'success' => '.env file backup created successfully',
            'error' => 'Error while creating the backup',
        ],
        'restore' => [
            'label' => 'Ripristina',
            'success' => '.env file restored successfully',
            'error' => 'Error while restoring the file',
        ],
        'encrypt' => [
            'label' => 'Cripta',
            'success' => 'Value encrypted successfully',
            'error' => 'Error while encrypting',
        ],
    ],
    'messages' => [
        'validation' => [
            'key' => [
                'required' => 'The key is required',
                'unique' => 'This key is already in use',
                'regex' => 'The key may only contain uppercase letters, numbers and underscores',
                'reserved' => 'This key is reserved by the system',
            ],
            'value' => [
                'required' => 'The value is required',
                'type' => 'The value must be of type :type',
            ],
            'environment' => [
                'required' => 'The environment is required',
                'exists' => 'The selected environment is not valid',
            ],
        ],
        'warnings' => [
            'production_edit' => 'Attenzione: stai modificando variabili d\'ambiente in produzione',
            'backup_recommended' => 'We recommend making a backup before proceeding',
            'sensitive_data' => 'Warning: this value contains sensitive data',
            'restart_required' => 'You may need to restart the application',
        ],
        'info' => [
            'env_loaded' => 'File .env caricato correttamente',
            'backup_created' => 'Backup creato in :path',
            'changes_saved' => 'Changes saved to the .env file',
        ],
    ],
    'title' => 'Environment',
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'sections' => [
        'General' => [
            'label' => 'General',
            'heading' => 'General',
        ],
        'SMS' => [
            'label' => 'SMS',
            'heading' => 'SMS',
        ],
        'Mail' => [
            'label' => 'Mail',
            'heading' => 'Mail',
        ],
    ],
];
