<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Impostazioni',
        'group' => 'Configurazione',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 99,
    ],
    'title' => 'Impostazioni',
    'fields' => [
        'path_aliases' => [
            'label' => 'Pagine doppie (alias)',
            'placeholder' => '',
            'helper_text' => 'Una riga per ogni pagina scritta con due nomi: l\'alias risponde con un reindirizzamento 301 alla pagina finale, nella stessa lingua, e non compare nella sitemap. Togliere la riga ripristina la pagina.',
            'tooltip' => '',
            'description' => '',
        ],
        'alias' => [
            'label' => 'Alias',
            'placeholder' => 'faqs',
            'helper_text' => 'Percorso senza lingua della pagina da ritirare (es. faqs).',
            'tooltip' => '',
            'description' => '',
        ],
        'target' => [
            'label' => 'Pagina finale',
            'placeholder' => 'faq',
            'helper_text' => 'Percorso senza lingua della pagina da tenere. Vuoto = home. Mai un altro alias.',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'errors' => [
        'path_aliases' => 'Alcune righe non sono valide: l\'alias e\' vuoto, e\' ripetuto, punta a se stesso o a un altro alias. Ogni alias deve puntare a una pagina finale.',
    ],
    'actions' => [
        'save' => [
            'label' => 'Salva',
            'icon' => 'heroicon-o-check',
            'tooltip' => 'Salva',
        ],
        'profile' => [
            'label' => 'Profilo',
            'icon' => 'heroicon-o-user-circle',
            'tooltip' => 'Profilo',
        ],
        'logout' => [
            'label' => 'Esci',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'tooltip' => 'Esci',
        ],
    ],
];
