<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Ruoli',
        'plural_label' => 'Ruoli',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione dei ruoli e dei permessi associati',
        ],
        'sort' => 26,
        'icon' => 'heroicon-o-user-group',
        'badge' => 'Gestione ruoli e permessi',
    ],
    'model' => [
        'label' => 'Ruolo',
        'plural' => 'Ruoli',
        'description' => 'Ruoli di accesso e permessi nel sistema',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Identificativo univoco del ruolo',
            'helper_text' => 'Identificativo numerico univoco del ruolo nel sistema',
        ],
        'name' => [
            'label' => 'Nome Ruolo',
            'placeholder' => 'Inserisci il nome del ruolo',
            'tooltip' => 'Nome identificativo del ruolo, es. "Admin"',
            'helper_text' => 'Nome univoco che identifica il ruolo nel sistema',
            'help' => 'Scegli un nome descrittivo e univoco per il ruolo',
            'validation' => [
                'required' => 'Il nome del ruolo è obbligatorio',
                'unique' => 'Questo nome ruolo è già in uso',
                'min' => 'Il nome deve essere di almeno :min caratteri',
                'max' => 'Il nome non può superare i :max caratteri',
            ],
        ],
        'guard_name' => [
            'label' => 'Guard',
            'placeholder' => 'Seleziona la guardia',
            'tooltip' => 'Nome della guardia per questo ruolo, es. "web"',
            'helper_text' => 'Sistema di autenticazione utilizzato per questo ruolo',
            'help' => 'Specifica il sistema di autenticazione (web, api, ecc.)',
            'options' => [
                'web' => 'Web',
                'api' => 'API',
                'sanctum' => 'Sanctum',
            ],
        ],
        'permissions' => [
            'label' => 'Permessi',
            'placeholder' => 'Seleziona i permessi',
            'tooltip' => 'Permessi associati a questo ruolo',
            'helper_text' => 'Elenco dei permessi specifici assegnati a questo ruolo',
            'help' => 'Seleziona i permessi che questo ruolo può esercitare',
        ],
        'users_count' => [
            'label' => 'Numero Utenti',
            'tooltip' => 'Numero di utenti assegnati a questo ruolo',
            'helper_text' => 'Conteggio degli utenti che attualmente hanno questo ruolo assegnato',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione del ruolo',
            'tooltip' => 'Descrizione dettagliata del ruolo e delle sue funzioni',
            'helper_text' => 'Testo descrittivo che spiega lo scopo e le responsabilità del ruolo',
            'help' => 'Fornisci una descrizione chiara delle funzioni del ruolo',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => 'Data di creazione del ruolo',
            'helper_text' => 'Data e ora in cui il ruolo è stato creato nel sistema',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => 'Data dell\'ultima modifica del ruolo',
            'helper_text' => 'Data e ora dell\'ultimo aggiornamento del ruolo',
        ],
        'team_id' => [
            'label' => 'ID Team',
            'placeholder' => 'Seleziona il team',
            'tooltip' => 'Team associato al ruolo',
            'helper_text' => 'Team specifico al quale questo ruolo appartiene',
            'help' => 'Seleziona il team per cui questo ruolo è valido',
        ],
        'values' => [
            'label' => 'Valori',
            'tooltip' => 'Valori associati al ruolo',
            'helper_text' => 'Valori aggiuntivi o configurazioni specifiche del ruolo',
            'description' => 'values',
            'placeholder' => 'values',
        ],
        'enabled' => [
            'label' => 'Abilitato',
            'tooltip' => 'Stato di abilitazione del ruolo',
            'helper_text' => 'Indica se il ruolo è attualmente attivo e utilizzabile',
            'options' => [
                'true' => 'Sì',
                'false' => 'No',
            ],
        ],
        'team' => [
            'name' => [
                'label' => 'team.name',
            ],
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Ruolo',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Crea un nuovo ruolo nel sistema',
            'modal' => [
                'heading' => 'Crea Nuovo Ruolo',
                'description' => 'Inserisci i dettagli per creare un nuovo ruolo',
                'confirm' => 'Crea Ruolo',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Ruolo creato con successo',
                'error' => 'Si è verificato un errore durante la creazione del ruolo',
            ],
        ],
        'edit' => [
            'label' => 'Modifica Ruolo',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Modifica il ruolo selezionato',
            'modal' => [
                'heading' => 'Modifica Ruolo',
                'description' => 'Aggiorna le informazioni del ruolo',
                'confirm' => 'Salva modifiche',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Ruolo modificato con successo',
                'error' => 'Si è verificato un errore durante la modifica del ruolo',
            ],
        ],
        'delete' => [
            'label' => 'Elimina Ruolo',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Elimina definitivamente il ruolo',
            'modal' => [
                'heading' => 'Elimina Ruolo',
                'description' => 'Sei sicuro di voler eliminare questo ruolo? Questa azione è irreversibile.',
                'confirm' => 'Elimina',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Ruolo eliminato con successo',
                'error' => 'Si è verificato un errore durante l\'eliminazione del ruolo',
            ],
            'confirmation' => 'Sei sicuro di voler eliminare questo ruolo?',
        ],
        'assign_permissions' => [
            'label' => 'Assegna Permessi',
            'icon' => 'heroicon-o-key',
            'color' => 'info',
            'tooltip' => 'Assegna permessi al ruolo',
            'modal' => [
                'heading' => 'Assegna Permessi',
                'description' => 'Seleziona i permessi da assegnare a questo ruolo',
                'confirm' => 'Assegna',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Permessi assegnati con successo',
                'error' => 'Si è verificato un errore durante l\'assegnazione dei permessi',
            ],
        ],
        'sync_permissions' => [
            'label' => 'Sincronizza Permessi',
            'icon' => 'heroicon-o-arrow-path',
            'color' => 'secondary',
            'tooltip' => 'Sincronizza i permessi con quelli di un altro sistema',
            'modal' => [
                'heading' => 'Sincronizza Permessi',
                'description' => 'Sincronizza i permessi del ruolo con quelli di un altro sistema',
                'confirm' => 'Sincronizza',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Permessi sincronizzati con successo',
                'error' => 'Si è verificato un errore durante la sincronizzazione',
            ],
        ],
        'view' => [
            'label' => 'Visualizza Ruolo',
            'icon' => 'heroicon-o-eye',
            'color' => 'secondary',
            'tooltip' => 'Visualizza i dettagli del ruolo',
        ],
        'bulk_actions' => [
            'delete' => [
                'label' => 'Elimina Selezionati',
                'icon' => 'heroicon-o-trash',
                'color' => 'danger',
                'tooltip' => 'Elimina tutti i ruoli selezionati',
                'modal' => [
                    'heading' => 'Elimina Ruoli Selezionati',
                    'description' => 'Sei sicuro di voler eliminare i ruoli selezionati? Questa azione è irreversibile.',
                    'confirm' => 'Elimina tutti',
                    'cancel' => 'Annulla',
                ],
                'messages' => [
                    'success' => 'Ruoli eliminati con successo',
                    'error' => 'Si è verificato un errore durante l\'eliminazione dei ruoli',
                ],
            ],
        ],
        'reorderRecords' => [
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'icon' => 'resetFilters',
            'label' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'applyFilters' => [
            'icon' => 'applyFilters',
            'label' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'openFilters' => [
            'icon' => 'openFilters',
            'label' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'detach' => [
            'icon' => 'detach',
            'label' => 'detach',
            'tooltip' => 'detach',
        ],
        'cancel' => [
            'icon' => 'cancel',
            'tooltip' => 'cancel',
            'label' => 'cancel',
        ],
        'attachRole' => [
            'icon' => 'attachRole',
            'label' => 'attachRole',
            'tooltip' => 'attachRole',
        ],
        'attach' => [
            'icon' => 'attach',
            'label' => 'attach',
            'tooltip' => 'attach',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'layout' => [
            'tooltip' => 'layout',
            'icon' => 'layout',
            'label' => 'layout',
        ],
        'createAnother' => [
            'tooltip' => 'createAnother',
        ],
        'submit' => [
            'tooltip' => 'submit',
            'icon' => 'submit',
            'label' => 'submit',
        ],
    ],
    'sections' => [
        'basic_info' => [
            'label' => 'Informazioni Base',
            'description' => 'Informazioni fondamentali del ruolo',
            'icon' => 'heroicon-o-information-circle',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'description' => 'Gestione permessi e autorizzazioni',
            'icon' => 'heroicon-o-key',
        ],
        'settings' => [
            'label' => 'Impostazioni',
            'description' => 'Configurazioni avanzate del ruolo',
            'icon' => 'heroicon-o-cog',
        ],
    ],
    'filters' => [
        'guard_name' => [
            'label' => 'Guard',
            'options' => [
                'web' => 'Web',
                'api' => 'API',
                'sanctum' => 'Sanctum',
            ],
        ],
        'permissions' => [
            'label' => 'Permessi',
            'placeholder' => 'Filtra per permessi',
        ],
        'team_id' => [
            'label' => 'Team',
            'placeholder' => 'Seleziona team',
        ],
    ],
    'messages' => [
        'empty_state' => 'Nessun ruolo trovato',
        'search_placeholder' => 'Cerca ruoli...',
        'loading' => 'Caricamento ruoli in corso...',
        'total_count' => 'Totale ruoli: :count',
        'created' => 'Ruolo creato con successo',
        'updated' => 'Ruolo aggiornato con successo',
        'deleted' => 'Ruolo eliminato con successo',
        'permissions_updated' => 'Permessi aggiornati con successo',
        'cannot_delete_super_admin' => 'Non puoi eliminare il ruolo di Super Amministratore',
        'role_in_use' => 'Non puoi eliminare un ruolo assegnato a degli utenti',
        'error_general' => 'Si è verificato un errore. Riprova più tardi.',
        'error_validation' => 'Si sono verificati errori di validazione.',
        'error_permission' => 'Non hai i permessi per eseguire questa azione.',
        'success_operation' => 'Operazione completata con successo',
    ],
    'validation' => [
        'name_required' => 'Il nome del ruolo è obbligatorio',
        'name_unique' => 'Questo nome ruolo è già in uso',
        'name_min' => 'Il nome deve essere di almeno :min caratteri',
        'name_max' => 'Il nome non può superare i :max caratteri',
        'guard_required' => 'La guardia è obbligatoria',
        'permissions_array' => 'I permessi devono essere un array',
        'description_max' => 'La descrizione non può superare i :max caratteri',
    ],
    'descriptions' => [
        'super_admin' => 'Accesso completo a tutte le funzionalità del sistema',
        'admin' => 'Accesso alla maggior parte delle funzionalità amministrative',
        'manager' => 'Gestione di utenti e contenuti specifici',
        'editor' => 'Modifica e gestione dei contenuti',
        'user' => 'Accesso base alle funzionalità del sistema',
    ],
    'options' => [
        'roles' => [
            'super_admin' => 'Super Amministratore',
            'admin' => 'Amministratore',
            'manager' => 'Manager',
            'editor' => 'Editor',
            'user' => 'Utente',
        ],
        'permissions_groups' => [
            'users' => 'Gestione Utenti',
            'roles' => 'Gestione Ruoli',
            'content' => 'Gestione Contenuti',
            'settings' => 'Impostazioni',
            'reports' => 'Report',
        ],
        'guards' => [
            'web' => 'Web',
            'api' => 'API',
            'sanctum' => 'Sanctum',
        ],
    ],
    'roles' => [
        'super_admin' => 'Super Amministratore',
        'admin' => 'Amministratore',
        'manager' => 'Manager',
        'editor' => 'Editor',
        'user' => 'Utente',
    ],
    'label' => 'role',
    'plural_label' => '',
];
