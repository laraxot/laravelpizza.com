<?php

declare(strict_types=1);

return [
    // Campi principali con struttura espansa completa
    'id' => [
        'label' => 'ID',
        'placeholder' => 'ID univoco',
        'help' => 'Identificativo univoco del record',
    ],
    'cognome' => [
        'label' => 'Cognome',
        'placeholder' => 'Inserisci il cognome',
        'help' => 'Il cognome del lavoratore',
    ],
    'nome' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'help' => 'Il nome del lavoratore',
    ],
    'matr' => [
        'label' => 'Matricola',
        'placeholder' => 'Inserisci la matricola',
        'help' => 'Matricola del dipendente',
    ],
    'motivo' => [
        'label' => 'Motivo',
        'placeholder' => 'Inserisci la motivazione',
        'help' => 'Motivo dell\'operazione o della progressione',
    ],
    'anno' => [
        'label' => 'Anno',
        'placeholder' => 'Seleziona l\'anno',
        'help' => 'Anno di riferimento per la progressione',
    ],
    'created_at' => [
        'label' => 'Creato il',
        'placeholder' => 'Data di creazione',
        'help' => 'Data e ora di creazione del record',
    ],
    'updated_at' => [
        'label' => 'Aggiornato il',
        'placeholder' => 'Data di aggiornamento',
        'help' => 'Data e ora dell\'ultimo aggiornamento',
    ],
    'email' => [
        'label' => 'Email',
        'placeholder' => 'Inserisci l\'indirizzo email',
        'help' => 'Indirizzo email del lavoratore',
    ],
    'ente' => [
        'label' => 'Ente',
        'placeholder' => 'Seleziona l\'ente',
        'help' => 'Ente di appartenenza',
    ],
    'stabi' => [
        'label' => 'Stabilimento',
        'placeholder' => 'Seleziona lo stabilimento',
        'help' => 'Stabilimento di appartenenza',
    ],
    'stabi_txt' => [
        'label' => 'Descrizione Stabilimento',
        'placeholder' => 'Descrizione dello stabilimento',
        'help' => 'Descrizione testuale dello stabilimento',
    ],
    'repar' => [
        'label' => 'Reparto',
        'placeholder' => 'Seleziona il reparto',
        'help' => 'Reparto di appartenenza',
    ],
    'repar_txt' => [
        'label' => 'Descrizione Reparto',
        'placeholder' => 'Descrizione del reparto',
        'help' => 'Descrizione testuale del reparto',
    ],
    'rep2kd' => [
        'label' => 'Reparto 2KD',
        'placeholder' => 'Codice reparto 2KD',
        'help' => 'Codice identificativo reparto 2KD',
    ],
    'rep2ka' => [
        'label' => 'Reparto 2KA',
        'placeholder' => 'Codice reparto 2KA',
        'help' => 'Codice identificativo reparto 2KA',
    ],
    'propro' => [
        'label' => 'Profilo Professionale',
        'placeholder' => 'Seleziona il profilo',
        'help' => 'Profilo professionale del lavoratore',
    ],
    'posfun' => [
        'label' => 'Posizione Funzionale',
        'placeholder' => 'Seleziona la posizione',
        'help' => 'Posizione funzionale del lavoratore',
    ],
    'qua2kd' => [
        'label' => 'Qualifica 2KD',
        'placeholder' => 'Codice qualifica 2KD',
        'help' => 'Codice identificativo qualifica 2KD',
    ],
    'qua2ka' => [
        'label' => 'Qualifica 2KA',
        'placeholder' => 'Codice qualifica 2KA',
        'help' => 'Codice identificativo qualifica 2KA',
    ],
    'categoria_eco' => [
        'label' => 'Categoria Economica',
        'placeholder' => 'Seleziona la categoria',
        'help' => 'Categoria economica di appartenenza',
    ],
    'ha_diritto' => [
        'label' => 'Ha Diritto',
        'placeholder' => 'Indica se ha diritto',
        'help' => 'Indica se il lavoratore ha diritto alla progressione',
    ],
    'valutatore_id' => [
        'label' => 'Valutatore',
        'placeholder' => 'Seleziona il valutatore',
        'help' => 'Valutatore responsabile della progressione',
    ],
    'periodo' => [
        'label' => 'Periodo',
        'placeholder' => 'Seleziona il periodo',
        'help' => 'Periodo di riferimento per la valutazione',
    ],
    'dal' => [
        'label' => 'Dal',
        'placeholder' => 'Data di inizio',
        'help' => 'Data di inizio del periodo',
    ],
    'al' => [
        'label' => 'Al',
        'placeholder' => 'Data di fine',
        'help' => 'Data di fine del periodo',
    ],
    'rep' => [
        'label' => 'Reparto',
        'placeholder' => 'Codice reparto',
        'help' => 'Codice identificativo del reparto',
    ],
    'mail_sended_at' => [
        'label' => 'Email Inviata',
        'placeholder' => 'Data invio email',
        'help' => 'Data e ora di invio dell\'email',
    ],
    'lavoratore' => [
        'label' => 'Lavoratore',
        'placeholder' => 'Nome del lavoratore',
        'help' => 'Nome completo del lavoratore',
    ],
    'criteri' => [
        'label' => 'Criteri',
        'placeholder' => 'Criteri di valutazione',
        'help' => 'Criteri utilizzati per la valutazione',
    ],
    'gg' => [
        'label' => 'Giorni',
        'placeholder' => 'Numero di giorni',
        'help' => 'Numero totale di giorni',
    ],
    'gg_no_asz' => [
        'label' => 'Giorni senza assenze',
        'placeholder' => 'Giorni lavorativi',
        'help' => 'Giorni lavorativi senza assenze',
    ],
    'gg_asz' => [
        'label' => 'Giorni di assenza',
        'placeholder' => 'Giorni di assenza',
        'help' => 'Giorni totali di assenza',
    ],
    'gg_cateco_no_posfun_no_asz' => [
        'label' => 'Giorni Categoria senza Posizione',
        'placeholder' => 'Giorni categoria',
        'help' => 'Giorni in categoria economica senza posizione funzionale e senza assenze',
    ],
    'eta' => [
        'label' => 'Età',
        'placeholder' => 'Età del lavoratore',
        'help' => 'Età anagrafica del lavoratore',
    ],
    'qua' => [
        'label' => 'Qualifica',
        'placeholder' => 'Codice qualifica',
        'help' => 'Codice della qualifica professionale',
    ],
    'categoria_ecoval' => [
        'label' => 'Categoria Economica Valutazione',
        'placeholder' => 'Categoria per valutazione',
        'help' => 'Categoria economica utilizzata per la valutazione',
    ],
    'posfunval' => [
        'label' => 'Posizione Funzionale Valutazione',
        'placeholder' => 'Posizione per valutazione',
        'help' => 'Posizione funzionale utilizzata per la valutazione',
    ],
    'posiz' => [
        'label' => 'Posizione',
        'placeholder' => 'Posizione in graduatoria',
        'help' => 'Posizione nella graduatoria di progressione',
    ],
    'posiz_txt' => [
        'label' => 'Descrizione Posizione',
        'placeholder' => 'Descrizione della posizione',
        'help' => 'Descrizione testuale della posizione',
    ],
    'disci1' => [
        'label' => 'Disciplina 1',
        'placeholder' => 'Prima disciplina',
        'help' => 'Prima disciplina di riferimento',
    ],
    'disci1_txt' => [
        'label' => 'Descrizione Disciplina 1',
        'placeholder' => 'Descrizione della disciplina',
        'help' => 'Descrizione testuale della prima disciplina',
    ],
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'help' => 'Nome identificativo',
    ],
    'parent' => [
        'label' => 'Padre',
        'placeholder' => 'Seleziona il padre',
        'help' => 'Elemento padre nella gerarchia',
    ],
    'parent_name' => [
        'label' => 'Nome Padre',
        'placeholder' => 'Nome dell\'elemento padre',
        'help' => 'Nome dell\'elemento padre nella gerarchia',
    ],
    'assets' => [
        'label' => 'Risorse',
        'placeholder' => 'Risorse associate',
        'help' => 'Risorse o allegati associati',
    ],
];
