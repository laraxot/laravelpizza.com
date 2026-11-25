<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Extra',
        'plural' => 'Extra',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Management of additional system features',
        ],
        'label' => 'Extra',
        'sort' => '13',
        'icon' => 'xot-extra',
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter the extra name',
            'help' => 'Extra identifier name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Description',
            'placeholder' => 'Enter a detailed description',
            'help' => 'Full description of the extra\'s features',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Select the extra type',
            'help' => 'Categoria funzionale dell\'extra',
            'options' => [
                'config' => 'Configurazione',
                'asset' => 'Risorsa',
                'plugin' => 'Plugin',
                'theme' => 'Tema',
                'widget' => 'Widget',
                'service' => 'Servizio',
                'integration' => 'Integrazione',
                'utility' => 'Utility',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Status',
            'help' => 'Current status of the extra',
            'options' => [
                'active' => 'Active',
                'inactive' => 'Inattivo',
                'pending' => 'In attesa',
                'error' => 'Error',
                'updating' => 'In aggiornamento',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'version' => [
            'label' => 'Versione',
            'placeholder' => 'Enter the version (e.g. 1.0.0)',
            'help' => 'Versione semantica dell\'extra',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'dependencies' => [
            'label' => 'Dipendenze',
            'placeholder' => 'Select the required dependencies',
            'help' => 'Altri extra o componenti necessari',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'priority' => [
            'label' => 'Priority',
            'placeholder' => 'Select the priority',
            'help' => 'Load priority of the extra',
            'options' => [
                'high' => 'Alta',
                'medium' => 'Media',
                'low' => 'Bassa',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'settings' => [
            'label' => 'Settings',
            'placeholder' => 'Configure settings',
            'help' => 'Configurazioni specifiche dell\'extra',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Date and time the extra was created',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Last Updated',
            'help' => 'Date and time of the last modification',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'id' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'model_type' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'model_id' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'extra_attributes' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'create' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'edit' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'install' => [
            'label' => 'Installa',
            'success' => 'Extra installed successfully',
            'error' => 'Error during installation',
        ],
        'uninstall' => [
            'label' => 'Disinstalla',
            'success' => 'Extra uninstalled successfully',
            'error' => 'Error during uninstallation',
        ],
        'activate' => [
            'label' => 'Activate',
            'success' => 'Extra activated successfully',
            'error' => 'Error during activation',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'success' => 'Extra deactivated successfully',
            'error' => 'Error during deactivation',
        ],
        'update' => [
            'label' => 'Refresh',
            'success' => 'Extra updated successfully',
            'error' => 'Error during update',
        ],
        'configure' => [
            'label' => 'Configura',
            'success' => 'Configuration saved successfully',
            'error' => 'Error while saving the configuration',
        ],
    ],
    'messages' => [
        'validation' => [
            'name' => [
                'required' => 'The name is required',
                'unique' => 'This name is already in use',
                'regex' => 'The name may only contain letters, numbers and dashes',
            ],
            'type' => [
                'required' => 'The type is required',
                'in' => 'The selected type is not valid',
            ],
            'version' => [
                'required' => 'The version is required',
                'regex' => 'The version format must be X.Y.Z',
            ],
            'priority' => [
                'required' => 'The priority is required',
                'in' => 'The selected priority is not valid',
            ],
        ],
        'errors' => [
            'dependency_missing' => 'Dipendenza mancante: :name',
            'incompatible_version' => 'Versione incompatibile: :name richiede :version',
            'installation_failed' => 'Installazione fallita: :reason',
            'configuration_invalid' => 'Invalid configuration: :reason',
            'system_incompatible' => 'Sistema incompatibile: richiede :requirement',
        ],
        'warnings' => [
            'update_available' => 'An update to version :version is available',
            'dependency_update' => 'The :name dependency requires an update',
            'backup_recommended' => 'We recommend making a backup before proceeding',
        ],
        'info' => [
            'dependencies_ok' => 'All dependencies are satisfied',
            'configuration_valid' => 'The configuration is valid',
            'system_compatible' => 'The system is compatible',
        ],
    ],
    'model' => [
        'label' => 'extra.model',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
