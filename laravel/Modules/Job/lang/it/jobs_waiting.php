<?php

declare(strict_types=1);

return [
    'navigation' => ['label' => 'Jobs in attesa', 'group' => 'Job', 'icon' => 'heroicon-o-cog', 'sort' => 50],
    'fields' => [
        'id' => ['label' => 'ID', 'description' => 'Identificativo univoco del job', 'helper_text' => 'Identificativo del job generato automaticamente', 'tooltip' => ''],
        'queue' => ['label' => 'Coda', 'description' => 'Nome della coda in cui il job è in attesa', 'helper_text' => 'Nome della coda a cui appartiene il job', 'tooltip' => ''],
        'payload' => ['label' => 'Payload', 'description' => 'Dati e parametri del job', 'helper_text' => 'Dati e parametri del job serializzati', 'tooltip' => ''],
        'attempts' => ['label' => 'Tentativi', 'description' => 'Numero di tentativi di esecuzione', 'helper_text' => 'Quante volte è stata tentata l\'esecuzione del job', 'tooltip' => ''],
        'reserved_at' => ['label' => 'Riservato il', 'description' => 'Quando il job è stato riservato per l\'elaborazione', 'helper_text' => 'Timestamp in cui il job è stato preso in carico', 'tooltip' => ''],
        'available_at' => ['label' => 'Disponibile dal', 'description' => 'Quando il job diventa disponibile per l\'elaborazione', 'helper_text' => 'Timestamp in cui il job diventa eseguibile', 'tooltip' => ''],
        'created_at' => ['label' => 'Creato il', 'description' => 'Quando il job è stato creato', 'helper_text' => 'Timestamp in cui il job è stato accodato', 'tooltip' => ''],
        'display_name' => ['label' => 'Nome'],
        'updated_at' => ['label' => 'Aggiornato il'],
    ],
    'actions' => [
        'export' => [
            'label' => 'Esporta',
            'tooltip' => 'Esporta i dati in un file',
            'icon' => 'export-icon',
            'color' => 'green',
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => [
                    'label' => 'Nome area',
                    'tooltip' => 'Nome dell\'area da esportare',
                ],
                'parent_name' => [
                    'label' => 'Nome area livello superiore',
                    'tooltip' => 'Nome dell\'area di livello superiore',
                ],
            ],
        ],
        'process' => [
            'label' => 'Processa',
            'tooltip' => 'Processa il job in attesa',
            'icon' => 'play-circle',
            'color' => 'green',
            'modal' => [
                'heading' => 'Processa Job',
                'description' => 'Vuoi processare questo job in attesa?',
            ],
            'messages' => [
                'success' => 'Job processato con successo',
            ],
        ],
        'cancel' => [
            'label' => 'Cancella',
            'tooltip' => 'Cancella il job in attesa',
            'icon' => 'delete-icon',
            'color' => 'red',
            'modal' => [
                'heading' => 'Cancella Job',
                'description' => 'Vuoi cancellare questo job in attesa?',
            ],
            'messages' => [
                'success' => 'Job cancellato con successo',
            ],
        ],
        'retry' => [
            'label' => 'Riprova',
            'tooltip' => 'Riprova il job fallito',
            'icon' => 'redo',
            'color' => 'yellow',
            'modal' => [
                'heading' => 'Riprova Job',
                'description' => 'Vuoi riprovare questo job?',
            ],
            'messages' => [
                'success' => 'Job riprovato con successo',
            ],
        ],
    ],
    'messages' => ['no_jobs' => 'Nessun job in attesa', 'job_processed' => 'Job processato', 'job_cancelled' => 'Job cancellato', 'job_retried' => 'Job riprovato'],
    'statuses' => ['waiting' => 'In Attesa', 'reserved' => 'Riservato', 'delayed' => 'Ritardato', 'ready' => 'Pronto'],
    'priorities' => ['low' => 'Bassa', 'normal' => 'Normale', 'high' => 'Alta', 'urgent' => 'Urgente'],
    'types' => ['default' => 'Default', 'scheduled' => 'Schedulato', 'recurring' => 'Ricorrente', 'batch' => 'Batch'],
    'label' => 'Job in attesa',
    'plural_label' => 'Jobs in attesa',
];
