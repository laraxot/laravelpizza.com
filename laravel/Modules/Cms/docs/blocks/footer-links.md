---
title: "footer links"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "footer links"
issues: []
discussions: []
---

# Footer Links Block

## Type
`footer.links`

## Classe
`Modules\Cms\Filament\Blocks\LinksBlock`

## Descrizione
Gestisce i link di navigazione nel footer. I campi disponibili sono:
- `title`
- `links` (ripetitore con campi `label`, `url`, `icon`)

## Label Translation
Non usare `->label()` nei componenti. Le etichette vengono risolte automaticamente tramite le chiavi di traduzione in `Modules/Cms/lang/{locale}/filament.php`.
I file di traduzione contengono:
```php
// Modules/Cms/lang/it/filament.php
return [
    'cms' => [
        'filament' => [
            'blocks' => [
                'footer' => [
                    'links' => [
                        'fields' => [
                            'title' => ['label' => 'Titolo'],
                            'links' => [
                                'fields' => [
                                    'label' => ['label' => 'Etichetta'],
                                    'url' => ['label' => 'URL'],
                                    'icon' => ['label' => 'Icona'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
```

## Namespace Corretta
Anche se il file risiede in `app/Filament/Blocks`, il namespace è `Modules\Cms\Filament\Blocks`.

## Collegamenti
- [Linee guida Etichette Filament](/docs/filament-block-labels.md)
- [Linee guida generali Filament Blocks (Xot)](../../Xot/docs/DOCUMENTATION-GUIDELINES.md#filament-blocks)
- [Linee guida Etichette Filament (root)](/docs/filament-block-labels.md)
