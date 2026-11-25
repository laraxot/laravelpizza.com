<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Moduli',
        'plural' => 'Moduli',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Module and extension management',
        ],
        'label' => 'Module',
        'sort' => '17',
        'icon' => 'xot-module',
    ],
    'fields' => [
        'basic' => [
            'name' => [
                'label' => 'Name',
                'placeholder' => 'Enter the module name',
                'help' => 'Module identifier name',
            ],
            'description' => [
                'label' => 'Description',
                'placeholder' => 'Enter the module description',
                'help' => 'Detailed description of the features',
            ],
            'version' => [
                'label' => 'Versione',
                'placeholder' => 'Enter the version (e.g. 1.0.0)',
                'help' => 'Semantic version of the module',
            ],
            'status' => [
                'label' => 'Status',
                'help' => 'Current status of the module',
                'options' => [
                    'enabled' => 'Enabled',
                    'disabled' => 'Disabled',
                    'pending' => 'In attesa',
                    'error' => 'Error',
                ],
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
        ],
        'details' => [
            'dependencies' => [
                'label' => 'Dipendenze',
                'placeholder' => 'Select the required dependencies',
                'help' => 'Other modules required to run',
            ],
            'author' => [
                'label' => 'Autore',
                'placeholder' => 'Enter the module author',
                'help' => 'Sviluppatore o organizzazione',
            ],
            'license' => [
                'label' => 'Licenza',
                'placeholder' => 'Enter the license',
                'help' => 'Module license type',
                'options' => [
                    'mit' => 'MIT',
                    'apache' => 'Apache 2.0',
                    'gpl' => 'GPL v3',
                    'proprietary' => 'Proprietaria',
                ],
            ],
            'homepage' => [
                'label' => 'Homepage',
                'placeholder' => 'Documentation URL',
                'help' => 'Module web page',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'system' => [
            'order' => [
                'label' => 'Ordine',
                'placeholder' => 'Enter the load order',
                'help' => 'Module load priority',
            ],
            'path' => [
                'label' => 'Path',
                'help' => 'Module installation path',
            ],
            'namespace' => [
                'label' => 'Namespace',
                'help' => 'Module PHP namespace',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'timestamps' => [
            'created_at' => [
                'label' => 'Data Creazione',
                'help' => 'Module installation date',
            ],
            'updated_at' => [
                'label' => 'Last Updated',
                'help' => 'Date of the last update',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'install' => [
            'label' => 'Installa',
            'success' => 'Module installed successfully',
            'error' => 'Error during installation',
        ],
        'uninstall' => [
            'label' => 'Disinstalla',
            'success' => 'Module uninstalled successfully',
            'error' => 'Error during uninstallation',
            'confirm' => 'Are you sure you want to uninstall this module?',
        ],
        'enable' => [
            'label' => 'Abilita',
            'success' => 'Module enabled successfully',
            'error' => 'Error during enabling',
        ],
        'disable' => [
            'label' => 'Disabilita',
            'success' => 'Module disabled successfully',
            'error' => 'Error during disabling',
        ],
        'update' => [
            'label' => 'Refresh',
            'success' => 'Module updated successfully',
            'error' => 'Error during update',
        ],
        'migrate' => [
            'label' => 'Migra Database',
            'success' => 'Migration completed successfully',
            'error' => 'Error during migration',
        ],
        'rollback' => [
            'label' => 'Ripristina Database',
            'success' => 'Restore completed successfully',
            'error' => 'Error during restore',
        ],
        'publish' => [
            'label' => 'Pubblica Risorse',
            'success' => 'Resources published successfully',
            'error' => 'Error during publishing',
        ],
    ],
    'messages' => [
        'validation' => [
            'name' => [
                'required' => 'The name is required',
                'unique' => 'This name is already in use',
                'regex' => 'The name may only contain letters, numbers and dashes',
            ],
            'version' => [
                'required' => 'The version is required',
                'regex' => 'The format must be X.Y.Z',
            ],
            'dependencies' => [
                'exists' => 'One or more dependent modules do not exist',
                'enabled' => 'One or more dependent modules are not enabled',
            ],
        ],
        'errors' => [
            'dependency_missing' => 'Dipendenza mancante: :name',
            'incompatible_version' => 'Versione incompatibile: :name richiede :version',
            'installation_failed' => 'Installazione fallita: :reason',
            'migration_failed' => 'Migrazione fallita: :reason',
            'system_incompatible' => 'Sistema incompatibile: richiede :requirement',
        ],
        'warnings' => [
            'disable_core' => 'Warning: you are about to disable a core module',
            'uninstall_dependencies' => 'Warning: this module has dependencies',
            'update_available' => 'Version :version is available',
            'backup_recommended' => 'We recommend making a backup before proceeding',
        ],
        'info' => [
            'dependencies_ok' => 'All dependencies are satisfied',
            'system_compatible' => 'The system is compatible',
            'migrations_pending' => 'Ci sono migrazioni in sospeso',
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
