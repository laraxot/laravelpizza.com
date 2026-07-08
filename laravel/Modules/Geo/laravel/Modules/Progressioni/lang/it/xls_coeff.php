<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Coefficienti XLS',
        'plural' => 'Coefficienti XLS',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 18,
        'icon' => 'heroicon-o-calculator',
        'label' => 'Coefficienti XLS',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome identificativo del coefficiente',
        ],
        'parent' => [
            'label' => 'Padre',
            'placeholder' => 'Seleziona l\'elemento padre',
            'help' => 'Elemento di livello superiore nella gerarchia',
        ],
        'parent_name' => [
            'label' => 'Nome Padre',
            'placeholder' => 'Nome dell\'elemento padre',
            'help' => 'Nome dell\'elemento di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse',
            'placeholder' => 'Seleziona le risorse associate',
            'help' => 'Risorse collegate a questo coefficiente',
        ],
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco del coefficiente',
        ],
        'ente' => [
            'label' => 'Ente',
            'placeholder' => 'Seleziona l\'ente',
            'help' => 'Ente di appartenenza',
        ],
        'matr' => [
            'label' => 'Matricola',
            'placeholder' => 'Inserisci la matricola',
            'help' => 'Matricola del dipendente',
        ],
        'cognome' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome del dipendente',
        ],
        'nome' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del dipendente',
        ],
        'ptime' => [
            'label' => 'Part-time',
            'placeholder' => 'Indica se part-time',
            'help' => 'Indica se il dipendente lavora part-time',
        ],
        'costo_fascia_up' => [
            'label' => 'Costo Fascia UP',
            'placeholder' => 'Inserisci il costo fascia',
            'help' => 'Costo della fascia UP',
        ],
        'disci1' => [
            'label' => 'Disciplina 1',
            'placeholder' => 'Seleziona la disciplina',
            'help' => 'Prima disciplina di riferimento',
        ],
        'disci1_txt' => [
            'label' => 'Testo Disciplina 1',
            'placeholder' => 'Inserisci il testo della disciplina',
            'help' => 'Testo descrittivo della prima disciplina',
        ],
        'propro' => [
            'label' => 'ProPro',
            'placeholder' => 'Seleziona ProPro',
            'help' => 'Progressione professionale',
        ],
        'posfun' => [
            'label' => 'Posizione Funzionale',
            'placeholder' => 'Seleziona la posizione funzionale',
            'help' => 'Posizione funzionale del dipendente',
        ],
        'categoria_eco' => [
            'label' => 'Categoria Economica',
            'placeholder' => 'Seleziona la categoria economica',
            'help' => 'Categoria economica del dipendente',
        ],
        'stabi' => [
            'label' => 'Stabilimento',
            'placeholder' => 'Seleziona lo stabilimento',
            'help' => 'Stabilimento di appartenenza',
        ],
        'stabi_txt' => [
            'label' => 'Testo Stabilimento',
            'placeholder' => 'Inserisci il testo dello stabilimento',
            'help' => 'Testo descrittivo dello stabilimento',
        ],
        'repar' => [
            'label' => 'Reparto',
            'placeholder' => 'Seleziona il reparto',
            'help' => 'Reparto di appartenenza',
        ],
        'repar_txt' => [
            'label' => 'Testo Reparto',
            'placeholder' => 'Inserisci il testo del reparto',
            'help' => 'Testo descrittivo del reparto',
        ],
        'ha_diritto' => [
            'label' => 'Ha Diritto',
            'placeholder' => 'Indica se ha diritto',
            'help' => 'Indica se il dipendente ha diritto alla progressione',
        ],
        'motivo' => [
            'label' => 'Motivo',
            'placeholder' => 'Inserisci il motivo',
            'help' => 'Motivo della decisione',
        ],
        'valutatore_txt' => [
            'label' => 'Testo Valutatore',
            'placeholder' => 'Inserisci il testo del valutatore',
            'help' => 'Testo descrittivo del valutatore',
        ],
        'gg_propro_posfun' => [
            'label' => 'Giorni ProPro PosFun',
            'placeholder' => 'Inserisci i giorni',
            'help' => 'Giorni di progressione professionale nella posizione funzionale',
        ],
        'gg_cateco_posfun_no_asz' => [
            'label' => 'Giorni CatEco PosFun Senza Assenze',
            'placeholder' => 'Inserisci i giorni',
            'help' => 'Giorni nella categoria economica e posizione funzionale senza assenze',
        ],
        'gg_cateco_posfun_lavorati_in_sede' => [
            'label' => 'Giorni CatEco PosFun Lavorati in Sede',
            'placeholder' => 'Inserisci i giorni',
            'help' => 'Giorni lavorati in sede nella categoria economica e posizione funzionale',
        ],
        'gg_anno' => [
            'label' => 'Giorni Anno',
            'placeholder' => 'Inserisci i giorni dell\'anno',
            'help' => 'Giorni lavorati nell\'anno di riferimento',
        ],
        'gg_cateco_posfun_in_sede_no_asz' => [
            'label' => 'Giorni CatEco PosFun in Sede Senza Assenze',
            'placeholder' => 'Inserisci i giorni',
            'help' => 'Giorni in sede nella categoria economica e posizione funzionale senza assenze',
        ],
        'gg_asz_cateco_posfun_fuori_sede' => [
            'label' => 'Giorni Assenze CatEco PosFun Fuori Sede',
            'placeholder' => 'Inserisci i giorni',
            'help' => 'Giorni di assenze nella categoria economica e posizione funzionale fuori sede',
        ],
        'gg_asz_cateco_posfun_in_sede' => [
            'label' => 'Giorni Assenze CatEco PosFun in Sede',
            'placeholder' => 'Inserisci i giorni',
            'help' => 'Giorni di assenze nella categoria economica e posizione funzionale in sede',
        ],
        'gg_cateco_posfun_in_sede' => [
            'label' => 'Giorni CatEco PosFun in Sede',
            'placeholder' => 'Inserisci i giorni',
            'help' => 'Giorni nella categoria economica e posizione funzionale in sede',
        ],
        'gg_cateco_posfun_fuori_sede' => [
            'label' => 'Giorni CatEco PosFun Fuori Sede',
            'placeholder' => 'Inserisci i giorni',
            'help' => 'Giorni nella categoria economica e posizione funzionale fuori sede',
        ],
        'excellences_count_last_3_years' => [
            'label' => 'Eccellenze Ultimi 3 Anni',
            'placeholder' => 'Numero di eccellenze',
            'help' => 'Numero di eccellenze ottenute negli ultimi 3 anni',
        ],
        'perf_ind_media' => [
            'label' => 'Performance Individuale Media',
            'placeholder' => 'Punteggio medio',
            'help' => 'Punteggio medio della performance individuale',
        ],
        'gg_in_sede_no_asz' => [
            'label' => 'Giorni in Sede Senza Assenze',
            'placeholder' => 'Inserisci i giorni',
            'help' => 'Giorni lavorati in sede senza assenze',
        ],
        'eta' => [
            'label' => 'Età',
            'placeholder' => 'Inserisci l\'età',
            'help' => 'Età del dipendente',
        ],
        'perf_ind_2020' => [
            'label' => 'Performance Individuale 2020',
            'placeholder' => 'Punteggio 2020',
            'help' => 'Punteggio performance individuale 2020',
        ],
        'perf_ind_2019' => [
            'label' => 'Performance Individuale 2019',
            'placeholder' => 'Punteggio 2019',
            'help' => 'Punteggio performance individuale 2019',
        ],
        'perf_ind_2018' => [
            'label' => 'Performance Individuale 2018',
            'placeholder' => 'Punteggio 2018',
            'help' => 'Punteggio performance individuale 2018',
        ],
        'valore_differenziale_rapportato_pt' => [
            'label' => 'Valore Differenziale Rapportato PT',
            'placeholder' => 'Inserisci il valore',
            'help' => 'Valore differenziale rapportato a tempo parziale',
        ],
        'gg_posiz_1_in_sede' => [
            'label' => 'Giorni Posizione 1 in Sede',
            'placeholder' => 'Inserisci i giorni',
            'help' => 'Giorni nella prima posizione in sede',
        ],
        'gg_propro' => [
            'label' => 'Giorni ProPro',
            'placeholder' => 'Inserisci i giorni',
            'help' => 'Giorni di progressione professionale',
        ],
        'perf_ind_2021' => [
            'label' => 'Performance Individuale 2021',
            'placeholder' => 'Punteggio 2021',
            'help' => 'Punteggio performance individuale 2021',
        ],
    ],
];
