# Traduzioni del Modulo UI

## Collegamenti

- [Modulo Lang](../../Lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../Xot/docs/translations.md)

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
* [translations.md](../../../Chart/docs/translations.md)
* [translations.md](../../../Reporting/docs/translations.md)
* [translations.md](../../../Gdpr/docs/translations.md)
* [translations.md](../../../Notify/docs/translations.md)
* [translations.md](../../../Xot/docs/roadmap/lang/translations.md)
* [translations.md](../../../Xot/docs/translations.md)
* [translations.md](../../../Dental/docs/translations.md)
* [translations.md](../../../User/docs/translations.md)
* [translations.md](../../../UI/docs/translations.md)
* [translations.md](../../../Lang/docs/packages/translations.md)
* [translations.md](../../../Lang/docs/translations.md)
* [translations.md](../../../Job/docs/translations.md)
* [translations.md](../../../Media/docs/translations.md)
* [translations.md](../../../Tenant/docs/translations.md)
* [translations.md](../../../Activity/docs/translations.md)
* [translations.md](../../../Patient/docs/translations.md)
* [translations.md](../../../Cms/docs/translations.md)
