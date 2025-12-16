<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Tenant',
        'group' => 'Sistema',
        'sort' => 25,
        'icon' => 'tenant-main-animated',
        'badge' => [
            'color' => 'success',
            'label' => 'Multi-tenant',
        ],
    ],
    'sections' => [
        'building' => [
            'navigation' => [
                'name' => 'Edifici',
                'group' => 'Tenant',
                'sort' => 10,
                'icon' => 'tenant-building-animated',
                'badge' => [
                    'color' => 'info',
                    'label' => 'Gestione',
                ],
            ],
            'fields' => [
                'name' => 'Nome',
                'address' => 'Indirizzo',
                'units' => 'Unità',
                'manager' => 'Amministratore',
                'status' => 'Stato',
                'notes' => 'Note',
            ],
        ],
        'unit' => [
            'navigation' => [
                'name' => 'Unità Immobiliari',
                'group' => 'Tenant',
                'sort' => 20,
                'icon' => 'tenant-unit-icon',
                'badge' => [
                    'color' => 'warning',
                    'label' => 'Occupazione',
                ],
            ],
            'fields' => [
                'number' => 'Numero',
                'floor' => 'Piano',
                'type' => 'Tipologia',
                'size' => 'Metratura',
                'tenant' => 'Inquilino',
                'rent' => 'Canone',
                'status' => 'Stato',
            ],
            'types' => [
                'apartment' => 'Appartamento',
                'office' => 'Ufficio',
                'store' => 'Negozio',
                'warehouse' => 'Magazzino',
            ],
        ],
        'tenant' => [
            'navigation' => [
                'name' => 'Inquilini',
                'group' => 'Tenant',
                'sort' => 30,
                'icon' => 'tenant-person-icon',
                'badge' => [
                    'color' => 'primary',
                    'label' => 'Contratti',
                ],
            ],
            'fields' => [
                'name' => 'Nome',
                'last_name' => 'Cognome',
                'tax_code' => 'Codice Fiscale',
                'email' => 'Email',
                'phone' => 'Telefono',
                'contract_start' => 'Inizio Contratto',
                'contract_end' => 'Fine Contratto',
                'deposit' => 'Deposito Cauzionale',
            ],
        ],
    ],
    'common' => [
        'status' => [
            'active' => 'Attivo',
            'inactive' => 'Inattivo',
            'maintenance' => 'In Manutenzione',
            'reserved' => 'Riservato',
        ],
        'actions' => [
            'create' => 'Crea',
            'edit' => 'Modifica',
            'delete' => 'Elimina',
            'view' => 'Visualizza',
            'assign' => 'Assegna',
            'unassign' => 'Rimuovi Assegnazione',
            'renew' => 'Rinnova',
            'terminate' => 'Termina',
        ],
        'messages' => [
            'success' => [
                'created' => 'Creato con successo',
                'updated' => 'Aggiornato con successo',
                'deleted' => 'Eliminato con successo',
                'assigned' => 'Assegnato con successo',
                'unassigned' => 'Assegnazione rimossa con successo',
            ],
            'error' => [
                'create' => 'Errore durante la creazione',
                'update' => 'Errore durante l\'aggiornamento',
                'delete' => 'Errore durante l\'eliminazione',
                'assign' => 'Errore durante l\'assegnazione',
                'unassign' => 'Errore durante la rimozione dell\'assegnazione',
            ],
            'confirm' => [
                'delete' => 'Sei sicuro di voler eliminare questo elemento?',
                'terminate' => 'Sei sicuro di voler terminare questo contratto?',
            ],
        ],
        'filters' => [
            'status' => 'Stato',
            'type' => 'Tipo',
            'floor' => 'Piano',
            'date_range' => 'Periodo',
            'occupation' => 'Occupazione',
        ],
    ],
];
