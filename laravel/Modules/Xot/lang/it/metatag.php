<?php

declare(strict_types=1);

return [
    'resources' => 'Risorse',
    'pages' => 'Pagine',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'metatag',
        'plural' => 'metatags',
        'group' => [
            'name' => 'Admin',
        ],
    ],
    'fields' => [
        'name' => 'Nome',
        'title' => ['label' => 'Titolo', 'placeholder' => 'Titolo'],
        'description' => ['label' => 'Descrizione', 'placeholder' => 'Descrizione'],
        'url' => ['label' => 'URL', 'placeholder' => 'URL'],
        'icon' => ['label' => 'Icona', 'placeholder' => 'Icona'],
        'position' => ['label' => 'Posizione', 'placeholder' => 'Posizione'],
        'is_visible' => ['label' => 'Visibile', 'help' => 'Se selezionato, la pagina sarà visibile nella navigazione'],
        'is_active' => ['label' => 'Attivo', 'help' => 'Se selezionato, la pagina sarà attiva'],
        'is_home' => ['label' => 'Home', 'help' => 'Se selezionato, la pagina sarà la home'],
        'is_menu' => ['label' => 'Menu', 'help' => 'Se selezionato, la pagina sarà nel menu'],
        'is_footer' => ['label' => 'Footer', 'help' => 'Se selezionato, la pagina sarà nel footer'],
        'is_header' => ['label' => 'Header', 'help' => 'Se selezionato, la pagina sarà nel header'],
        'is_sidebar' => ['label' => 'Sidebar', 'help' => 'Se selezionato, la pagina sarà nella sidebar'],
        'is_sidebar_left' => ['label' => 'Sidebar Left', 'help' => 'Se selezionato, la pagina sarà nella sidebar left'],
        'is_sidebar_right' => ['label' => 'Sidebar Right', 'help' => 'Se selezionato, la pagina sarà nella sidebar right'],
        'sitename' => ['label' => 'Nome sito', 'placeholder' => 'Nome sito'],
        'subtitle' => ['label' => 'Sottotitolo', 'placeholder' => 'Sottotitolo'],
        'keywords' => ['label' => 'Parole chiave', 'placeholder' => 'Parole chiave'],
        'generator' => ['label' => 'Generatore', 'placeholder' => 'Generatore'],
        'charset' => ['label' => 'Charset', 'placeholder' => 'Charset'],
        'author' => ['label' => 'Autore', 'placeholder' => 'Autore'],
        'copyright' => ['label' => 'Copyright', 'placeholder' => 'Copyright'],
        'robots' => ['label' => 'Robots', 'placeholder' => 'Robots'],
        'logo_header' => ['label' => 'Logo Header', 'placeholder' => 'Logo Header'],
        'logo_header_dark' => ['label' => 'Logo Header Dark', 'placeholder' => 'Logo Header Dark'],
        'logo_height' => ['label' => 'Altezza Logo Header', 'placeholder' => 'Altezza Logo Header'],
        'colors' => ['label' => 'Colori', 'placeholder' => 'Colori'],
        'logo_footer' => ['label' => 'Logo Footer', 'placeholder' => 'Logo Footer'],
        'favicon' => ['label' => 'Favicon', 'placeholder' => 'Favicon'],
        'key' => ['label' => 'color key'],
        'color' => ['label' => 'color'],
        'hex' => ['label' => 'hex'],
        'timezone' => ['label' => 'Fuso orario', 'placeholder' => 'Fuso orario'],
        'locale' => ['label' => 'Lingua', 'placeholder' => 'Lingua'],
        'contact_email' => ['label' => 'Email contatto', 'placeholder' => 'Email contatto'],
        'contact_phone' => ['label' => 'Telefono contatto', 'placeholder' => 'Telefono contatto'],
        'contact_address' => ['label' => 'Indirizzo contatto', 'placeholder' => 'Indirizzo contatto'],
        'guard_name' => 'Guard',
        'permissions' => 'Permessi',
        'updated_at' => 'Aggiornato il',
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'select_all' => [
            'name' => 'Seleziona Tutti',
            'message' => '',
        ],
    ],
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => 'Seleziona un file XLS o CSV da caricare',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => 'Nome area',
                'parent_name' => 'Nome area livello superiore',
            ],
        ],
    ],
];
