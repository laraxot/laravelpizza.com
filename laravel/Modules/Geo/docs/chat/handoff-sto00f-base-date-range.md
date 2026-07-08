---
title: "Handoff — Sto00f BaseDateRangeModel"
type: chat-handoff
module: Sigma
created: 2026-06-15
related:
  - ../../laravel/Modules/Sigma/docs/wiki/concepts/sto00f-date-range.md
  - ../wiki/rules/eloquent-basemodel-hierarchy.md
---

# Sto00f → BaseDateRangeModel

## Decisione architettura

`Sto00f` **deve** estendere `BaseDateRangeModel`: triplette `st2kas` / `st2kdi` / `stann` = stesso pattern di `Qua00f`/`Rep00f`.

**No** `BaseDateRangeModelCarbon` — Carbon solo in `giorni()`/`gg()`.

## Stato

- Codice: `extends BaseDateRangeModel` + tre metodi range + scope anno
- Repo modulo: `git@github.com:laraxot/module_sigma_fila5.git`
- Issue/discussion: collegare a #3 ereditarietà modelli se aperta

## Verifica

```bash
bash bashscripts/tools/phpstan-module.sh Sigma
rg "class Sto00f extends" laravel/Modules/Sigma/app/Models/Sto00f.php
```
