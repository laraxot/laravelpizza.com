<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Log Sistema',
        'plural' => 'Log Sistema',
        'label' => 'Log Sistema',
        'group' => [
            'name' => 'Indennità',
            'description' => 'Gestione indennità di responsabilità',
        ],
        'sort' => 43,
        'icon' => 'heroicon-o-document-text',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco log',
        ],
        'id_tbl' => [
            'label' => 'ID Record',
            'help' => 'Identificativo del record collegato',
        ],
        'tbl' => [
            'label' => 'Tabella',
            'help' => 'Nome della tabella del record collegato',
        ],
        'note' => [
            'label' => 'Note',
            'help' => 'Descrizione dell\'azione eseguita',
        ],
        'obj' => [
            'label' => 'Oggetto',
            'help' => 'Oggetto dell\'azione',
        ],
        'act' => [
            'label' => 'Azione',
            'help' => 'Tipo di azione eseguita',
        ],
        'data' => [
            'label' => 'Dati',
            'help' => 'Dati serializzati dell\'operazione',
        ],
        'post_type' => [
            'label' => 'Tipo Post',
            'help' => 'Tipo di entità collegata',
        ],
        'post_id' => [
            'label' => 'ID Post',
            'help' => 'ID dell\'entità collegata',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'help' => 'Data e ora di creazione del log',
        ],
        'created_by' => [
            'label' => 'Creato da',
            'help' => 'Utente che ha generato il log',
        ],
        'created_ip' => [
            'label' => 'IP Creazione',
            'help' => 'Indirizzo IP di provenienza',
        ],
    ],
    'actions' => [
        'view' => [
            'label' => 'Visualizza',
        ],
        'filter' => [
            'by_table' => 'Filtra per tabella',
            'by_action' => 'Filtra per azione',
            'by_user' => 'Filtra per utente',
            'by_date' => 'Filtra per data',
        ],
    ],
    'sections' => [
        'log_info' => [
            'label' => 'Informazioni Log',
            'description' => 'Dettagli dell\'operazione registrata',
        ],
        'related_record' => [
            'label' => 'Record Collegato',
            'description' => 'Riferimento al record su cui è stata eseguita l\'azione',
        ],
        'action_data' => [
            'label' => 'Dati Azione',
            'description' => 'Dati serializzati dell\'operazione',
        ],
        'audit' => [
            'label' => 'Audit',
            'description' => 'Informazioni di tracciamento',
        ],
    ],
    'messages' => [
        'empty_state' => 'Nessun log trovato',
        'readonly_warning' => 'I log sono in sola lettura e non possono essere modificati',
    ],
    'filters' => [
        'table' => [
            'label' => 'Tabella',
            'placeholder' => 'Seleziona tabella',
        ],
        'action' => [
            'label' => 'Azione',
            'placeholder' => 'Seleziona azione',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'from' => 'Da',
            'to' => 'A',
        ],
    ],
    'log_types' => [
        'sendMailLettF' => 'Invio Mail Lettera F',
        'sendMailLettI' => 'Invio Mail Lettera I',
        'update' => 'Aggiornamento Record',
        'create' => 'Creazione Record',
        'delete' => 'Eliminazione Record',
        'view' => 'Visualizzazione Record',
        'export' => 'Esportazione Dati',
        'import' => 'Importazione Dati',
    ],
];
