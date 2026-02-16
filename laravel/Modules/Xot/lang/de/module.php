<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'name' => 'Moduli',
    'plural' => 'Moduli',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Gestione dei moduli e delle estensioni',
    ),
    'label' => 'module',
    'sort' => '17',
    'icon' => 'xot-module',
  ),
  'fields' => 
  array (
    'basic' => 
    array (
      'name' => 
      array (
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome del modulo',
        'help' => 'Nome identificativo del modulo',
      ),
      'description' => 
      array (
        'label' => 'Descrizione',
        'placeholder' => 'Inserisci la descrizione del modulo',
        'help' => 'Descrizione dettagliata delle funzionalità',
      ),
      'version' => 
      array (
        'label' => 'Versione',
        'placeholder' => 'Inserisci la versione (es. 1.0.0)',
        'help' => 'Versione semantica del modulo',
      ),
      'status' => 
      array (
        'label' => 'Stato',
        'help' => 'Stato attuale del modulo',
        'options' => 
        array (
          'enabled' => 'Abilitato',
          'disabled' => 'Disabilitato',
          'pending' => 'In attesa',
          'error' => 'Errore',
        ),
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
    ),
    'details' => 
    array (
      'dependencies' => 
      array (
        'label' => 'Dipendenze',
        'placeholder' => 'Seleziona le dipendenze richieste',
        'help' => 'Altri moduli necessari per il funzionamento',
      ),
      'author' => 
      array (
        'label' => 'Autore',
        'placeholder' => 'Inserisci l\'autore del modulo',
        'help' => 'Sviluppatore o organizzazione',
      ),
      'license' => 
      array (
        'label' => 'Licenza',
        'placeholder' => 'Inserisci la licenza',
        'help' => 'Tipo di licenza del modulo',
        'options' => 
        array (
          'mit' => 'MIT',
          'apache' => 'Apache 2.0',
          'gpl' => 'GPL v3',
          'proprietary' => 'Proprietaria',
        ),
      ),
      'homepage' => 
      array (
        'label' => 'Homepage',
        'placeholder' => 'URL della documentazione',
        'help' => 'Pagina web del modulo',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'system' => 
    array (
      'order' => 
      array (
        'label' => 'Ordine',
        'placeholder' => 'Inserisci l\'ordine di caricamento',
        'help' => 'Priorità di caricamento del modulo',
      ),
      'path' => 
      array (
        'label' => 'Percorso',
        'help' => 'Percorso di installazione del modulo',
      ),
      'namespace' => 
      array (
        'label' => 'Namespace',
        'help' => 'Namespace PHP del modulo',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
    'timestamps' => 
    array (
      'created_at' => 
      array (
        'label' => 'Data Creazione',
        'help' => 'Data di installazione del modulo',
      ),
      'updated_at' => 
      array (
        'label' => 'Ultimo Aggiornamento',
        'help' => 'Data dell\'ultimo aggiornamento',
      ),
      'label' => '',
      'tooltip' => '',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'install' => 
    array (
      'label' => 'Installa',
      'success' => 'Modulo installato con successo',
      'error' => 'Errore durante l\'installazione',
    ),
    'uninstall' => 
    array (
      'label' => 'Disinstalla',
      'success' => 'Modulo disinstallato con successo',
      'error' => 'Errore durante la disinstallazione',
      'confirm' => 'Sei sicuro di voler disinstallare questo modulo?',
    ),
    'enable' => 
    array (
      'label' => 'Abilita',
      'success' => 'Modulo abilitato con successo',
      'error' => 'Errore durante l\'abilitazione',
    ),
    'disable' => 
    array (
      'label' => 'Disabilita',
      'success' => 'Modulo disabilitato con successo',
      'error' => 'Errore durante la disabilitazione',
    ),
    'update' => 
    array (
      'label' => 'Aggiorna',
      'success' => 'Modulo aggiornato con successo',
      'error' => 'Errore durante l\'aggiornamento',
    ),
    'migrate' => 
    array (
      'label' => 'Migra Database',
      'success' => 'Migrazione completata con successo',
      'error' => 'Errore durante la migrazione',
    ),
    'rollback' => 
    array (
      'label' => 'Ripristina Database',
      'success' => 'Ripristino completato con successo',
      'error' => 'Errore durante il ripristino',
    ),
    'publish' => 
    array (
      'label' => 'Pubblica Risorse',
      'success' => 'Risorse pubblicate con successo',
      'error' => 'Errore durante la pubblicazione',
    ),
  ),
  'messages' => 
  array (
    'validation' => 
    array (
      'name' => 
      array (
        'required' => 'Der Name ist erforderlich',
        'unique' => 'Questo nome è già in uso',
        'regex' => 'Il nome può contenere solo lettere, numeri e trattini',
      ),
      'version' => 
      array (
        'required' => 'La versione è obbligatoria',
        'regex' => 'Il formato deve essere X.Y.Z',
      ),
      'dependencies' => 
      array (
        'exists' => 'Uno o più moduli dipendenti non esistono',
        'enabled' => 'Uno o più moduli dipendenti non sono abilitati',
      ),
    ),
    'errors' => 
    array (
      'dependency_missing' => 'Dipendenza mancante: :name',
      'incompatible_version' => 'Versione incompatibile: :name richiede :version',
      'installation_failed' => 'Installazione fallita: :reason',
      'migration_failed' => 'Migrazione fallita: :reason',
      'system_incompatible' => 'Sistema incompatibile: richiede :requirement',
    ),
    'warnings' => 
    array (
      'disable_core' => 'Attenzione: stai per disabilitare un modulo core',
      'uninstall_dependencies' => 'Attenzione: questo modulo ha delle dipendenze',
      'update_available' => 'È disponibile la versione :version',
      'backup_recommended' => 'Si consiglia di effettuare un backup prima di procedere',
    ),
    'info' => 
    array (
      'dependencies_ok' => 'Tutte le dipendenze sono soddisfatte',
      'system_compatible' => 'Il sistema è compatibile',
      'migrations_pending' => 'Ci sono migrazioni in sospeso',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
