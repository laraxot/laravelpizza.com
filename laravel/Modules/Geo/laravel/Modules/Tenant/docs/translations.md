# Traduzioni del Modulo Tenant

## Collegamenti

- [Modulo Lang](../../lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../xot/docs/translations.md)

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
