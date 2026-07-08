---
title: audit ridondanza ptv e dipendenze sigma
module: Ptv
type: audit
status: draft
tags: [redundancy, dependency, sigma, progressioni, ptv]
created: "2026-05-27"
updated: "2026-05-27"
related:
  - ../code-redundancy-audit.md
  - ptv-sigma-shared-surface-catalog.md
  - ../../../../Xot/docs/wiki/concepts/ptv-sigma-redundancy-ownership.md
---

# Audit ridondanza — modulo Ptv

> Campagna coordinata: issue monorepo **#162** (verificare con `git remote -v` + `gh issue list` sul repo `origin`).

## Remote Git (issue su `origin`)

```text
origin  git@github.com:provtv/module_ptv_fila5.git
```

Comando: `cd laravel/Modules/Ptv && git remote -v`

## Visione, politica, religione, zen

| Lente | Decisione |
|-------|-----------|
| **Zen** | Togliere dipendenze non necessarie prima di estrarre nuove astrazioni. |
| **Visione** | Ptv = dominio **valutazione / schede / criteri / workflow Filament**; non owner del calcolo presenze HR grezzo. |
| **Politica** | Ptv può **consumare** dati HR via contratti; non deve **ospitare** la logica Sigma nel proprio namespace. |
| **Religione** | Un owner per concetto ([filosofia ridondanza Xot](../../../../Xot/docs/wiki/concepts/code-redundancy-philosophy.md)). |
| **Filosofia** | `SchedaTrait` in Sigma è debito ereditato per accesso storico presenze — da censire, non da ignorare. |

## Dipendenze esterne (confini)

| Modulo | Artefatti in `BaseScheda` | Ruolo |
|--------|---------------------------|--------|
| **Sigma** | `SchedaTrait`, `EnteMatrDateRangeMutator` | Calcolo/accessor schede HR |
| **Progressioni** | `ConvertedTrait` | Conversioni dominio progressioni |
| **Sigma (modelli)** | `Anag`, `Rep00f`, `Repart`, `Integparam`, … | Lookup anagrafica |

Import morto da rimuovere in fase refactor: `SigmaModelTrait` (solo in `use` import, non nel blocco trait).

## Ridondanze interne Ptv (priorità)

Vedi [code-redundancy-audit.md](../code-redundancy-audit.md). Evidenze ad alta priorità:

- Coppie Cessati con/senza suffisso `Action`
- `ListScheda` / `ListSchedas`
- Doppio `StabiDirigenteContract` (`app/Contracts` vs `Models/Contracts`)
- Colonne duplicate `Columns/` vs `Tables/Columns/`
- Action batch duplicate con **Performance** (`UpdateGgAnnoAction`, `CheckSumAction`, …)

## Superficie condivisa Ptv ↔ Sigma

Catalogo metodi, contratti e consumer: [ptv-sigma-shared-surface-catalog.md](ptv-sigma-shared-surface-catalog.md).

Policy ownership (4 bucket): [ptv-sigma-redundancy-ownership.md](../../../../Xot/docs/wiki/concepts/ptv-sigma-redundancy-ownership.md).

## Piano di azione (solo discussione / docs)

1. [ ] Completare censimento accessor usati da Filament (oltre alle chiamate esplicite a metodi trait).
2. [ ] Allineare `SchedaContract` Ptv vs Sigma vs target in Xot / HR-core.
3. [ ] Spostare logica `core-hr` fuori da Ptv dopo decisione in issue **#162** e modulo **#4**.
4. [ ] Consolidare action batch duplicate Ptv/Performance.

## Collegamenti

- Sigma (ponte): [../../Sigma/docs/wiki/redundancy-audit.md](../../Sigma/docs/wiki/redundancy-audit.md)
- Audit trasversale Xot: [../../../../Xot/docs/wiki/redundancy-audit.md](../../../../Xot/docs/wiki/redundancy-audit.md)
