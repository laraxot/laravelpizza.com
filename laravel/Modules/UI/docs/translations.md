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
