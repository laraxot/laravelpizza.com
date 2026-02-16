<?php

declare(strict_types=1);

return array (
  'navigation' => 
  array (
    'label' => 'Azioni CMS',
    'plural_label' => 'Azioni CMS',
    'group' => 'Sistema CMS',
    'icon' => 'heroicon-o-cursor-arrow-ripple',
    'sort' => 120,
    'badge' => 'Gestione azioni CMS',
  ),
  'model' => 
  array (
    'label' => 'Azione CMS',
    'plural' => 'Azioni CMS',
    'description' => 'Sistema di azioni e controlli per il Content Management System',
  ),
  'fields' => 
  array (
    'items' => 
    array (
      'label' => 'Elementi',
      'placeholder' => 'Seleziona o aggiungi elementi',
      'tooltip' => 'Elementi dell\'azione',
      'helper_text' => 'Lista degli elementi che compongono l\'azione',
      'help' => 'Seleziona gli elementi che faranno parte di questa azione',
      'description' => 'items',
    ),
    'label' => 
    array (
      'label' => 'Etichetta',
      'placeholder' => 'Inserisci l\'etichetta',
      'tooltip' => 'Etichetta dell\'azione',
      'helper_text' => 'Testo che viene visualizzato per identificare l\'azione',
      'help' => 'Inserisci un\'etichetta descrittiva per l\'azione',
      'description' => 'label',
    ),
    'url' => 
    array (
      'label' => 'URL',
      'placeholder' => 'Inserisci l\'URL',
      'tooltip' => 'URL di destinazione',
      'helper_text' => 'Indirizzo web a cui l\'azione reindirizzerà l\'utente',
      'help' => 'Inserisci l\'URL completo di destinazione',
      'description' => 'url',
    ),
    'style' => 
    array (
      'label' => 'Stile',
      'placeholder' => 'Seleziona lo stile',
      'tooltip' => 'Stile visivo dell\'azione',
      'helper_text' => 'Aspetto visivo e styling applicato all\'azione',
      'help' => 'Scegli lo stile più appropriato per l\'azione',
      'description' => 'style',
    ),
    'icon' => 
    array (
      'label' => 'Icona',
      'placeholder' => 'Seleziona un\'icona',
      'tooltip' => 'Icona dell\'azione',
      'helper_text' => 'Icona grafica che rappresenta l\'azione nell\'interfaccia',
      'help' => 'Scegli un\'icona che rappresenti chiaramente l\'azione',
      'description' => 'icon',
    ),
    'size' => 
    array (
      'label' => 'Dimensione',
      'placeholder' => 'Seleziona la dimensione',
      'tooltip' => 'Dimensione dell\'elemento',
      'helper_text' => 'Dimensione fisica dell\'azione nell\'interfaccia utente',
      'help' => 'Seleziona la dimensione appropriata per l\'azione',
      'description' => 'size',
    ),
    'alignment' => 
    array (
      'label' => 'Allineamento',
      'placeholder' => 'Seleziona l\'allineamento',
      'tooltip' => 'Allineamento dell\'azione',
      'helper_text' => 'Posizionamento dell\'azione rispetto agli altri elementi',
      'help' => 'Scegli l\'allineamento più appropriato nell\'interfaccia',
      'description' => 'alignment',
    ),
    'gap' => 
    array (
      'label' => 'Spaziatura',
      'placeholder' => 'Inserisci la spaziatura',
      'tooltip' => 'Spazio tra gli elementi',
      'helper_text' => 'Distanza tra l\'azione e gli elementi circostanti',
      'help' => 'Imposta la spaziatura adeguata per una buona leggibilità',
      'description' => 'gap',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Azione',
      'icon' => 'heroicon-o-plus',
      'color' => 'primary',
      'tooltip' => 'Crea una nuova azione CMS',
      'modal' => 
      array (
        'heading' => 'Crea Nuova Azione',
        'description' => 'Configura una nuova azione per il CMS',
        'confirm' => 'Crea Azione',
        'cancel' => 'Annulla',
      ),
      'messages' => 
      array (
        'success' => 'Azione creata con successo',
        'error' => 'Errore durante la creazione dell\'azione',
      ),
    ),
    'edit' => 
    array (
      'label' => 'Modifica Azione',
      'icon' => 'heroicon-o-pencil',
      'color' => 'warning',
      'tooltip' => 'Modifica l\'azione selezionata',
      'modal' => 
      array (
        'heading' => 'Modifica Azione',
        'description' => 'Aggiorna le impostazioni dell\'azione',
        'confirm' => 'Salva modifiche',
        'cancel' => 'Annulla',
      ),
      'messages' => 
      array (
        'success' => 'Azione modificata con successo',
        'error' => 'Errore durante la modifica dell\'azione',
      ),
    ),
    'delete' => 
    array (
      'label' => 'Elimina Azione',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'tooltip' => 'Elimina l\'azione selezionata',
      'modal' => 
      array (
        'heading' => 'Elimina Azione',
        'description' => 'Sei sicuro di voler eliminare questa azione? Questa operazione è irreversibile.',
        'confirm' => 'Elimina',
        'cancel' => 'Annulla',
      ),
      'messages' => 
      array (
        'success' => 'Azione eliminata con successo',
        'error' => 'Errore durante l\'eliminazione dell\'azione',
      ),
    ),
    'preview' => 
    array (
      'label' => 'Anteprima',
      'icon' => 'heroicon-o-eye',
      'color' => 'secondary',
      'tooltip' => 'Visualizza anteprima dell\'azione',
    ),
  ),
  'sections' => 
  array (
    'basic_info' => 
    array (
      'label' => 'Informazioni Base',
      'description' => 'Configurazione base dell\'azione',
      'icon' => 'heroicon-o-information-circle',
    ),
    'appearance' => 
    array (
      'label' => 'Aspetto',
      'description' => 'Stile e aspetto visivo',
      'icon' => 'heroicon-o-paint-brush',
    ),
    'behavior' => 
    array (
      'label' => 'Comportamento',
      'description' => 'Configurazione del comportamento',
      'icon' => 'heroicon-o-cog',
    ),
  ),
  'filters' => 
  array (
    'style' => 
    array (
      'label' => 'Stile',
      'placeholder' => 'Filtra per stile',
    ),
    'size' => 
    array (
      'label' => 'Dimensione',
      'placeholder' => 'Filtra per dimensione',
    ),
    'alignment' => 
    array (
      'label' => 'Allineamento',
      'placeholder' => 'Filtra per allineamento',
    ),
  ),
  'messages' => 
  array (
    'empty_state' => 'Nessuna azione configurata',
    'search_placeholder' => 'Cerca azioni...',
    'loading' => 'Caricamento azioni in corso...',
    'total_count' => 'Totale azioni: :count',
    'created' => 'Azione creata con successo',
    'updated' => 'Azione aggiornata con successo',
    'deleted' => 'Azione eliminata con successo',
    'error_general' => 'Si è verificato un errore. Riprova più tardi.',
    'error_validation' => 'Si sono verificati errori di validazione.',
    'error_permission' => 'Non hai i permessi per eseguire questa azione.',
    'success_operation' => 'Operazione completata con successo',
  ),
  'validation' => 
  array (
    'label_required' => 'L\'etichetta è obbligatoria',
    'url_format' => 'L\'URL deve essere in formato valido',
    'style_required' => 'Lo stile è obbligatorio',
    'icon_required' => 'L\'icona è obbligatoria',
  ),
  'options' => 
  array (
    'styles' => 
    array (
      'primary' => 'Primario',
      'secondary' => 'Secondario',
      'success' => 'Successo',
      'danger' => 'Pericolo',
      'warning' => 'Avvertimento',
      'info' => 'Informazione',
    ),
    'sizes' => 
    array (
      'small' => 'Piccolo',
      'medium' => 'Medio',
      'large' => 'Grande',
    ),
    'alignments' => 
    array (
      'left' => 'Sinistra',
      'center' => 'Centro',
      'right' => 'Destra',
    ),
  ),
  'label' => 'Actions',
  'plural_label' => 'Actions (Plurale)',
);
