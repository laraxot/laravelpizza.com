<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Lettera I',
        'group' => 'Indennità',
        'sort' => 64,
        'icon' => 'heroicon-o-document-check',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco',
        ],
        'ente' => [
            'label' => 'Ente',
            'placeholder' => 'Codice ente',
            'help' => 'Codice identificativo dell\'ente',
        ],
        'matr' => [
            'label' => 'Matricola',
            'placeholder' => 'Matricola dipendente',
            'help' => 'Codice matricola del dipendente',
        ],
        'cognome' => [
            'label' => 'Cognome',
            'placeholder' => 'Cognome dipendente',
            'help' => 'Cognome del dipendente',
        ],
        'nome' => [
            'label' => 'Nome',
            'placeholder' => 'Nome dipendente',
            'help' => 'Nome del dipendente',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'indirizzo@email.it',
            'help' => 'Indirizzo email del dipendente',
        ],
        'stabi' => [
            'label' => 'Stabilimento',
            'placeholder' => 'Codice stabilimento',
            'help' => 'Codice dello stabilimento',
        ],
        'repar' => [
            'label' => 'Reparto',
            'placeholder' => 'Codice reparto',
            'help' => 'Codice del reparto',
        ],
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'Anno di riferimento',
            'help' => 'Anno di valutazione',
        ],
        'dal' => [
            'label' => 'Dal',
            'placeholder' => 'Data inizio',
            'help' => 'Data inizio validità',
        ],
        'al' => [
            'label' => 'Al',
            'placeholder' => 'Data fine',
            'help' => 'Data fine validità',
        ],
        'dalf' => [
            'label' => 'Dal (Retribuzione)',
            'placeholder' => 'Data inizio retribuzione',
            'help' => 'Data inizio periodo retributivo',
        ],
        'alf' => [
            'label' => 'Al (Retribuzione)',
            'placeholder' => 'Data fine retribuzione',
            'help' => 'Data fine periodo retributivo',
        ],
        'dali' => [
            'label' => 'Dal (Indennità)',
            'placeholder' => 'Data inizio indennità',
            'help' => 'Data inizio periodo indennità',
        ],
        'ali' => [
            'label' => 'Al (Indennità)',
            'placeholder' => 'Data fine indennità',
            'help' => 'Data fine periodo indennità',
        ],
        'dali__ali' => [
            'label' => 'Periodo Indennità',
            'help' => 'Range completo periodo indennità (formato: gg/mm/aaaa - gg/mm/aaaa)',
        ],
        'archivista_informatico' => [
            'label' => 'Archivista Informatico',
            'help' => 'Indica se il dipendente ha l\'indennità di archivista informatico',
        ],
        'relazioni_pubblico' => [
            'label' => 'Relazioni con il Pubblico',
            'help' => 'Indica se il dipendente ha l\'indennità per relazioni con il pubblico',
        ],
        'protezione_civile' => [
            'label' => 'Protezione Civile',
            'help' => 'Indica se il dipendente ha l\'indennità per protezione civile',
        ],
        'formatore_professionale' => [
            'label' => 'Formatore Professionale',
            'help' => 'Indica se il dipendente ha l\'indennità di formatore professionale',
        ],
        'propro' => [
            'label' => 'Profilo Professionale',
            'placeholder' => 'Codice profilo',
            'help' => 'Codice del profilo professionale',
        ],
        'posfun' => [
            'label' => 'Posizione Funzionale',
            'placeholder' => 'Codice posizione',
            'help' => 'Codice della posizione funzionale',
        ],
        'categoria_eco' => [
            'label' => 'Categoria Economica',
            'placeholder' => 'Categoria',
            'help' => 'Categoria economica di appartenenza',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'help' => 'Data creazione record',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'help' => 'Data ultima modifica',
        ],
        'value' => [
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
            'label' => 'value',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuova Lettera I',
            'modal' => [
                'heading' => 'Crea Nuova Indennità Lettera I',
                'description' => 'Inserisci i dati per creare una nuova indennità specialistica',
            ],
            'success' => 'Indennità Lettera I creata con successo',
            'error' => 'Errore durante la creazione dell\'indennità',
        ],
        'edit' => [
            'label' => 'Modifica',
            'modal' => [
                'heading' => 'Modifica Indennità Lettera I',
                'description' => 'Aggiorna i dati dell\'indennità',
            ],
            'success' => 'Indennità aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'modal' => [
                'heading' => 'Elimina Indennità',
                'description' => 'Sei sicuro di voler eliminare questa indennità?',
            ],
            'confirmation' => 'Questa azione è irreversibile. Confermi l\'eliminazione?',
            'success' => 'Indennità eliminata con successo',
            'error' => 'Errore durante l\'eliminazione',
        ],
        'view' => [
            'label' => 'Visualizza',
        ],
        'export' => [
            'label' => 'Esporta XLS',
            'success' => 'Export completato con successo',
            'error' => 'Errore durante l\'export',
        ],
        'send_mail' => [
            'label' => 'Invia Email',
            'success' => 'Email inviata con successo',
            'error' => 'Errore durante l\'invio dell\'email',
        ],
    ],
    'sections' => [
        'anagrafica' => [
            'label' => 'Dati Anagrafici',
            'description' => 'Informazioni anagrafiche del dipendente',
        ],
        'periodo' => [
            'label' => 'Periodi di Validità',
            'description' => 'Range temporali (generale, retribuzione, indennità)',
        ],
        'indennita' => [
            'label' => 'Indennità Specialistiche',
            'description' => 'Tipologie di indennità speciali applicabili',
        ],
        'classificazione' => [
            'label' => 'Classificazione',
            'description' => 'Profilo professionale e categoria economica',
        ],
    ],
    'messages' => [
        'empty_state' => 'Nessuna indennità Lettera I trovata',
        'validation_error' => 'Errori di validazione rilevati',
        'saved' => 'Indennità salvata con successo',
        'periodo_info' => 'È possibile specificare periodi diversi per validità, retribuzione e indennità',
    ],
    'validation' => [
        'ente' => [
            'required' => 'Il campo ente è obbligatorio',
            'numeric' => 'Il campo ente deve essere numerico',
        ],
        'matr' => [
            'required' => 'La matricola è obbligatoria',
        ],
        'anno' => [
            'required' => 'L\'anno è obbligatorio',
            'numeric' => 'L\'anno deve essere numerico',
        ],
        'dal' => [
            'required' => 'La data di inizio è obbligatoria',
        ],
        'al' => [
            'required' => 'La data di fine è obbligatoria',
            'after' => 'La data di fine deve essere successiva alla data di inizio',
        ],
    ],
    'hints' => [
        'multiple_periods' => 'Questo modulo gestisce tre range temporali distinti: generale (dal/al), retribuzione (dalf/alf) e indennità (dali/ali)',
        'special_allowances' => 'Seleziona una o più indennità speciali applicabili al dipendente',
        'auto_update' => 'Alcuni campi vengono aggiornati automaticamente in base ai dati anagrafici',
    ],
    'indennita_types' => [
        'archivista_informatico' => 'Archivista Informatico',
        'relazioni_pubblico' => 'Relazioni con il Pubblico',
        'protezione_civile' => 'Protezione Civile',
        'formatore_professionale' => 'Formatore Professionale',
    ],
];
