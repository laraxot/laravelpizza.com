---
title: audit ridondanza sigma god trait e consumer
module: Sigma
type: audit
status: draft
tags: [redundancy, god-module, schedatrait, decoupling, sigma]
created: "2026-05-27"
updated: "2026-05-27"
related:
  - ../code-redundancy-audit.md
  - ../../Ptv/docs/wiki/ptv-sigma-shared-surface-catalog.md
  - ../../../../Xot/docs/wiki/concepts/ptv-sigma-redundancy-ownership.md
---

# Audit ridondanza — modulo Sigma

> Campagna coordinata: issue monorepo **#162**; issue modulo **#4** (verificare con `git remote -v`).

## Remote Git (issue su `origin`)

```text
origin  git@github.com:provtv/module_sigma_fila5.git
```

Comando: `cd laravel/Modules/Sigma && git remote -v`

## Visione, politica, religione, zen

| Lente | Decisione |
|-------|-----------|
| **Zen** | `SchedaTrait` (~3000 righe) è debito cognitivo — ridurre superficie esposta, non aggiungere metodi. |
| **Visione** | Sigma = **integrazione / sync** con gestionale Sigma + modelli legacy tabellari. |
| **Politica** | Sigma **non** è il cuore HR condiviso del monorepo; i consumer (Ptv, Progressioni, Performance) vanno documentati e decoupled. |
| **Religione** | Vietata dipendenza **Sigma → Ptv** (`HasMyLogs` in `SchedaTrait`) — invertire o spostare in Xot. |
| **Filosofia** | Delegation cascade (`SchedaHelper`, mutators) è buona solo se i delegati hanno owner chiaro. |

## Analisi critica — `SchedaTrait`

| Problema | Evidenza | Azione proposta |
|----------|----------|-----------------|
| God trait | ~2957 righe, 128+ metodi | Censimento + split per bucket ownership |
| Trait orfano | `SchedaExtraFieldTrait` senza `use` nel repo | Valutare delete dopo diff |
| Triplicazione metodi | `getGgCateco*` in Trait / Helper / ExtraField | Consolidare su Helper |
| Dipendenza circolare | `use HasMyLogs` (Ptv) | Spostare trait log in Xot o Sigma |
| Consumer multipli | Ptv, Progressioni, Performance | Vedi catalogo condiviso |

## Consumer documentati

| Modulo | Modello | Trait Sigma |
|--------|---------|-------------|
| **Ptv** | `BaseScheda` | `SchedaTrait`, `EnteMatrDateRangeMutator` |
| **Progressioni** | `Scheda` | `SchedaTrait`, `SigmaModelTrait` (+ conflict `insteadof`) |
| **Performance** | `BaseIndividualeModel` | via Ptv stack / `insteadof` su `gg*Tot` |

Dettaglio metodi referenziati: [../../Ptv/docs/wiki/ptv-sigma-shared-surface-catalog.md](../../Ptv/docs/wiki/ptv-sigma-shared-surface-catalog.md).

## Metriche (da scan locale)

Vedi [code-redundancy-audit.md](../code-redundancy-audit.md): ~923 file PHP, rischio **high**, file giganti in `SchedaTrait`, `SchedaExtraFieldTrait`, `FunctionExtra`, `MassExtra`.

## Piano di azione (solo discussione / docs)

1. [ ] Rimuovere riferimenti Ptv da Sigma (`HasMyLogs`).
2. [ ] Archiviare o fondere `SchedaExtraFieldTrait`.
3. [ ] Completare delegazione Trait → Helper (niente metodi pubblici duplicati).
4. [ ] Estrarre bucket `core-hr` in base condivisa (decisione issue **#162**).

## Collegamenti

- Ptv (consumer principale): [../../Ptv/docs/wiki/redundancy-audit.md](../../Ptv/docs/wiki/redundancy-audit.md)
- Policy ownership: [../../../../Xot/docs/wiki/concepts/ptv-sigma-redundancy-ownership.md](../../../../Xot/docs/wiki/concepts/ptv-sigma-redundancy-ownership.md)
