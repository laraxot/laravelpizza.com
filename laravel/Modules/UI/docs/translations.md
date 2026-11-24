---
title: "Traduzioni del Modulo UI"
qmd: "ui translations md"
type: note
tags: [documentation]
---

# Traduzioni del Modulo UI

## Collegamenti

- [Modulo Lang](../../lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../xot/docs/translations.md)

## Struttura

```
Modules/UI/
└── lang/
    ├── it/
    │   └── ui.php
    └── en/
        └── ui.php
```

## Contenuto

Il file `ui.php` contiene le traduzioni per:
- Componenti base
- Widget
- Layout
- Temi
- Stili
- Icone
- Messaggi di sistema
- Errori
- Avvisi

## Esempi

```php
return [
    'components' => [
        'button' => [
            'label' => 'Pulsante',
            'tooltip' => 'Clicca per eseguire un\'azione'
        ],
        'input' => [
            'label' => 'Campo di input',
            'tooltip' => 'Inserisci il testo'
        ]
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
        'warning' => 'Attenzione'
    ]
];
```
## Collegamenti tra versioni di translations.md
* [translations.md](../../../chart/docs/translations.md)
* [translations.md](../../../reporting/docs/translations.md)
* [translations.md](../../../gdpr/docs/translations.md)
* [translations.md](../../../notify/docs/translations.md)
* [translations.md](../../../xot/docs/roadmap/lang/translations.md)
* [translations.md](../../../xot/docs/translations.md)
* [translations.md](../../../dental/docs/translations.md)
* [translations.md](../../../user/docs/translations.md)
* [translations.md](../../../ui/docs/translations.md)
* [translations.md](../../../lang/docs/packages/translations.md)
* [translations.md](../../../lang/docs/translations.md)
* [translations.md](../../../job/docs/translations.md)
* [translations.md](../../../media/docs/translations.md)
* [translations.md](../../../tenant/docs/translations.md)
* [translations.md](../../../activity/docs/translations.md)
* [translations.md](../../../patient/docs/translations.md)
* [translations.md](../../../cms/docs/translations.md)

## interactive-map e metatags dopo il mirror del 2026-11-17

Il mirror del root `8a8f309737` aveva rimesso testo italiano fisso in
`resources/views/livewire/components/map/interactive-map.blade.php` al posto delle 26 chiavi
`ui::interactive_map.*` (presenti in it/en/de/es) e scritto `<meta nome="googlebot">` in
`resources/views/metatags.blade.php`. Entrambi ripristinati. Vedi la story
`Modules/Xot/docs/stories/sync-unrelated-histories-repair.story.md`.
