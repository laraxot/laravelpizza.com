---
title: "no app/Services — business logic in QueueableAction"
type: concept
tags: [seo, actions, queueable-action, support, refactor, metatag]
created: 2026-07-12
updated: 2026-07-13
qmd: "Seo module no app Support MetatagService QueueableAction facade"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/372"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
related:
  - metatag-data-contract.md
  - ../../../../../../docs/wiki/rules/queueable-action-trait-mandatory.md
status: active
---

# no `app/Support/` — business logic in QueueableAction

## Scopo

Nel modulo Seo **non** esiste più `app/Services/MetatagService`. Stato request-scoped + mutazioni sono Actions; il facade mantiene l'API legacy.

## Migrazione (2026-07-12)

| Legacy | Destinazione |
|--------|--------------|
| `MetatagService` | archiviato come `.bak`; nessun PHP attivo in `app/Services` |
| stato accumulatore | `Adapters/MetatagState` (singleton) |
| API facade multi-setter | `Adapters/MetatagFacadeAdapter` |
| `get()` | `Actions/Metatag/GetMetatagDataAction` |
| `set()` | `Actions/Metatag/ReplaceMetatagDataAction` |
| `setTitle()`, `setDescription()`, … | `Actions/Metatag/MergeMetatagDataAction` |

## Perché lo split

`MetatagService` era uno stato mutabile request-scoped dietro il facade `Metatag::`. Le mutazioni sono ora QueueableAction; l'adapter delega senza duplicare logica merge.

## Collegamenti

- [metatag-data-contract.md](metatag-data-contract.md)
- [queueable-action-trait-mandatory](../../../../../../docs/wiki/rules/queueable-action-trait-mandatory.md)
