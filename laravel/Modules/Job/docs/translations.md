---
title: "translations"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "translations"
issues: []
discussions: []
status: draft
---

# Traduzioni del Modulo Job

## Collegamenti

- [Modulo Lang](../../lang/docs/module_lang.md) - Documentazione principale sulle traduzioni
- [Regole Generali Traduzioni](../../xot/docs/translations.md)

## Struttura

```
Modules/Job/
└── lang/
    ├── it/
    │   └── job.php
    └── en/
        └── job.php
```

## Contenuto

Il file `job.php` contiene le traduzioni per:
- Gestione job
- Code di lavoro
- Processi in background
- Schedulazione
- Monitoraggio
- Log job
- Errori job
- Configurazione job
- Priorità
- Stati job

## Esempi

```php
return [
    'queue' => [
        'label' => 'Code di Lavoro',
        'tooltip' => 'Gestisci le code di lavoro'
    ],
    'monitoring' => [
        'label' => 'Monitoraggio',
        'tooltip' => 'Monitora lo stato dei job'
    ],
    'scheduling' => [
        'label' => 'Schedulazione',
        'tooltip' => 'Configura la schedulazione dei job'
    ],
    'errors' => [
        'label' => 'Errori',
        'tooltip' => 'Visualizza gli errori dei job'
    ]
];
### Versione HEAD

```
## Collegamenti tra versioni di translations.md
* [translations.md](../../../chart/docs/translations.md)
* [translations.md](../../../reporting/docs/translations.md)
* [translations.md](../../Gdpr/docs/translations.md)
* [translations.md](../../Notify/docs/translations.md)
* [translations.md](../../../xot/docs/roadmap/lang/translations.md)
* [translations.md](../../../xot/docs/translations.md)
* [translations.md](../../../dental/docs/translations.md)
* [translations.md](../../User/docs/translations.md)
* [translations.md](../../../ui/docs/translations.md)
* [translations.md](../../Lang/docs/packages/translations.md)
* [translations.md](../../Lang/docs/translations.md)
* [translations.md](../../../job/docs/translations.md)
* [translations.md](../../Media/docs/translations.md)
* [translations.md](../../Tenant/docs/translations.md)
* [translations.md](../../Activity/docs/translations.md)
* [translations.md](../../../patient/docs/translations.md)
* [translations.md](../../../cms/docs/translations.md)

### Versione Incoming

```

---
title: "translations"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "translations"
issues: []
discussions: []
