<?php

declare(strict_types=1);

return [
    // Validazioni generali
    'required' => 'Il campo :attribute è obbligatorio',
    'string' => 'Il campo :attribute deve essere una stringa',
    'numeric' => 'Il campo :attribute deve essere un numero',
    'integer' => 'Il campo :attribute deve essere un numero intero',
    'date' => 'Il campo :attribute deve essere una data valida',
    'boolean' => 'Il campo :attribute deve essere vero o falso',
    'array' => 'Il campo :attribute deve essere un array',
    'file' => 'Il campo :attribute deve essere un file',
    'image' => 'Il campo :attribute deve essere un\'immagine',
    'url' => 'Il campo :attribute deve essere un URL valido',

    // Validazioni di lunghezza
    'min' => [
        'string' => 'Il campo :attribute deve contenere almeno :min caratteri',
        'numeric' => 'Il campo :attribute deve essere almeno :min',
        'file' => 'Il campo :attribute deve essere almeno :min kilobytes',
        'array' => 'Il campo :attribute deve contenere almeno :min elementi',
    ],
    'max' => [
        'string' => 'Il campo :attribute non può contenere più di :max caratteri',
        'numeric' => 'Il campo :attribute non può essere maggiore di :max',
        'file' => 'Il campo :attribute non può essere maggiore di :max kilobytes',
        'array' => 'Il campo :attribute non può contenere più di :max elementi',
    ],
    'between' => [
        'string' => 'Il campo :attribute deve contenere tra :min e :max caratteri',
        'numeric' => 'Il campo :attribute deve essere tra :min e :max',
        'file' => 'Il campo :attribute deve essere tra :min e :max kilobytes',
        'array' => 'Il campo :attribute deve contenere tra :min e :max elementi',
    ],
    'size' => [
        'string' => 'Il campo :attribute deve contenere esattamente :size caratteri',
        'numeric' => 'Il campo :attribute deve essere :size',
        'file' => 'Il campo :attribute deve essere :size kilobytes',
        'array' => 'Il campo :attribute deve contenere esattamente :size elementi',
    ],

    // Validazioni di unicità e esistenza
    'unique' => 'Il valore del campo :attribute è già stato utilizzato',
    'exists' => 'Il valore selezionato per :attribute non è valido',
    'distinct' => 'Il campo :attribute contiene un valore duplicato',

    // Validazioni di formato
    'alpha' => 'Il campo :attribute può contenere solo lettere',
    'alpha_dash' => 'Il campo :attribute può contenere solo lettere, numeri, trattini e underscore',
    'alpha_num' => 'Il campo :attribute può contenere solo lettere e numeri',
    'regex' => 'Il formato del campo :attribute non è valido',

    // Validazioni di data
    'after' => 'Il campo :attribute deve essere una data successiva a :date',
    'after_or_equal' => 'Il campo :attribute deve essere una data successiva o uguale a :date',
    'before' => 'Il campo :attribute deve essere una data precedente a :date',
    'before_or_equal' => 'Il campo :attribute deve essere una data precedente o uguale a :date',
    'date_equals' => 'Il campo :attribute deve essere una data uguale a :date',
    'date_format' => 'Il campo :attribute non corrisponde al formato :format',

    // Validazioni di conferma
    'confirmed' => 'La conferma del campo :attribute non corrisponde',
    'same' => 'Il campo :attribute e :other devono corrispondere',
    'different' => 'Il campo :attribute e :other devono essere diversi',

    // Validazioni per file
    'mimes' => 'Il campo :attribute deve essere un file di tipo: :values',
    'mimetypes' => 'Il campo :attribute deve essere un file di tipo: :values',
    'dimensions' => 'Il campo :attribute ha dimensioni dell\'immagine non valide',

    // Validazioni specifiche per progressioni
    'anno' => [
        'required' => 'L\'anno è obbligatorio',
        'numeric' => 'L\'anno deve essere un numero',
        'min' => 'L\'anno deve essere almeno :min',
        'max' => 'L\'anno non può essere maggiore di :max',
        'current_or_past' => 'L\'anno non può essere futuro',
    ],
    'matricola' => [
        'required' => 'La matricola è obbligatoria',
        'unique' => 'La matricola deve essere unica',
        'alpha_num' => 'La matricola può contenere solo lettere e numeri',
        'max' => 'La matricola non può superare :max caratteri',
    ],
    'email' => [
        'required' => 'L\'email è obbligatoria',
        'email' => 'L\'email deve essere un indirizzo valido',
        'unique' => 'Questa email è già in uso',
        'max' => 'L\'email non può superare :max caratteri',
    ],
    'nome' => [
        'required' => 'Il nome è obbligatorio',
        'string' => 'Il nome deve essere una stringa',
        'max' => 'Il nome non può superare :max caratteri',
        'alpha' => 'Il nome può contenere solo lettere',
    ],
    'cognome' => [
        'required' => 'Il cognome è obbligatorio',
        'string' => 'Il cognome deve essere una stringa',
        'max' => 'Il cognome non può superare :max caratteri',
        'alpha' => 'Il cognome può contenere solo lettere',
    ],
    'valutatore_id' => [
        'required' => 'Il valutatore è obbligatorio',
        'exists' => 'Il valutatore selezionato non è valido',
        'numeric' => 'L\'ID del valutatore deve essere un numero',
    ],
    'stabi' => [
        'required' => 'Lo stabilimento è obbligatorio',
        'exists' => 'Lo stabilimento selezionato non è valido',
        'numeric' => 'L\'ID dello stabilimento deve essere un numero',
    ],
    'periodo' => [
        'required' => 'Il periodo è obbligatorio',
        'date_format' => 'Il formato del periodo non è valido',
    ],
    'dal' => [
        'required' => 'La data di inizio è obbligatoria',
        'date' => 'La data di inizio deve essere una data valida',
        'before_or_equal' => 'La data di inizio deve essere precedente o uguale alla data di fine',
    ],
    'al' => [
        'required' => 'La data di fine è obbligatoria',
        'date' => 'La data di fine deve essere una data valida',
        'after_or_equal' => 'La data di fine deve essere successiva o uguale alla data di inizio',
    ],
    'categoria_eco' => [
        'required' => 'La categoria economica è obbligatoria',
        'string' => 'La categoria economica deve essere una stringa',
        'max' => 'La categoria economica non può superare :max caratteri',
    ],
    'profilo_professionale' => [
        'required' => 'Il profilo professionale è obbligatorio',
        'string' => 'Il profilo professionale deve essere una stringa',
        'max' => 'Il profilo professionale non può superare :max caratteri',
    ],
    'posizione_funzionale' => [
        'required' => 'La posizione funzionale è obbligatoria',
        'string' => 'La posizione funzionale deve essere una stringa',
        'max' => 'La posizione funzionale non può superare :max caratteri',
    ],
    'giorni' => [
        'numeric' => 'I giorni devono essere un numero',
        'min' => 'I giorni non possono essere negativi',
        'max' => 'I giorni non possono superare :max',
    ],
    'eta' => [
        'numeric' => 'L\'età deve essere un numero',
        'min' => 'L\'età deve essere almeno :min anni',
        'max' => 'L\'età non può superare :max anni',
    ],
    'punteggio' => [
        'numeric' => 'Il punteggio deve essere un numero',
        'min' => 'Il punteggio non può essere negativo',
        'max' => 'Il punteggio non può superare :max',
    ],
    'file_import' => [
        'required' => 'Il file da importare è obbligatorio',
        'file' => 'Deve essere un file valido',
        'mimes' => 'Il file deve essere di tipo: XLS, XLSX, CSV',
        'max' => 'Il file non può superare :max MB',
    ],

    // Messaggi di errore personalizzati per attributi specifici
    'attributes' => [
        'anno' => 'anno',
        'matricola' => 'matricola',
        'nome' => 'nome',
        'cognome' => 'cognome',
        'email' => 'email',
        'valutatore_id' => 'valutatore',
        'stabi' => 'stabilimento',
        'periodo' => 'periodo',
        'dal' => 'data di inizio',
        'al' => 'data di fine',
        'categoria_eco' => 'categoria economica',
        'profilo_professionale' => 'profilo professionale',
        'posizione_funzionale' => 'posizione funzionale',
        'giorni' => 'giorni',
        'eta' => 'età',
        'punteggio' => 'punteggio',
        'file_import' => 'file da importare',
        'motivo' => 'motivo',
        'criteri' => 'criteri',
        'posizione' => 'posizione',
        'disciplina' => 'disciplina',
    ],
];
