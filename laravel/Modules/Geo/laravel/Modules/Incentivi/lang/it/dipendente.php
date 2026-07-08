<?php

declare(strict_types=1);

return [
    'fields' => [
        'nome' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del dipendente',
        ],
        'cognome' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome del dipendente',
        ],
        'matricola' => [
            'label' => 'Matricola',
            'placeholder' => 'Inserisci la matricola',
            'help' => 'Numero di matricola del dipendente',
        ],
        'ruolo' => [
            'label' => 'Ruolo',
            'placeholder' => 'Seleziona ruolo',
            'help' => 'Ruolo del dipendente',
        ],
        'data_assunzione' => [
            'label' => 'Data Assunzione',
            'placeholder' => 'Seleziona data',
            'help' => 'Data di assunzione del dipendente',
        ],
    ],
    'actions' => [
        'assegna_progetto' => 'Assegna a Progetto',
        'rimuovi_progetto' => 'Rimuovi da Progetto',
        'gestisci_incentivi' => 'Gestisci Incentivi',
    ],
    'messages' => [
        'assegnato_progetto' => 'Dipendente assegnato al progetto con successo',
        'rimosso_progetto' => 'Dipendente rimosso dal progetto con successo',
        'incentivi_aggiornati' => 'Incentivi aggiornati con successo',
    ],
];
