<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => [
            'schede' => [
                'name' => 'Scheda',
                'description' => 'Gestione delle schede di valutazione',
                'icon' => 'document-text',
                'sort' => 30,
            ],
        ],
    ],
    'fields' => [
        'common' => [
            'periodo' => [
                'label' => 'Periodo',
                'placeholder' => 'Seleziona il periodo',
                'help' => 'Periodo di valutazione',
            ],
            'risultati_ottenuti' => [
                'label' => 'Risultati Ottenuti',
                'placeholder' => 'Valuta i risultati',
                'help' => 'Valutazione dei risultati raggiunti',
            ],
            'qualita_prestazione' => [
                'label' => 'Qualità della Prestazione',
                'placeholder' => 'Valuta la qualità',
                'help' => 'Valutazione della qualità del lavoro',
            ],
            'arricchimento_professionale' => [
                'label' => 'Arricchimento Professionale',
                'placeholder' => 'Valuta l\'arricchimento',
                'help' => 'Valutazione della crescita professionale',
            ],
            'impegno' => [
                'label' => 'Impegno',
                'placeholder' => 'Valuta l\'impegno',
                'help' => 'Valutazione dell\'impegno profuso',
            ],
            'esperienza_acquisita' => [
                'label' => 'Esperienza Acquisita',
                'placeholder' => 'Valuta l\'esperienza',
                'help' => 'Valutazione dell\'esperienza maturata',
            ],
        ],
    ],
    'messages' => [
        'success' => [
            'created' => 'Scheda creata con successo',
            'updated' => 'Scheda aggiornata con successo',
            'deleted' => 'Scheda eliminata con successo',
        ],
        'error' => [
            'created' => 'Errore durante la creazione della scheda',
            'updated' => 'Errore durante l\'aggiornamento della scheda',
            'deleted' => 'Errore durante l\'eliminazione della scheda',
        ],
    ],
];
