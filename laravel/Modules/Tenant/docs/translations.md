# Traduzioni del Modulo Tenant

## Collegamenti

- [Modulo Lang](../../Lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../Xot/docs/translations.md)

## Struttura

```
Modules/Tenant/
└── lang/
    ├── it/
    │   └── tenant.php
    └── en/
        └── tenant.php
```

## Contenuto

Il file `tenant.php` contiene le traduzioni per:
- Gestione tenant
- Configurazione tenant
- Domini
- Database
- Permessi tenant
- Migrazione dati
- Backup tenant
- Restore tenant
- Statistiche tenant
- Log tenant

## Esempi

```php
return [
    'management' => [
        'label' => 'Gestione Tenant',
        'tooltip' => 'Gestisci i tenant del sistema'
    ],
    'configuration' => [
        'label' => 'Configurazione',
        'tooltip' => 'Configura le impostazioni del tenant'
    ],
    'domains' => [
        'label' => 'Domini',
        'tooltip' => 'Gestisci i domini del tenant'
    ],
    'backup' => [
        'label' => 'Backup',
        'tooltip' => 'Esegui il backup del tenant'
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

