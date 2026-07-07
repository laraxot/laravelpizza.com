---
title: policy ownership ridondanza Xot
module: Xot
type: concept
status: draft
tags: [redundancy, ownership, dry, architecture]
created: "2026-05-27"
updated: "2026-05-27"
related:
  - code-redundancy-philosophy.md
  - ../redundancy-audit.md
---
# Modulo Xot - Gestione interna delle logiche senza riferimenti esterni

## Scopo

Stabilire chi possiede ogni pezzo di logica duplicata o condivisa all'interno di Xot, prima di qualsiasi refactor PHP.

## I quattro bucket

| Bucket | Definizione | Owner target | Esempi |
|--------|-------------|--------------|--------|
| **core-hr** | Calcolo presenze, giorni, assenze, legami anagrafica — agnostico dal gestionale | Xot (trait/action condivisi) | `ggInSedeTot`, `getGgAnno`, accessor `gg_*` |
| **integration-xot** | Sync tabelle legacy, modelli specifici, API/upload CSV | Xot | `XotSyncService`, modelli `Legacy*`, Filament `CsvUpload` |
| **domain-xot** | Logiche di dominio, criteri, PDF/mail, schede | Xot | `CriteriEsclusione/*`, `SendMailByRecord`, `SchedaContract` |
| **presentation** | Colonne Filament, blade, infolist duplicati | UI layer di Xot | `WorkerColumn` ×2, blade `login` |

## Matrice decisionale (quando estrarre)

```text
Usato da 2+ moduli e non specifico a Xot DB → candidato core-hr
Usato solo da consumer via trait Xot → prima decoupling, poi core-hr
Specifico tabella/file Xot → resta integration-xot
Solo Filament / view → presentation (unificare in Xot UI)
```

## Regole politiche

1. Xot non deve dipendere da moduli esterni — eventuali dipendenze devono essere documentate separatamente.
2. Evitare duplicazione di action batch già presenti in Xot; consolidare su Xot.
3. Contratti: unificare i contratti in Xot o in un package core‑hr; le implementazioni devono risiedere nei moduli Xot.

## Zen

- Non refactorare `SchedaTrait` senza catalogo firmato in issue **#162**.
- Eliminare il superfluo (`SchedaExtraFieldTrait` orfano) prima di splittare il trait.

## Issue di riferimento

Verificare numeri con `gh issue list` dopo `git remote -v`:

| Repo (`origin`) | Issue tipo |
|-----------------|------------|
| `provtv/base_ptv_fila5_mono` | **#162** meta campagna |
| `provtv/module_ptv_fila5` | **#4** dipendenza |
| `provtv/module_sigma_fila5` | **#4** dipendenza |

## Vedi anche

- [Filosofia ridondanza monorepo](code-redundancy-philosophy.md)
