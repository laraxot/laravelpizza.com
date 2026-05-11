---
title: PSR-4 / namespace collision - CoordinatePicker (Geo)
type: concept
updated: 2026-04-23
tags: [phpstan, psr-4, autoload, geo, filament, forms, best-practices, false-friends]
---

# Sintomo

- `composer dump-autoload` segnala: "Class ... does not comply with psr-4 autoloading standard"
- A runtime: class/trait not found o risoluzione errata.

Caso tipico:

- Esistono file con lo stesso nome in percorsi diversi (es. `app/Filament/...` e `app/Forms/...`)
- Namespace non coerente con `composer.json` (`Modules\\Geo\\ => app/`)

# Best practices

- Se un file vive in `laravel/Modules/Geo/app/Forms/...` allora il namespace deve essere:
  - `Modules\\Geo\\Forms\\...` (non `Modules\\Geo\\Filament\\...`)
- Evitare duplicazioni concettuali: un solo "CoordinatePicker" autorevole per Filament (preferibilmente quello che estende `XotBaseField`).
- Usare `composer dump-autoload` dopo rinomini/spostamenti per validare PSR-4 e scovare classi "skipped".

# Bad practices

- Lasciare namespace vecchi dopo uno spostamento file.
- Avere due componenti con lo stesso nome classe ma responsabilita' sovrapposte.

# False friends

- "Se Laravel lo trova via container allora autoload e' ok": no, PSR-4 e composer sono la fonte di verita' per le classi.
- "E' solo warning": i warning PSR-4 spesso anticipano fatal `Class ... not found`.

