<?php

declare(strict_types=1);

return [
    'breadcrumb' => 'Cronologia',

    'title' => 'Cronologia :record',

    'default_datetime_format' => 'd/m/Y, H:i:s',

    'table' => [
        'field' => 'Campo',
        'old' => 'Vecchio',
        'new' => 'Nuovo',
        'restore' => 'Ripristina',
    ],

    'events' => [
        'updated' => 'Aggiornato',
        'created' => 'Creato',
        'deleted' => 'Eliminato',
        'restored' => 'Ripristinato',
        'restore_successful' => 'Ripristinato con successo',
        'restore_failed' => 'Ripristino fallito',
    ],

    'subject' => [
        'type' => 'Tipo',
        'id' => 'ID',
        'unknown' => 'Sconosciuto',
    ],

    'metadata' => [
        'log_name' => 'Log',
        'batch_uuid' => 'Batch UUID',
        'properties' => 'Proprietà',
    ],

    'no_changes' => 'Nessuna modifica registrata',
    'no_description' => 'Nessuna descrizione disponibile',

    'modified' => 'Modificato',
    'fields_modified' => ':count campo modificato|:count campi modificati',
    'anonymous' => 'Utente Anonimo',
];
