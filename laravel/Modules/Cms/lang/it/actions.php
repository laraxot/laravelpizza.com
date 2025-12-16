<?php

declare(strict_types=1);

return [
    // NAVIGATION & STRUCTURE
    'navigation' => [
        'label' => 'Azioni CMS',
        'plural_label' => 'Azioni CMS',
        'group' => 'Sistema CMS',
        'icon' => 'heroicon-o-cursor-arrow-ripple',
        'sort' => 120,
        'badge' => 'Gestione azioni CMS',
    ],
    // MODEL INFORMATION
    'model' => [
        'label' => 'Azione CMS',
        'plural' => 'Azioni CMS',
        'description' => 'Sistema di azioni e controlli per il Content Management System',
    ],
    // FIELDS - STRUTTURA ESPANSA OBBLIGATORIA
    'fields' => [
        'items' => [
            'label' => 'Elementi',
            'placeholder' => 'Seleziona o aggiungi elementi',
            'tooltip' => 'Elementi dell\'azione',
            'helper_text' => 'Lista degli elementi che compongono l\'azione',
            'help' => 'Seleziona gli elementi che faranno parte di questa azione',
        ],
        'label' => [
            'label' => 'Etichetta',
            'placeholder' => 'Inserisci l\'etichetta',
            'tooltip' => 'Etichetta dell\'azione',
            'helper_text' => 'Testo che viene visualizzato per identificare l\'azione',
            'help' => 'Inserisci un\'etichetta descrittiva per l\'azione',
        ],
        'url' => [
            'label' => 'URL',
            'placeholder' => 'Inserisci l\'URL',
            'tooltip' => 'URL di destinazione',
            'helper_text' => 'Indirizzo web a cui l\'azione reindirizzerà l\'utente',
            'help' => 'Inserisci l\'URL completo di destinazione',
        ],
        'style' => [
            'label' => 'Stile',
            'placeholder' => 'Seleziona lo stile',
            'tooltip' => 'Stile visivo dell\'azione',
            'helper_text' => 'Aspetto visivo e styling applicato all\'azione',
            'help' => 'Scegli lo stile più appropriato per l\'azione',
        ],
        'icon' => [
            'label' => 'Icona',
            'placeholder' => 'Seleziona un\'icona',
            'tooltip' => 'Icona dell\'azione',
            'helper_text' => 'Icona grafica che rappresenta l\'azione nell\'interfaccia',
            'help' => 'Scegli un\'icona che rappresenti chiaramente l\'azione',
        ],
        'size' => [
            'label' => 'Dimensione',
            'placeholder' => 'Seleziona la dimensione',
            'tooltip' => 'Dimensione dell\'elemento',
            'helper_text' => 'Dimensione fisica dell\'azione nell\'interfaccia utente',
            'help' => 'Seleziona la dimensione appropriata per l\'azione',
        ],
        'alignment' => [
            'label' => 'Allineamento',
            'placeholder' => 'Seleziona l\'allineamento',
            'tooltip' => 'Allineamento dell\'azione',
            'helper_text' => 'Posizionamento dell\'azione rispetto agli altri elementi',
            'help' => 'Scegli l\'allineamento più appropriato nell\'interfaccia',
        ],
        'gap' => [
            'label' => 'Spaziatura',
            'placeholder' => 'Inserisci la spaziatura',
            'tooltip' => 'Spazio tra gli elementi',
            'helper_text' => 'Distanza tra l\'azione e gli elementi circostanti',
            'help' => 'Imposta la spaziatura adeguata per una buona leggibilità',
        ],
    ],
    // ACTIONS - STRUTTURA ESPANSA OBBLIGATORIA
    'actions' => [
        'create' => [
            'label' => 'Crea Azione',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Crea una nuova azione CMS',
            'modal' => [
                'heading' => 'Crea Nuova Azione',
                'description' => 'Configura una nuova azione per il CMS',
                'confirm' => 'Crea Azione',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Azione creata con successo',
                'error' => 'Errore durante la creazione dell\'azione',
            ],
        ],
        'edit' => [
            'label' => 'Modifica Azione',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Modifica l\'azione selezionata',
            'modal' => [
                'heading' => 'Modifica Azione',
                'description' => 'Aggiorna le impostazioni dell\'azione',
                'confirm' => 'Salva modifiche',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Azione modificata con successo',
                'error' => 'Errore durante la modifica dell\'azione',
            ],
        ],
        'delete' => [
            'label' => 'Elimina Azione',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Elimina l\'azione selezionata',
            'modal' => [
                'heading' => 'Elimina Azione',
                'description' => 'Sei sicuro di voler eliminare questa azione? Questa operazione è irreversibile.',
                'confirm' => 'Elimina',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Azione eliminata con successo',
                'error' => 'Errore durante l\'eliminazione dell\'azione',
            ],
        ],
        'preview' => [
            'label' => 'Anteprima',
            'icon' => 'heroicon-o-eye',
            'color' => 'secondary',
            'tooltip' => 'Visualizza anteprima dell\'azione',
        ],
    ],
    // SECTIONS - ORGANIZZAZIONE FORM
    'sections' => [
        'basic_info' => [
            'label' => 'Informazioni Base',
            'description' => 'Configurazione base dell\'azione',
            'icon' => 'heroicon-o-information-circle',
        ],
        'appearance' => [
            'label' => 'Aspetto',
            'description' => 'Stile e aspetto visivo',
            'icon' => 'heroicon-o-paint-brush',
        ],
        'behavior' => [
            'label' => 'Comportamento',
            'description' => 'Configurazione del comportamento',
            'icon' => 'heroicon-o-cog',
        ],
    ],
    // FILTERS - RICERCA E FILTRI
    'filters' => [
        'style' => [
            'label' => 'Stile',
            'placeholder' => 'Filtra per stile',
        ],
        'size' => [
            'label' => 'Dimensione',
            'placeholder' => 'Filtra per dimensione',
        ],
        'alignment' => [
            'label' => 'Allineamento',
            'placeholder' => 'Filtra per allineamento',
        ],
    ],
    // MESSAGES - FEEDBACK UTENTE
    'messages' => [
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
    ],
    // VALIDATION - MESSAGGI DI VALIDAZIONE
    'validation' => [
        'label_required' => 'L\'etichetta è obbligatoria',
        'url_format' => 'L\'URL deve essere in formato valido',
        'style_required' => 'Lo stile è obbligatorio',
        'icon_required' => 'L\'icona è obbligatoria',
    ],
    // OPTIONS - OPZIONI E VALORI PREDEFINITI
    'options' => [
        'styles' => [
            'primary' => 'Primario',
            'secondary' => 'Secondario',
            'success' => 'Successo',
            'danger' => 'Pericolo',
            'warning' => 'Avvertimento',
            'info' => 'Informazione',
        ],
        'sizes' => [
            'small' => 'Piccolo',
            'medium' => 'Medio',
            'large' => 'Grande',
        ],
        'alignments' => [
            'left' => 'Sinistra',
            'center' => 'Centro',
            'right' => 'Destra',
        ],
    ],
];
