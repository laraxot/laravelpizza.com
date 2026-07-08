---
title: "HasMedia Form & Table Duplication Pattern"
type: concept
tags: [redundancy, media, filament, duplication, 2026-05]
created: 2026-05-21
---

# HasMedia Form & Table Duplication Pattern

## Problema

Molti moduli (Cms, User, Tenant, Geo, Notify, Rating, Blog, Fixcity, ecc.) implementano la propria logica di upload media (form fields, tabelle, relation manager, azioni) invece di riutilizzare il componente centralizzato del modulo **Media**.

Questo porta a:
- Codice duplicato
- Divergenza di comportamento tra moduli
- Difficoltà nel mantenere feature come versioning, conversioni, collections, permissions

## Esempio di duplicazione tipica

```php
// In tanti moduli si ritrova codice simile
Section::make('Media')
    ->schema([
        FileUpload::make('media')
            ->multiple()
            ->image()
            ->disk('public')
            ->directory('media')
            ...
    ])
```

Invece di usare:

```php
// Dal modulo Media
MediaRelationManager::make()
```

o lo schema riutilizzabile `HasMediaForm::getFormSchema()`.

## Dove documentare / pulire

- Ogni modulo che ha la duplicazione deve avere un proprio report in `docs/wiki/redundancy/`
- Il modulo **Media** è l'owner canonico del pattern e deve guidare il refactoring

## Prossimi passi raccomandati

1. Creare un componente riutilizzabile `HasMediaSchema` nel modulo Media
2. Sostituire progressivamente le implementazioni duplicate nei vari moduli
3. Aggiornare la documentazione in ogni modulo interessato

## Riferimenti

- Issue tracker: [#90](https://github.com/laraxot/base_fixcity_fila5/issues/90)
- Modulo owner: `laravel/Modules/Media`
- Componenti canonici: `HasMediaResource`, `HasMediaForm`, `HasMediasTable`, `MediaRelationManager`
