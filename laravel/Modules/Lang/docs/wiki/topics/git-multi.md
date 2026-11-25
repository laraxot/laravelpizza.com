---
title: "Topic git-multi"
type: digest
status: active
qmd: "digest ceiling 100 git-multi"
---

# Topic git-multi

Sintesi automatica di 3 documenti (chiave `git-multi`).

## Handoff — multi-org sync (STORY-003)

_Fonte: `git-multi-org-sync-handoff.md`_

# Handoff — multi-org sync (STORY-003)

## Scopo

Allineare questo owner ai remote raggiungibili (**0 0**, working tree clean) e documentare decisioni di sessione 2026-07-21.

## Perché

Un tree dirty o un remote dietro/avanti **non** è sincronizzato, anche se l’altro org è a posto. Su PTVX i path vivono in `gitmodules.ini` con org `provtv` (+ `laraxot` se esiste).

## Link

| Tipo | URL |
|------|-----|
| Issue owner | https://github.com/provtv/module_lang_fila5/issues/16 |
| Discussion | https://github.com/provtv/base_ptv_fila5/discussions/204 |
| Hub base issue | https://github.com/provtv/base_ptv_fila5/issues/203 |
| Hub base discussion | https://github.com/provtv/base_ptv_fila5/discussions/204 |
| Story monorepo | `docs/stories/STORY-003-multi-org-sync-geo-boundary-bashscripts.md` |

## Regole rapide

1. `cd` owner → `git remote -v` → fetch tutti → merge senza force → push tutti
2. Dopo edit PHP: phpstan/phpmd/phpinsights scoped (prompt `02-gitmodules-sync.md`)
3. Mai `git restore` — forward-only
4. UI: non reintrodurre `InteractiveMap` (dominio Geo)

## Note owner

## Divergenza: `git-multi-org-sync-handoff.md`

_Fonte: `wiki/integrations/_da-riconciliare/git-multi-org-sync-handoff.divergenza.md`_

# Divergenza: `git-multi-org-sync-handoff.md`

Questo file veniva da `docs/wiki/integrations/modules/lang/git-multi-org-sync-handoff.md`, cancellato dal working tree senza migrazione. Il modulo ha gia' un file con lo stesso nome, ma con **corpo diverso**:

- versione del modulo: `laravel/Modules/Lang/docs/git-multi-org-sync-handoff.md`
- versione recuperata: `laravel/Modules/Lang/docs/wiki/integrations/_da-riconciliare/git-multi-org-sync-handoff.md`

Vanno confrontate e fuse a mano. Quando la fusione e' fatta, questo file e la nota vanno rimossi.

Vedi [XOT-5.39](../../../stories/5.39.wiki-integrations-ownership.story.md).

## Handoff — multi-org sync (STORY-003)

_Fonte: `wiki/integrations/_da-riconciliare/git-multi-org-sync-handoff.md`_

# Handoff — multi-org sync (STORY-003)

## Scopo

Allineare questo owner ai remote raggiungibili (**0 0**, working tree clean) e documentare decisioni di sessione 2026-07-21.

## Perché

Un tree dirty o un remote dietro/avanti **non** è sincronizzato, anche se l’altro org è a posto. Su PTVX i path vivono in `gitmodules.ini` con org `provtv` (+ `laraxot` se esiste).

## Link

| Tipo | URL |
|------|-----|
| Issue owner | https://github.com/provtv/module_lang_fila5/issues/16 |
| Discussion | https://github.com/provtv/<nome repository>/discussions/204 |
| Hub base issue | https://github.com/provtv/<nome repository>/issues/203 |
| Hub base discussion | https://github.com/provtv/<nome repository>/discussions/204 |
| Story monorepo | `docs/stories/STORY-003-multi-org-sync-geo-boundary-bashscripts.md` |

## Regole rapide

1. `cd` owner → `git remote -v` → fetch tutti → merge senza force → push tutti
2. Dopo edit PHP: phpstan/phpmd/phpinsights scoped (prompt `02-gitmodules-sync.md`)
3. Mai `git restore` — forward-only
4. UI: non reintrodurre `InteractiveMap` (dominio Geo)

## Note owner
