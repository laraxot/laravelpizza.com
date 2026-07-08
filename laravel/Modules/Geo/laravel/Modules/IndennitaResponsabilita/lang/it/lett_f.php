<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Lettera F',
        'group' => 'Indennità',
        'sort' => 86,
        'icon' => 'heroicon-o-document-text',
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
        'posizione_lavoro' => [
            'label' => 'Posizione di Lavoro',
            'placeholder' => 'Descrivi la posizione lavorativa',
            'help' => 'Descrizione dettagliata della posizione e delle responsabilità',
        ],
        'complessita' => [
            'label' => 'Complessità',
            'placeholder' => '0-40',
            'help' => 'Valutazione complessità del ruolo (0-40 punti)',
        ],
        'coordinamento' => [
            'label' => 'Coordinamento',
            'placeholder' => '0-30',
            'help' => 'Valutazione attività di coordinamento (0-30 punti)',
        ],
        'responsabilita' => [
            'label' => 'Responsabilità',
            'placeholder' => '0-30',
            'help' => 'Valutazione livello di responsabilità (0-30 punti)',
        ],
        'tot' => [
            'label' => 'Totale',
            'help' => 'Totale punteggio (calcolato automaticamente)',
        ],
        'valore_economico_calcolato' => [
            'label' => 'Valore Economico Calcolato',
            'help' => 'Valore calcolato in base al punteggio',
        ],
        'valore_economico_attribuito' => [
            'label' => 'Valore Economico Attribuito',
            'help' => 'Valore finale attribuito al dipendente',
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
        'posiz' => [
            'label' => 'Posizione',
            'help' => 'Codice posizione',
        ],
        'posiz_txt' => [
            'label' => 'Descrizione Posizione',
            'help' => 'Descrizione testuale della posizione',
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
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuova Lettera F',
            'modal' => [
                'heading' => 'Crea Nuova Valutazione Lettera F',
                'description' => 'Inserisci i dati per creare una nuova valutazione',
            ],
            'success' => 'Valutazione Lettera F creata con successo',
            'error' => 'Errore durante la creazione della valutazione',
        ],
        'edit' => [
            'label' => 'Modifica',
            'modal' => [
                'heading' => 'Modifica Valutazione Lettera F',
                'description' => 'Aggiorna i dati della valutazione',
            ],
            'success' => 'Valutazione aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'modal' => [
                'heading' => 'Elimina Valutazione',
                'description' => 'Sei sicuro di voler eliminare questa valutazione?',
            ],
            'confirmation' => 'Questa azione è irreversibile. Confermi l\'eliminazione?',
            'success' => 'Valutazione eliminata con successo',
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
            'label' => 'Periodo di Validità',
            'description' => 'Range temporale della valutazione',
        ],
        'valutazione' => [
            'label' => 'Criteri di Valutazione',
            'description' => 'Punteggi per complessità, coordinamento e responsabilità',
        ],
        'importi' => [
            'label' => 'Valori Economici',
            'description' => 'Importi calcolati e attribuiti',
        ],
        'classificazione' => [
            'label' => 'Classificazione',
            'description' => 'Profilo professionale e categoria economica',
        ],
    ],
    'messages' => [
        'empty_state' => 'Nessuna valutazione Lettera F trovata',
        'validation_error' => 'Errori di validazione rilevati',
        'saved' => 'Valutazione salvata con successo',
        'auto_calculated' => 'Valori calcolati automaticamente in base ai punteggi',
    ],
    'validation' => [
        'posizione_lavoro' => [
            'required' => 'La descrizione della posizione di lavoro è obbligatoria',
        ],
        'email' => [
            'required' => 'L\'email è obbligatoria',
            'email' => 'L\'email deve essere valida',
        ],
        'complessita' => [
            'required' => 'Il campo complessità è obbligatorio',
            'numeric' => 'Il campo complessità deve essere numerico',
            'min' => 'Il valore minimo per la complessità è 0',
            'max' => 'Il valore massimo per la complessità è 40',
        ],
        'coordinamento' => [
            'required' => 'Il campo coordinamento è obbligatorio',
            'numeric' => 'Il campo coordinamento deve essere numerico',
            'min' => 'Il valore minimo per il coordinamento è 0',
            'max' => 'Il valore massimo per il coordinamento è 30',
        ],
        'responsabilita' => [
            'required' => 'Il campo responsabilità è obbligatorio',
            'numeric' => 'Il campo responsabilità deve essere numerico',
            'min' => 'Il valore minimo per la responsabilità è 0',
            'max' => 'Il valore massimo per la responsabilità è 30',
        ],
    ],
    'hints' => [
        'totale_calculated' => 'Il totale viene calcolato automaticamente sommando complessità + coordinamento + responsabilità',
        'valore_economico' => 'Il valore economico viene calcolato in base al totale e alla categoria di appartenenza',
        'periodo_retribuzione' => 'Il periodo retributivo può essere diverso dal periodo di validità generale',
    ],
];
