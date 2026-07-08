<?php

declare(strict_types=1);

/**
 * ==============================================
 * LARAXOT TRANSLATION FILE TEMPLATE
 * ==============================================
 * Template standardizzato per tutti i file di traduzione Laraxot
 * Ultimo aggiornamento: 2025-01-06
 * ==============================================
 */

return [
    // ==============================================
    // NAVIGATION & STRUCTURE
    // ==============================================
    'navigation' => [
        'label' => 'Nome Entità',
        'plural_label' => 'Nome Entità Plurali',
        'group' => 'Nome Gruppo',
        'icon' => 'heroicon-o-icon-name',
        'sort' => 10,
        'badge' => 'Descrizione badge opzionale',
    ],
    // ==============================================
    // MODEL INFORMATION
    // ==============================================
    'model' => [
        'label' => 'Nome Entità Singolare',
        'plural' => 'Nome Entità Plurali',
        'description' => 'Descrizione dell\'entità',
    ],
    // ==============================================
    // FIELDS - STRUTTURA ESPANSA OBBLIGATORIA
    // ==============================================
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Identificativo univoco',
            'helper_text' => 'Identificativo numerico univoco dell\'entità',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'tooltip' => 'Nome identificativo dell\'entità',
            'helper_text' => 'Nome descrittivo e identificativo dell\'entità',
            'help' => 'Inserisci un nome chiaro e descrittivo',
            'validation' => [
                'required' => 'Il nome è obbligatorio',
                'min' => 'Il nome deve essere di almeno :min caratteri',
                'max' => 'Il nome non può superare i :max caratteri',
            ],
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'tooltip' => 'Descrizione dettagliata dell\'entità',
            'helper_text' => 'Testo descrittivo che spiega le caratteristiche o lo scopo dell\'entità',
            'help' => 'Fornisci una descrizione chiara e completa',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'tooltip' => 'Stato attuale dell\'entità',
            'helper_text' => 'Indica lo stato corrente dell\'entità nel sistema',
            'help' => 'Scegli lo stato appropriato dall\'elenco',
            'options' => [
                'active' => 'Attivo',
                'inactive' => 'Inattivo',
                'pending' => 'In attesa',
                'completed' => 'Completato',
                'cancelled' => 'Annullato',
            ],
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => 'Data di creazione dell\'entità',
            'helper_text' => 'Data e ora in cui l\'entità è stata creata nel sistema',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => 'Data dell\'ultima modifica',
            'helper_text' => 'Data e ora dell\'ultimo aggiornamento dell\'entità',
        ],
    ],
    // ==============================================
    // ACTIONS - STRUTTURA ESPANSA OBBLIGATORIA
    // ==============================================
    'actions' => [
        'create' => [
            'label' => 'Crea Nuovo',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Crea una nuova entità nel sistema',
            'modal' => [
                'heading' => 'Crea Nuova Entità',
                'description' => 'Inserisci i dettagli per creare una nuova entità',
                'confirm' => 'Crea',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Entità creata con successo',
                'error' => 'Si è verificato un errore durante la creazione',
            ],
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Modifica l\'entità selezionata',
            'modal' => [
                'heading' => 'Modifica Entità',
                'description' => 'Aggiorna le informazioni dell\'entità',
                'confirm' => 'Salva modifiche',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Entità modificata con successo',
                'error' => 'Si è verificato un errore durante la modifica',
            ],
        ],
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Elimina definitivamente l\'entità',
            'modal' => [
                'heading' => 'Elimina Entità',
                'description' => 'Sei sicuro di voler eliminare questa entità? Questa azione è irreversibile.',
                'confirm' => 'Elimina',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Entità eliminata con successo',
                'error' => 'Si è verificato un errore durante l\'eliminazione',
            ],
            'confirmation' => 'Sei sicuro di voler eliminare questa entità?',
        ],
        'view' => [
            'label' => 'Visualizza',
            'icon' => 'heroicon-o-eye',
            'color' => 'secondary',
            'tooltip' => 'Visualizza i dettagli dell\'entità',
        ],
        'bulk_actions' => [
            'delete' => [
                'label' => 'Elimina Selezionati',
                'icon' => 'heroicon-o-trash',
                'color' => 'danger',
                'tooltip' => 'Elimina tutte le entità selezionate',
                'modal' => [
                    'heading' => 'Elimina Entità Selezionate',
                    'description' => 'Sei sicuro di voler eliminare le entità selezionate? Questa azione è irreversibile.',
                    'confirm' => 'Elimina tutti',
                    'cancel' => 'Annulla',
                ],
                'messages' => [
                    'success' => 'Entità eliminate con successo',
                    'error' => 'Si è verificato un errore durante l\'eliminazione',
                ],
            ],
        ],
    ],
    // ==============================================
    // SECTIONS - ORGANIZZAZIONE FORM
    // ==============================================
    'sections' => [
        'basic_info' => [
            'label' => 'Informazioni Base',
            'description' => 'Informazioni fondamentali dell\'entità',
            'icon' => 'heroicon-o-information-circle',
        ],
        'additional_info' => [
            'label' => 'Informazioni Aggiuntive',
            'description' => 'Dettagli aggiuntivi e opzionali',
            'icon' => 'heroicon-o-adjustments',
        ],
        'settings' => [
            'label' => 'Impostazioni',
            'description' => 'Configurazioni e preferenze',
            'icon' => 'heroicon-o-cog',
        ],
    ],
    // ==============================================
    // FILTERS - RICERCA E FILTRI
    // ==============================================
    'filters' => [
        'status' => [
            'label' => 'Stato',
            'options' => [
                'active' => 'Attivo',
                'inactive' => 'Inattivo',
                'pending' => 'In attesa',
            ],
        ],
        'date_range' => [
            'label' => 'Periodo',
            'placeholder' => 'Seleziona il periodo',
        ],
        'search' => [
            'label' => 'Ricerca',
            'placeholder' => 'Cerca nelle entità...',
        ],
    ],
    // ==============================================
    // MESSAGES - FEEDBACK UTENTE
    // ==============================================
    'messages' => [
        'empty_state' => 'Nessuna entità trovata',
        'search_placeholder' => 'Cerca entità...',
        'loading' => 'Caricamento in corso...',
        'total_count' => 'Totale entità: :count',
        'created' => 'Entità creata con successo',
        'updated' => 'Entità aggiornata con successo',
        'deleted' => 'Entità eliminata con successo',
        'bulk_deleted' => 'Entità eliminate con successo',
        'error_general' => 'Si è verificato un errore. Riprova più tardi.',
        'error_validation' => 'Si sono verificati errori di validazione.',
        'error_permission' => 'Non hai i permessi per eseguire questa azione.',
        'success_operation' => 'Operazione completata con successo',
    ],
    // ==============================================
    // VALIDATION - MESSAGGI DI VALIDAZIONE
    // ==============================================
    'validation' => [
        'required' => 'Il campo :field è obbligatorio',
        'min' => 'Il campo :field deve essere di almeno :min caratteri',
        'max' => 'Il campo :field non può superare i :max caratteri',
        'email' => 'Il campo :field deve contenere un indirizzo email valido',
        'unique' => 'Il valore inserito per :field è già in uso',
        'date' => 'Il campo :field deve contenere una data valida',
        'numeric' => 'Il campo :field deve essere numerico',
        'boolean' => 'Il campo :field deve essere vero o falso',
    ],
    // ==============================================
    // DESCRIPTIONS - DESCRIZIONI CONTESTUALI
    // ==============================================
    'descriptions' => [
        'entity_purpose' => 'Scopo e funzionalità dell\'entità',
        'usage_instructions' => 'Istruzioni per l\'utilizzo',
        'best_practices' => 'Migliori pratiche per l\'utilizzo',
        'limitations' => 'Limitazioni e vincoli',
    ],
    // ==============================================
    // OPTIONS - OPZIONI E VALORI PREDEFINITI
    // ==============================================
    'options' => [
        'statuses' => [
            'active' => 'Attivo',
            'inactive' => 'Inattivo',
            'pending' => 'In attesa',
            'completed' => 'Completato',
            'cancelled' => 'Annullato',
        ],
        'types' => [
            'type1' => 'Tipo 1',
            'type2' => 'Tipo 2',
            'type3' => 'Tipo 3',
        ],
        'priorities' => [
            'low' => 'Bassa',
            'medium' => 'Media',
            'high' => 'Alta',
            'critical' => 'Critica',
        ],
    ],
];
