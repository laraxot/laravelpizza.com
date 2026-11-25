<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Meta Tag',
        'plural' => 'Meta Tags',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Site meta tag and SEO management',
        ],
        'label' => 'Metatag',
        'sort' => '16',
        'icon' => 'xot-metatag',
    ],
    'fields' => [
        'basic' => [
            'title' => [
                'label' => 'Title',
                'placeholder' => 'Enter the page title',
                'help' => 'Meta title - massimo 60 caratteri',
            ],
            'description' => [
                'label' => 'Description',
                'placeholder' => 'Enter the page description',
                'help' => 'Meta description - massimo 160 caratteri',
            ],
            'keywords' => [
                'label' => 'Parole chiave',
                'placeholder' => 'Enter keywords separated by commas',
                'help' => 'Meta keywords - massimo 10 parole chiave',
            ],
            'robots' => [
                'label' => 'Robots',
                'help' => 'Instructions for search engines',
                'options' => [
                    'index,follow' => 'Index and follow links',
                    'noindex,follow' => 'Do not index but follow links',
                    'index,nofollow' => 'Index but do not follow links',
                    'noindex,nofollow' => 'Do not index and do not follow links',
                ],
            ],
            'canonical' => [
                'label' => 'URL Canonico',
                'placeholder' => 'Enter the canonical URL',
                'help' => 'Canonical URL to avoid duplicate content',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
        ],
        'social' => [
            'og_title' => [
                'label' => 'Open Graph Title',
                'placeholder' => 'Enter the title for social media',
                'help' => 'Title optimized for social sharing',
            ],
            'og_description' => [
                'label' => 'Open Graph Description',
                'placeholder' => 'Enter the description for social media',
                'help' => 'Description optimized for social sharing',
            ],
            'og_image' => [
                'label' => 'Immagine Open Graph',
                'placeholder' => 'Select the image for social media',
                'help' => 'Image optimized for sharing (1200x630px)',
            ],
            'twitter_card' => [
                'label' => 'Twitter Card',
                'help' => 'Card type for sharing on Twitter',
                'options' => [
                    'summary' => 'Card riassuntiva',
                    'summary_large_image' => 'Card with large image',
                    'app' => 'App card',
                    'player' => 'Media card',
                ],
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'site' => [
            'sitename' => [
                'label' => 'Site Name',
                'placeholder' => 'Enter the site name',
                'help' => 'Main name of the website',
            ],
            'subtitle' => [
                'label' => 'Sottotitolo',
                'placeholder' => 'Enter the site subtitle',
                'help' => 'Short description of the site',
            ],
            'author' => [
                'label' => 'Autore',
                'placeholder' => 'Enter the site author',
                'help' => 'Author or organization name',
            ],
            'copyright' => [
                'label' => 'Copyright',
                'placeholder' => 'Enter the copyright',
                'help' => 'Site copyright information',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'appearance' => [
            'logo_header' => [
                'label' => 'Logo Header',
                'help' => 'Main site logo (SVG or PNG)',
            ],
            'logo_header_dark' => [
                'label' => 'Logo Header Scuro',
                'help' => 'Dark version of the logo for the dark theme',
            ],
            'logo_footer' => [
                'label' => 'Logo Footer',
                'help' => 'Logo for the site footer',
            ],
            'favicon' => [
                'label' => 'Favicon',
                'help' => 'Site icon (32x32px)',
            ],
            'colors' => [
                'label' => 'Colori',
                'help' => 'Site color scheme',
                'key' => [
                    'label' => 'Chiave',
                    'help' => 'Color identifier',
                ],
                'hex' => [
                    'label' => 'Codice HEX',
                    'help' => 'Codice colore esadecimale',
                ],
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'contact' => [
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Enter the contact email',
                'help' => 'Main contact email',
            ],
            'phone' => [
                'label' => 'Telefono',
                'placeholder' => 'Enter the contact phone',
                'help' => 'Main phone number',
            ],
            'address' => [
                'label' => 'Indirizzo',
                'placeholder' => 'Enter the address',
                'help' => 'Physical address of the business',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'New Meta Tag',
            'success' => 'Meta tag created successfully',
            'error' => 'Error while creating the meta tag',
        ],
        'edit' => [
            'label' => 'Edit',
            'success' => 'Meta tag updated successfully',
            'error' => 'Error while updating the meta tag',
        ],
        'delete' => [
            'label' => 'Delete',
            'success' => 'Meta tag deleted successfully',
            'error' => 'Error while deleting the meta tag',
        ],
        'preview' => [
            'label' => 'Anteprima',
            'success' => 'Preview generated successfully',
            'error' => 'Error while generating the preview',
        ],
        'validate' => [
            'label' => 'Valida',
            'success' => 'Meta tags validated successfully',
            'error' => 'Error while validating the meta tags',
        ],
    ],
    'messages' => [
        'validation' => [
            'title' => [
                'required' => 'The title is required',
                'max' => 'The title may not exceed :max characters',
                'unique' => 'This title is already in use',
            ],
            'description' => [
                'required' => 'The description is required',
                'max' => 'The description may not exceed :max characters',
                'min' => 'The description must be at least :min characters',
            ],
            'keywords' => [
                'max' => 'Keywords may not exceed :max characters',
                'regex' => 'Keywords must be separated by commas',
            ],
            'canonical' => [
                'url' => 'The canonical URL must be a valid URL',
                'unique' => 'This canonical URL is already in use',
            ],
            'og_image' => [
                'image' => 'The file must be an image',
                'dimensions' => 'The image must be :width x :height pixels',
                'max' => 'The image may not exceed :max KB',
            ],
        ],
        'warnings' => [
            'missing_description' => 'Meta description mancante',
            'duplicate_title' => 'Meta title duplicato',
            'invalid_canonical' => 'Invalid canonical URL',
            'oversized_image' => 'Immagine social troppo grande',
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
