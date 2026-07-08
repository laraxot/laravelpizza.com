---
title: catalogo superficie condivisa ptv sigma
module: Ptv
type: catalog
status: draft
tags: [redundancy, catalog, schedatrait, schedacontract, ptv, sigma]
created: "2026-05-27"
updated: "2026-05-27"
related:
  - redundancy-audit.md
  - ../../../../Xot/docs/wiki/concepts/ptv-sigma-redundancy-ownership.md
  - ../../Sigma/docs/wiki/redundancy-audit.md
---

# Catalogo superficie condivisa Ptv ↔ Sigma

## Scopo

Inventario **ripetibile** di contratti, trait e metodi tra `Ptv` e `Sigma` (più consumer), con bucket ownership e motivazione.

> Scan metodi: `SchedaTrait` espone **128** funzioni; le chiamate **esplicite** nel codice Ptv sono poche — la maggior parte dell’uso è via **accessor Eloquent** (`$scheda->gg_in_sede`). Estendere il censimento Filament in issue **#162**.

## Contratti duplicati

| Simbolo | Path Ptv | Path Sigma | Bucket | Perché esiste | Owner proposto |
|---------|----------|------------|--------|---------------|----------------|
| `SchedaContract` | `app/Models/Contracts/SchedaContract.php` | `app/Contracts/SchedaContract.php` | domain-ptv / core-hr | Ptv definisce API scheda valutazione; Sigma ha stub vuoto | Contratto unificato in **Xot** |
| `ProgressioneSchedaContract` | **rimosso** (2026-06-15) | Consolidato in `SchedaContract` | domain-ptv | Superfluo: Scheda estende BaseScheda che implementa SchedaContract | **Dep** |

## Accoppiamento trait (hard dependency)

| Consumer | File | Trait / import Sigma |
|----------|------|----------------------|
| **Ptv** | `app/Models/BaseScheda.php` | `SchedaTrait`, `EnteMatrDateRangeMutator` |
| **Progressioni** | `app/Models/Scheda.php` | `SchedaTrait`, `SigmaModelTrait` (+ `insteadof`) |
| **Performance** | `app/Models/BaseIndividualeModel.php` | Risoluzione conflitti su metodi `gg*Tot` da stack Sigma |

## Metodi `SchedaTrait` — riferimenti espliciti nel codice

### Modules/Ptv (7 simboli)

| Metodo | File esempio | Bucket |
|--------|--------------|--------|
| `ggInSedeTot` | `BaseScheda.php` (commenti eager load) | core-hr |
| `ggFuoriSedeTot` | idem | core-hr |
| `ggAssenzaInSedeTot` | idem | core-hr |
| `hhAssenzaInSedeTot` | idem | core-hr |
| `getValutatoreIdAttribute` | `Actions/FixValutatoreIdByAnno.php` | domain-ptv |
| `perfIndMedia` | `Filament/.../MakePdfAction.php` | domain-ptv |
| `getCriteriOptions` | `Filament/Resources/BaseSchedaResource.php` | domain-ptv |

### Modules/Progressioni (20 simboli — estratto)

| Metodo | Bucket | Nota |
|--------|--------|------|
| `ggInSedeTot`, `ggFuoriSedeTot`, `ggAssenza*Tot`, `hhAssenza*Tot` | core-hr | Conflict resolution con `SigmaModelTrait` |
| `getGgAttribute`, `getGgAszAttribute`, `getGgNoAszAttribute` | core-hr | Modelli progressioni |
| `getAventiDiritto*`, `getPuntProgressioneFinaleAttribute` | domain-ptv / core-hr | Valutazione progressioni |
| `criteriOptionsArr` | domain-ptv | View + trait progressioni |

### Modules/Performance (12 simboli — estratto)

| Metodo | Bucket |
|--------|--------|
| `ggInSedeTot`, `ggFuoriSedeTot`, `ggAssenza*Tot`, `hhAssenza*Tot` | core-hr |
| `getGgPresenzaAnnoAttribute`, `getGgAssenzaAnnoAttribute` | core-hr |
| `getAventiDiritto*` | core-hr |
| `criteriOptionsArr` | domain-ptv |

## Duplicati intra-Sigma (da risolvere in Sigma)

| Simbolo | Occorrenze | Perché | Owner |
|---------|------------|--------|-------|
| `SchedaExtraFieldTrait` | ~2623 righe, **nessun use** | Fork storico / evacuazione incompleta | **Sigma** — delete candidate |
| `getGgCatecoPosfun*` | Trait + Helper + ExtraField | Migrazione accessor incompleta | **Sigma** → Helper |
| `UpdateGgAnnoAction` | Ptv + Performance (stesso corpo) | Batch anno condiviso | **Ptv** o **Xot** action |

## Duplicati intra-Ptv (non Sigma, stesso dominio)

| Area | Esempi | Bucket |
|------|--------|--------|
| Cessati | `GetCessatiRecords` vs `GetCessatiRecordsAction` | domain-ptv |
| Filament pages | `ListScheda` / `ListSchedas` | presentation |
| Contracts | `StabiDirigenteContract` ×2 namespace | domain-ptv |
| Colonne | `WorkerColumn` in `Columns/` e `Tables/Columns/` | presentation |

## Dipendenza inversa (violazione politica)

| Da | A | Artefatto |
|----|---|-----------|
| **Sigma** `SchedaTrait` | **Ptv** | `HasMyLogs` |

Azione: spostare `HasMyLogs` in **Xot** o **Sigma**; rimuovere import Ptv da Sigma.

## Accessor ad alta energia (censimento manuale richiesto)

Proprietà documentate su `BaseScheda` provenienti da calcolo Sigma (non exhaustive):

`gg_in_sede`, `gg_fuori_sede`, `gg_presenza_anno`, `gg_cateco_posfun_in_sede`, `gg_asz_cateco_posfun`, `perc_parttime_anno`, `anag`, …

→ Classificare in issue modulo Ptv **#4** per priorità refactor.

## Ripetere lo scan

```bash
cd laravel && node tools/ptv-sigma-scheda-trait-usage.mjs
```

## Collegamenti

- [Audit Ptv](redundancy-audit.md)
- [Audit Sigma](../../Sigma/docs/wiki/redundancy-audit.md)
- [Policy ownership](../../../../Xot/docs/wiki/concepts/ptv-sigma-redundancy-ownership.md)
