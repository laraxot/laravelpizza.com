<?php

declare(strict_types=1);

return [
    'resources' => [
        'section' => [
            'label' => 'Sezione',
            'plural' => 'Sezioni',
            'navigation' => [
                'label' => 'Sezioni',
                'icon' => 'heroicon-o-rectangle-stack',
            ],
        ],
    ],
    'blocks' => [
        'footer' => [
            'label' => 'Footer',
            'info' => [
                'label' => 'Info Footer',
                'fields' => [
                    'logo' => 'Logo Footer',
                    'company_name' => 'Nome Azienda',
                    'description' => 'Descrizione',
                    'email' => 'Email',
                    'phone' => 'Telefono',
                    'address' => 'Indirizzo',
                ],
            ],
            'links' => [
                'label' => 'Link Footer',
                'fields' => [
                    'title' => 'Titolo Sezione',
                    'links' => [
                        'label' => 'Link',
                        'fields' => [
                            'label' => 'Etichetta Link',
                            'url' => 'URL',
                            'icon' => 'Icona (opzionale)',
                        ],
                    ],
                ],
            ],
            'social' => [
                'label' => 'Social Footer',
                'fields' => [
                    'title' => 'Titolo Sezione',
                    'social_links' => 'Link Social',
                    'platform' => 'Piattaforma Social',
                    'url' => 'URL Profilo',
                ],
            ],
            'contact' => [
                'label' => 'Contatti Footer',
                'fields' => [
                    'title' => 'Titolo Sezione',
                    'address' => 'Indirizzo',
                    'phone' => 'Telefono',
                    'email' => 'Email',
                ],
            ],
            'newsletter' => [
                'label' => 'Newsletter Footer',
                'fields' => [
                    'title' => 'Titolo Sezione',
                    'description' => 'Descrizione',
                    'button_text' => 'Testo Pulsante',
                ],
            ],
            'quick_links' => [
                'label' => 'Link Rapidi Footer',
                'fields' => [
                    'title' => 'Titolo',
                    'links' => [
                        'label' => 'Link Rapidi',
                        'fields' => [
                            'label' => 'Etichetta',
                            'url' => 'URL',
                            'target' => 'Target',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
