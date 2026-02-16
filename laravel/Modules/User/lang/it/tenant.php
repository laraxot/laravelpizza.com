<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Tenant',
    'plural_label' => 'Tenant',
    'group' => 'Gestione Utenti',
    'icon' => 'heroicon-o-building-office',
    'sort' => 30,
  ),
  'label' => 'Tenant',
  'plural_label' => 'Tenant',
  'table' => 
  array (
    'heading' => 
    array (
      'label' => 'Tenant',
      'tooltip' => 'Elenco dei tenant',
      'helper_text' => 'Visualizza tutti i tenant',
      'description' => 'Titolo della tabella tenant',
    ),
  ),
  'fields' => 
  array (
    'first_name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome del tenant',
      'placeholder' => 'Inserisci il nome',
      'helper_text' => 'Nome del tenant o dell\'organizzazione',
      'description' => 'Nome di battesimo del tenant',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'tooltip' => 'Cognome del tenant',
      'placeholder' => 'Inserisci il cognome',
      'helper_text' => 'Cognome o ragione sociale',
      'description' => 'Cognome di famiglia del tenant',
    ),
    'secondary_color' => 
    array (
      'label' => 'Colore Secondario',
      'tooltip' => 'Colore secondario del tema',
      'placeholder' => 'Seleziona colore secondario',
      'helper_text' => 'Colore utilizzato come tono secondario nell\'interfaccia',
      'description' => 'Colore secondario del tema',
    ),
    'slug' => 
    array (
      'label' => 'Slug',
      'tooltip' => 'Identificatore URL-friendly',
      'placeholder' => 'inserisci-slug-univoco',
      'helper_text' => 'Identificatore univoco utilizzato negli URL',
      'description' => 'Slug del tenant',
    ),
    'name' => 
    array (
      'label' => 'Nome Tenant',
      'tooltip' => 'Nome identificativo del tenant',
      'placeholder' => 'Inserisci nome del tenant',
      'helper_text' => 'Nome completo o ragione sociale del tenant',
      'description' => 'Nome del tenant',
    ),
    'id' => 
    array (
      'label' => 'ID',
      'tooltip' => 'Identificatore univoco',
      'placeholder' => 'ID univoco',
      'helper_text' => 'Chiave primaria del tenant nel database',
      'description' => 'Identificatore univoco',
    ),
    'message' => 
    array (
      'label' => 'Messaggio',
      'tooltip' => 'Messaggio informativo',
      'placeholder' => 'Inserisci un messaggio',
      'helper_text' => 'Messaggio di comunicazione per il tenant',
      'description' => 'Messaggio per il tenant',
    ),
    'resetFilters' => 
    array (
      'label' => 'Azzera Filtri',
      'tooltip' => 'Rimuove tutti i filtri applicati',
      'placeholder' => 'Clicca per azzerare',
      'helper_text' => 'Azione per rimuovere tutti i filtri attivi',
      'description' => 'Reimposta i filtri',
    ),
    'applyFilters' => 
    array (
      'label' => 'Applica Filtri',
      'tooltip' => 'Applica i filtri selezionati',
      'placeholder' => 'Clicca per applicare',
      'helper_text' => 'Azione per applicare i filtri configurati',
      'description' => 'Applica i filtri',
    ),
    'recordId' => 
    array (
      'label' => 'ID Record',
      'tooltip' => 'Identificatore del record',
      'placeholder' => 'ID del record',
      'helper_text' => 'Identificatore univoco del record',
      'description' => 'ID del record',
    ),
    'primary_color' => 
    array (
      'label' => 'Colore Primario',
      'tooltip' => 'Colore principale del tema',
      'placeholder' => 'Seleziona colore primario',
      'helper_text' => 'Colore principale utilizzato nell\'interfaccia',
      'description' => 'Colore primario del tema',
    ),
  ),
  'actions' => 
  array (
    'import' => 
    array (
      'label' => 'Importa',
      'tooltip' => 'Importa dati',
      'helper_text' => 'Importa dati da file esterno',
      'description' => 'Azione per importare',
      'fields' => 
      array (
        'import_file' => 
        array (
          'label' => 'File Import',
          'tooltip' => 'Seleziona un file',
          'placeholder' => 'Seleziona un file XLS o CSV da caricare',
          'helper_text' => 'Seleziona un file XLS o CSV da caricare',
          'description' => 'File contenente i dati',
        ),
      ),
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'tooltip' => 'Esporta dati',
      'helper_text' => 'Esporta i dati in formato CSV/Excel',
      'description' => 'Azione per esportare',
      'filename_prefix' => 
      array (
        'label' => 'Prefisso Nome File',
        'tooltip' => 'Prefisso per il nome',
        'placeholder' => 'Inserisci il prefisso',
        'helper_text' => 'Prefisso per il nome del file',
        'description' => 'Prefisso del file',
      ),
      'columns' => 
      array (
        'name' => 
        array (
          'label' => 'Nome Colonna',
          'tooltip' => 'Nome della colonna',
          'helper_text' => 'Nome della colonna',
          'description' => 'Nome della colonna',
        ),
        'parent_name' => 
        array (
          'label' => 'Nome Padre',
          'tooltip' => 'Nome del livello superiore',
          'helper_text' => 'Nome del parent',
          'description' => 'Nome del parent',
        ),
      ),
    ),
    'change_password' => 
    array (
      'label' => 'Cambia Password',
      'tooltip' => 'Cambia la password',
      'helper_text' => 'Modifica la password del tenant',
      'description' => 'Azione per cambiare password',
    ),
    'create' => 
    array (
      'label' => 'Crea',
      'tooltip' => 'Crea nuovo elemento',
      'helper_text' => 'Crea un nuovo tenant',
      'description' => 'Azione per creare',
      'icon' => 'heroicon-o-plus',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'tooltip' => 'Modifica elemento',
      'helper_text' => 'Modifica il tenant',
      'description' => 'Azione per modificare',
      'icon' => 'heroicon-o-pencil',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina elemento',
      'helper_text' => 'Elimina il tenant',
      'description' => 'Azione per eliminare',
      'icon' => 'heroicon-o-trash',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'tooltip' => 'Visualizza dettagli',
      'helper_text' => 'Visualizza i dettagli del tenant',
      'description' => 'Azione per visualizzare',
      'icon' => 'heroicon-o-eye',
    ),
    'save' => 
    array (
      'label' => 'Salva',
      'tooltip' => 'Salva modifiche',
      'helper_text' => 'Salva le modifiche',
      'description' => 'Azione per salvare',
      'icon' => 'heroicon-o-check',
    ),
    'cancel' => 
    array (
      'label' => 'Annulla',
      'tooltip' => 'Annulla operazione',
      'helper_text' => 'Annulla e torna indietro',
      'description' => 'Azione per annullare',
      'icon' => 'heroicon-o-x-mark',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Tenant creato con successo',
    'updated' => 'Tenant aggiornato con successo',
    'deleted' => 'Tenant eliminato con successo',
  ),
);
