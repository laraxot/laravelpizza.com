<?php

declare(strict_types=1);

return [
    'tooltip' => [
        'label' => 'Ricalcola valore',
        'placeholder' => '',
        'help' => 'Riesegue il getter sul record e aggiorna il campo del form.',
    ],
    'notifications' => [
        'invalid_record' => [
            'title' => 'Errore',
            'body' => 'Record non valido.',
        ],
        'method_missing' => [
            'title' => 'Ricalcolo non disponibile',
            'body' => 'Il modello non espone il metodo richiesto per questo campo. Verifica che il record estenda la base corretta (es. BaseIndividualeModel con EnteMatrDateRangeMutator) e che il deploy sia allineato al codice.',
        ],
        'success' => [
            'title' => 'Valore :name ricalcolato',
            'body' => 'Il valore del campo Ã¨ stato ricalcolato con successo. Nuovo valore: :value',
        ],
    ],
];
