<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'group' => 'Sistema',
    'label' => 'Temi Notifiche',
    'icon' => 'notify-theme-animated',
    'sort' => '50',
    'description' => 'Gestione dei temi per le notifiche',
  ),
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Nome',
      'tooltip' => 'Nome del tema',
      'placeholder' => 'es: Tema Aziendale',
      'help' => 'Inserisci un nome descrittivo per il tema',
      'helper_text' => '',
      'description' => '',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'tooltip' => 'Descrizione del tema',
      'placeholder' => 'es: Tema standard per le comunicazioni aziendali',
      'help' => 'Breve descrizione dello scopo del tema',
      'helper_text' => '',
      'description' => '',
    ),
    'colors' => 
    array (
      'label' => 'Colori',
      'tooltip' => 'Schema colori del tema',
      'help' => 'Definisci i colori principali del tema',
      'options' => 
      array (
        'primary' => 
        array (
          'label' => 'Primario',
          'tooltip' => 'Colore principale del tema',
          'placeholder' => 'es: #4A90E2',
        ),
        'secondary' => 
        array (
          'label' => 'Secondario',
          'tooltip' => 'Colore secondario del tema',
          'placeholder' => 'es: #5C6AC4',
        ),
        'accent' => 
        array (
          'label' => 'Accento',
          'tooltip' => 'Colore di accento per elementi in evidenza',
          'placeholder' => 'es: #F5A623',
        ),
        'success' => 
        array (
          'label' => 'Successo',
          'tooltip' => 'Colore per messaggi di successo',
          'placeholder' => 'es: #7CBD5C',
        ),
        'warning' => 
        array (
          'label' => 'Attenzione',
          'tooltip' => 'Colore per messaggi di avviso',
          'placeholder' => 'es: #F5A623',
        ),
        'error' => 
        array (
          'label' => 'Errore',
          'tooltip' => 'Colore per messaggi di errore',
          'placeholder' => 'es: #D0021B',
        ),
      ),
      'helper_text' => '',
      'description' => '',
    ),
    'typography' => 
    array (
      'label' => 'Tipografia',
      'tooltip' => 'Impostazioni tipografiche',
      'help' => 'Configura i font e le dimensioni del testo',
      'options' => 
      array (
        'font_family' => 
        array (
          'label' => 'Font principale',
          'tooltip' => 'Font utilizzato per il testo principale',
          'placeholder' => 'es: Arial, sans-serif',
        ),
        'heading_font' => 
        array (
          'label' => 'Font titoli',
          'tooltip' => 'Font utilizzato per i titoli',
          'placeholder' => 'es: Helvetica, Arial, sans-serif',
        ),
        'font_sizes' => 
        array (
          'label' => 'Dimensioni font',
          'tooltip' => 'Dimensioni dei caratteri',
          'options' => 
          array (
            'small' => 
            array (
              'label' => 'Piccolo',
              'tooltip' => 'Testo piccolo (es: note)',
            ),
            'normal' => 
            array (
              'label' => 'Normale',
              'tooltip' => 'Testo normale',
            ),
            'large' => 
            array (
              'label' => 'Grande',
              'tooltip' => 'Testo grande (es: titoli)',
            ),
          ),
        ),
      ),
      'helper_text' => '',
      'description' => '',
    ),
    'layout' => 
    array (
      'label' => 'Layout',
      'tooltip' => 'Impostazioni del layout',
      'help' => 'Configura la struttura del template',
      'options' => 
      array (
        'header' => 
        array (
          'label' => 'Intestazione',
          'tooltip' => 'Stile dell\'intestazione',
        ),
        'footer' => 
        array (
          'label' => 'Piè di pagina',
          'tooltip' => 'Stile del piè di pagina',
        ),
        'spacing' => 
        array (
          'label' => 'Spaziatura',
          'tooltip' => 'Spaziatura tra gli elementi',
        ),
      ),
      'helper_text' => '',
      'description' => '',
    ),
    'assets' => 
    array (
      'label' => 'Risorse',
      'tooltip' => 'Risorse del tema',
      'help' => 'Gestisci le risorse associate al tema',
      'options' => 
      array (
        'logo' => 
        array (
          'label' => 'Logo',
          'tooltip' => 'Logo da utilizzare nelle notifiche',
        ),
        'background' => 
        array (
          'label' => 'Sfondo',
          'tooltip' => 'Immagine di sfondo',
        ),
        'icons' => 
        array (
          'label' => 'Icone',
          'tooltip' => 'Set di icone del tema',
        ),
      ),
      'helper_text' => '',
      'description' => '',
    ),
    'is_default' => 
    array (
      'label' => 'Predefinito',
      'tooltip' => 'Imposta come tema predefinito',
      'help' => 'Il tema predefinito verrà utilizzato per tutte le notifiche senza tema specifico',
      'helper_text' => '',
      'description' => '',
    ),
    'is_active' => 
    array (
      'label' => 'Attivo',
      'tooltip' => 'Stato di attivazione del tema',
      'help' => 'Solo i temi attivi possono essere utilizzati',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'preview' => 
    array (
      'label' => 'Anteprima',
      'tooltip' => 'Visualizza anteprima del tema',
      'icon' => 'heroicon-o-eye',
      'color' => 'primary',
    ),
    'duplicate' => 
    array (
      'label' => 'Duplica',
      'tooltip' => 'Crea una copia del tema',
      'icon' => 'heroicon-o-document-duplicate',
      'color' => 'info',
      'confirmation' => 
      array (
        'title' => 'Conferma duplicazione',
        'message' => 'Vuoi creare una copia di questo tema?',
        'confirm' => 'Sì, duplica',
        'cancel' => 'No, annulla',
      ),
    ),
    'export' => 
    array (
      'label' => 'Esporta',
      'tooltip' => 'Esporta configurazione del tema',
      'icon' => 'heroicon-o-arrow-down-tray',
      'color' => 'success',
    ),
    'import' => 
    array (
      'label' => 'Importa',
      'tooltip' => 'Importa configurazione del tema',
      'icon' => 'heroicon-o-arrow-up-tray',
      'color' => 'warning',
    ),
    'set_default' => 
    array (
      'label' => 'Imposta predefinito',
      'tooltip' => 'Imposta questo tema come predefinito',
      'icon' => 'heroicon-o-star',
      'color' => 'primary',
      'confirmation' => 
      array (
        'title' => 'Conferma impostazione predefinito',
        'message' => 'Vuoi impostare questo tema come predefinito?',
        'confirm' => 'Sì, imposta',
        'cancel' => 'No, annulla',
      ),
    ),
  ),
  'messages' => 
  array (
    'preview_title' => 
    array (
      'title' => 'Anteprima Tema',
      'message' => 'Questa è un\'anteprima di come apparirà il tema',
    ),
    'duplicated' => 
    array (
      'title' => 'Tema Duplicato',
      'message' => 'Il tema è stato duplicato con successo',
    ),
    'export_success' => 
    array (
      'title' => 'Esportazione Completata',
      'message' => 'La configurazione del tema è stata esportata con successo',
    ),
    'import_success' => 
    array (
      'title' => 'Importazione Completata',
      'message' => 'La configurazione del tema è stata importata con successo',
    ),
    'set_default_success' => 
    array (
      'title' => 'Tema Predefinito',
      'message' => 'Il tema è stato impostato come predefinito',
    ),
  ),
  'filters' => 
  array (
    'status' => 
    array (
      'label' => 'Stato',
      'tooltip' => 'Filtra per stato di attivazione',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'tooltip' => 'Filtra per tipo di tema',
    ),
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
