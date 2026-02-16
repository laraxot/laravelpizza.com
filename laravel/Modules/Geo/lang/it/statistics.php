<?php

declare(strict_types=1);

return array (
  'fields' => 
  array (
    'metric' => 
    array (
      'label' => 'Metrica',
      'placeholder' => 'Seleziona la metrica da calcolare',
      'help' => 'Tipo di metrica statistica da calcolare',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'dimension' => 
    array (
      'label' => 'Dimensione',
      'placeholder' => 'Seleziona la dimensione di analisi',
      'help' => 'Dimensione per l\'analisi statistica',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'time_range' => 
    array (
      'label' => 'Intervallo temporale',
      'placeholder' => 'Seleziona l\'intervallo temporale',
      'help' => 'Intervallo temporale per l\'analisi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'group_by' => 
    array (
      'label' => 'Raggruppa per',
      'placeholder' => 'Seleziona i campi di raggruppamento',
      'help' => 'Campi per raggruppare i risultati',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'filters' => 
    array (
      'label' => 'Filtri',
      'placeholder' => 'Configura i filtri per l\'analisi',
      'help' => 'Filtri da applicare ai dati',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'sort_by' => 
    array (
      'label' => 'Ordina per',
      'placeholder' => 'Seleziona il campo di ordinamento',
      'help' => 'Campo per ordinare i risultati',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'sort_direction' => 
    array (
      'label' => 'Direzione ordinamento',
      'placeholder' => 'Seleziona la direzione',
      'help' => 'Direzione dell\'ordinamento',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'limit' => 
    array (
      'label' => 'Limite',
      'placeholder' => 'Inserisci il numero massimo di risultati',
      'help' => 'Numero massimo di risultati da restituire',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'format' => 
    array (
      'label' => 'Formato',
      'placeholder' => 'Seleziona il formato di output',
      'help' => 'Formato per i risultati dell\'analisi',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'validation' => 
  array (
    'metric_required' => 'La metrica è obbligatoria',
    'metric_invalid' => 'La metrica non è valida',
    'dimension_required' => 'La dimensione è obbligatoria',
    'dimension_invalid' => 'La dimensione non è valida',
    'time_range_required' => 'L\'intervallo temporale è obbligatorio',
    'time_range_invalid' => 'L\'intervallo temporale non è valido',
    'group_by_array' => 'Il raggruppamento deve essere un array',
    'filters_array' => 'I filtri devono essere un array',
    'sort_by_string' => 'L\'ordinamento deve essere una stringa',
    'sort_direction_invalid' => 'La direzione di ordinamento non è valida',
    'limit_numeric' => 'Il limite deve essere numerico',
    'limit_min' => 'Il limite deve essere almeno 1',
    'limit_max' => 'Il limite non può superare 10000',
    'format_required' => 'Il formato è obbligatorio',
    'format_invalid' => 'Il formato non è valido',
  ),
  'messages' => 
  array (
    'statistics_calculated' => 'Statistiche calcolate con successo',
    'statistics_updated' => 'Statistiche aggiornate con successo',
    'statistics_cached' => 'Statistiche memorizzate in cache con successo',
    'statistics_exported' => 'Statistiche esportate con successo',
    'statistics_imported' => 'Statistiche importate con successo',
    'statistics_analyzed' => 'Statistiche analizzate con successo',
    'statistics_visualized' => 'Statistiche visualizzate con successo',
    'statistics_compared' => 'Statistiche confrontate con successo',
    'statistics_trended' => 'Tendenze statistiche calcolate con successo',
    'statistics_forecasted' => 'Previsioni statistiche calcolate con successo',
  ),
  'errors' => 
  array (
    'statistics_calculation_failed' => 'Impossibile calcolare le statistiche',
    'statistics_update_failed' => 'Impossibile aggiornare le statistiche',
    'statistics_caching_failed' => 'Impossibile memorizzare le statistiche in cache',
    'statistics_export_failed' => 'Impossibile esportare le statistiche',
    'statistics_import_failed' => 'Impossibile importare le statistiche',
    'statistics_analysis_failed' => 'Impossibile analizzare le statistiche',
    'statistics_visualization_failed' => 'Impossibile visualizzare le statistiche',
    'statistics_comparison_failed' => 'Impossibile confrontare le statistiche',
    'statistics_trend_calculation_failed' => 'Impossibile calcolare le tendenze',
    'statistics_forecast_calculation_failed' => 'Impossibile calcolare le previsioni',
    'metric_not_supported' => 'Metrica non supportata',
    'dimension_not_supported' => 'Dimensione non supportata',
    'time_range_invalid' => 'Intervallo temporale non valido',
    'data_insufficient' => 'Dati insufficienti per l\'analisi',
    'calculation_timeout' => 'Timeout del calcolo statistico',
    'memory_limit_exceeded' => 'Limite di memoria superato',
  ),
  'statistical_metrics' => 
  array (
    'count' => 'Conteggio',
    'sum' => 'Somma',
    'average' => 'Media',
    'median' => 'Mediana',
    'mode' => 'Moda',
    'min' => 'Minimo',
    'max' => 'Massimo',
    'range' => 'Range',
    'variance' => 'Varianza',
    'standard_deviation' => 'Deviazione standard',
    'percentile' => 'Percentile',
    'quartile' => 'Quartile',
    'skewness' => 'Asimmetria',
    'kurtosis' => 'Curtosi',
    'correlation' => 'Correlazione',
    'regression' => 'Regressione',
    'growth_rate' => 'Tasso di crescita',
    'change_rate' => 'Tasso di variazione',
    'cumulative' => 'Cumulativo',
    'moving_average' => 'Media mobile',
  ),
  'statistical_dimensions' => 
  array (
    'time' => 'Tempo',
    'location' => 'Posizione',
    'category' => 'Categoria',
    'type' => 'Tipo',
    'status' => 'Stato',
    'user' => 'Utente',
    'region' => 'Regione',
    'country' => 'Paese',
    'city' => 'Città',
    'province' => 'Provincia',
    'municipality' => 'Comune',
    'postal_code' => 'CAP',
    'boundary' => 'Confine',
    'area' => 'Area',
    'population' => 'Popolazione',
    'density' => 'Densità',
    'elevation' => 'Elevazione',
    'climate' => 'Clima',
    'timezone' => 'Fuso orario',
    'currency' => 'Valuta',
    'language' => 'Lingua',
  ),
  'time_ranges' => 
  array (
    'hour' => 'Ora',
    'day' => 'Giorno',
    'week' => 'Settimana',
    'month' => 'Mese',
    'quarter' => 'Trimestre',
    'year' => 'Anno',
    'decade' => 'Decennio',
    'century' => 'Secolo',
    'custom' => 'Personalizzato',
  ),
  'output_formats' => 
  array (
    'json' => 'JSON',
    'xml' => 'XML',
    'csv' => 'CSV',
    'excel' => 'Excel',
    'pdf' => 'PDF',
    'html' => 'HTML',
    'chart' => 'Grafico',
    'table' => 'Tabella',
    'text' => 'Testo',
    'binary' => 'Binario',
  ),
  'chart_types' => 
  array (
    'line' => 'Linea',
    'bar' => 'Barra',
    'pie' => 'Torta',
    'doughnut' => 'Ciambella',
    'area' => 'Area',
    'scatter' => 'Dispersione',
    'bubble' => 'Bolla',
    'radar' => 'Radar',
    'polar' => 'Polare',
    'histogram' => 'Istogramma',
    'boxplot' => 'Box plot',
    'heatmap' => 'Mappa di calore',
    'treemap' => 'Mappa ad albero',
    'sankey' => 'Diagramma di Sankey',
    'funnel' => 'Imbuto',
    'gauge' => 'Tachimetro',
    'candlestick' => 'Candeliere',
    'waterfall' => 'Cascata',
  ),
  'label' => 'Statistics',
  'plural_label' => 'Statistics (Plurale)',
  'navigation' => 
  array (
    'name' => 'Statistics',
    'plural' => 'Statistics',
    'group' => 
    array (
      'name' => 'General',
      'description' => 'General Settings',
    ),
    'label' => 'Statistics',
    'sort' => 1,
    'icon' => 'heroicon-o-collection',
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Statistics',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Statistics',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Statistics',
    ),
  ),
);
