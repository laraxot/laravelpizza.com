<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'Sistema',
        'label' => 'Tema Notifica',
        'icon' => 'notify-theme-animated',
        'sort' => 50,
        'description' => 'Gestione del tema per le notifiche',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome del tema',
            'placeholder' => 'es: Tema Aziendale',
            'help' => 'Inserisci un nome descrittivo per il tema',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'tooltip' => 'Descrizione del tema',
            'placeholder' => 'es: Tema standard per le comunicazioni aziendali',
            'help' => 'Breve descrizione dello scopo del tema',
            'helper_text' => '',
            'description' => '',
        ],
        'colors' => [
            'label' => 'Colori',
            'tooltip' => 'Schema colori del tema',
            'help' => 'Definisci i colori principali del tema',
            'options' => [
                'primary' => [
                    'label' => 'Primario',
                    'tooltip' => 'Colore principale del tema',
                    'placeholder' => 'es: #4A90E2',
                ],
                'secondary' => [
                    'label' => 'Secondario',
                    'tooltip' => 'Colore secondario del tema',
                    'placeholder' => 'es: #5C6AC4',
                ],
                'accent' => [
                    'label' => 'Accento',
                    'tooltip' => 'Colore di accento per elementi in evidenza',
                    'placeholder' => 'es: #F5A623',
                ],
            ],
            'helper_text' => '',
            'description' => '',
        ],
        'typography' => [
            'label' => 'Tipografia',
            'tooltip' => 'Impostazioni tipografiche',
            'help' => 'Configura i font e le dimensioni del testo',
            'options' => [
                'font_family' => [
                    'label' => 'Font principale',
                    'tooltip' => 'Font utilizzato per il testo principale',
                    'placeholder' => 'es: Arial, sans-serif',
                ],
                'heading_font' => [
                    'label' => 'Font titoli',
                    'tooltip' => 'Font utilizzato per i titoli',
                    'placeholder' => 'es: Helvetica, Arial, sans-serif',
                ],
            ],
            'helper_text' => '',
            'description' => '',
        ],
        'layout' => [
            'label' => 'Layout',
            'tooltip' => 'Impostazioni del layout',
            'help' => 'Configura la struttura del template',
            'options' => [
                'header' => [
                    'label' => 'Intestazione',
                    'tooltip' => 'Stile dell\'intestazione',
                ],
                'footer' => [
                    'label' => 'Piè di pagina',
                    'tooltip' => 'Stile del piè di pagina',
                ],
            ],
            'helper_text' => '',
            'description' => '',
        ],
        'assets' => [
            'label' => 'Risorse',
            'tooltip' => 'Risorse del tema',
            'help' => 'Gestisci le risorse associate al tema',
            'options' => [
                'logo' => [
                    'label' => 'Logo',
                    'tooltip' => 'Logo da utilizzare nelle notifiche',
                ],
                'background' => [
                    'label' => 'Sfondo',
                    'tooltip' => 'Immagine di sfondo',
                ],
            ],
            'helper_text' => '',
            'description' => '',
        ],
        'is_default' => [
            'label' => 'Predefinito',
            'tooltip' => 'Imposta come tema predefinito',
            'help' => 'Il tema predefinito verrà utilizzato per tutte le notifiche senza tema specifico',
            'helper_text' => '',
            'description' => '',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'tooltip' => 'Stato di attivazione del tema',
            'help' => 'Solo i temi attivi possono essere utilizzati',
            'helper_text' => '',
            'description' => '',
        ],
        'lang' => [
            'label' => 'lang',
            'placeholder' => 'lang',
            'helper_text' => 'lang',
            'description' => 'lang',
        ],
        'type' => [
            'label' => 'type',
            'placeholder' => 'type',
            'helper_text' => 'type',
            'description' => 'type',
        ],
        'post_type' => [
            'label' => 'post_type',
            'placeholder' => 'post_type',
            'helper_text' => 'post_type',
            'description' => 'post_type',
        ],
        'post_id' => [
            'label' => 'post_id',
            'placeholder' => 'post_id',
            'helper_text' => 'post_id',
            'description' => 'post_id',
        ],
        'subject' => [
            'label' => 'subject',
            'placeholder' => 'subject',
            'helper_text' => 'subject',
            'description' => 'subject',
        ],
        'from' => [
            'label' => 'from',
            'placeholder' => 'from',
            'helper_text' => 'from',
            'description' => 'from',
        ],
        'from_email' => [
            'label' => 'from_email',
            'placeholder' => 'from_email',
            'helper_text' => 'from_email',
            'description' => 'from_email',
        ],
        'logo_src' => [
            'label' => 'logo_src',
            'placeholder' => 'logo_src',
            'helper_text' => 'logo_src',
            'description' => 'logo_src',
        ],
        'logo_width' => [
            'label' => 'logo_width',
            'placeholder' => 'logo_width',
            'helper_text' => 'logo_width',
            'description' => 'logo_width',
        ],
        'logo_height' => [
            'label' => 'logo_height',
            'placeholder' => 'logo_height',
            'helper_text' => 'logo_height',
            'description' => 'logo_height',
        ],
        'theme' => [
            'label' => 'theme',
            'placeholder' => 'theme',
            'helper_text' => 'theme',
            'description' => 'theme',
        ],
        'body' => [
            'label' => 'body',
            'placeholder' => 'body',
            'helper_text' => 'body',
            'description' => 'body',
        ],
        'body_html' => [
            'label' => 'body_html',
            'placeholder' => 'body_html',
            'helper_text' => 'body_html',
            'description' => 'body_html',
        ],
        'id' => [
            'label' => 'id',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
    ],
    'actions' => [
        'preview' => [
            'label' => 'Anteprima',
            'tooltip' => 'Visualizza anteprima del tema',
            'icon' => 'heroicon-o-eye',
            'color' => 'primary',
        ],
        'duplicate' => [
            'label' => 'Duplica',
            'tooltip' => 'Crea una copia del tema',
            'icon' => 'heroicon-o-document-duplicate',
            'color' => 'info',
            'confirmation' => [
                'title' => 'Conferma duplicazione',
                'message' => 'Vuoi creare una copia di questo tema?',
                'confirm' => 'Sì, duplica',
                'cancel' => 'No, annulla',
            ],
        ],
        'set_default' => [
            'label' => 'Imposta predefinito',
            'tooltip' => 'Imposta questo tema come predefinito',
            'icon' => 'heroicon-o-star',
            'color' => 'primary',
            'confirmation' => [
                'title' => 'Conferma impostazione predefinito',
                'message' => 'Vuoi impostare questo tema come predefinito?',
                'confirm' => 'Sì, imposta',
                'cancel' => 'No, annulla',
            ],
        ],
        'delete' => [
            'tooltip' => 'delete',
        ],
    ],
    'messages' => [
        'created' => [
            'title' => 'Tema Creato',
            'message' => 'Il tema è stato creato con successo',
        ],
        'updated' => [
            'title' => 'Tema Aggiornato',
            'message' => 'Il tema è stato aggiornato con successo',
        ],
        'deleted' => [
            'title' => 'Tema Eliminato',
            'message' => 'Il tema è stato eliminato con successo',
        ],
        'duplicated' => [
            'title' => 'Tema Duplicato',
            'message' => 'Il tema è stato duplicato con successo',
        ],
        'preview' => [
            'title' => 'Anteprima Tema',
            'message' => 'Questa è un\'anteprima di come apparirà il tema',
        ],
        'set_default' => [
            'title' => 'Tema Predefinito',
            'message' => 'Il tema è stato impostato come predefinito',
        ],
    ],
    'model' => [
        'label' => 'Tema Notifica',
    ],
    'label' => 'Notify Theme',
    'plural_label' => 'Notify Theme (Plurale)',
];
