---
title: "Code redundancy audit — Sigma"
type: source
status: draft
tags: [code-audit, redundancy, dry, second-brain, module]
created: "2026-05-26"
updated: "2026-05-27"
owner: "Sigma"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/162"
related:
  - wiki/redundancy-audit.md
  - ../Ptv/docs/wiki/ptv-sigma-shared-surface-catalog.md
---

# Code redundancy audit — Sigma

## Scopo

Ridurre rumore, duplicazione e ambiguita' nel codice di questo module, senza perdere conoscenza storica.

## Consumer e superficie condivisa

| Modulo consumer | Uso principale |
|-----------------|----------------|
| **Ptv** | `BaseScheda` → `SchedaTrait` |
| **Progressioni** | `Scheda` + conflict `SigmaModelTrait` |
| **Performance** | `BaseIndividualeModel` → metodi `gg*Tot` |

| Documento | Contenuto |
|-----------|-----------|
| [wiki/redundancy-audit.md](wiki/redundancy-audit.md) | God trait, piano decoupling |
| [Catalogo Ptv↔Sigma](../Ptv/docs/wiki/ptv-sigma-shared-surface-catalog.md) | Metodi e contratti |
| [Policy ownership (Xot)](../Xot/docs/wiki/concepts/ptv-sigma-redundancy-ownership.md) | Matrice decisionale |

Issue modulo: repo `origin` — **#4** (`SchedaTrait`).

## Metriche

| Voce | Valore |
|---|---:|
| File PHP analizzati | 923 |
| Rischio ridondanza | high |
| Basename duplicati locali | 6 |
| Hash normalizzati duplicati cross-owner | 3 |
| Class/trait/interface name ripetuti nel monorepo | 12 |
| File grandi >=350 righe | 8 |
| File PHP con marker Git | 0 |

## Evidenze

### Basename duplicati locali
- `WebService.php` x2
- `index.blade.php` x4
- `edit.blade.php` x2
- `upload_csv_sigma.blade.php` x4
- `web_service.blade.php` x5
- `raw_csv_sigma.blade.php` x4

### File grandi
- `app/Models/Traits/SchedaTrait.php`: 2957 righe
- `app/Models/Traits/SchedaExtraFieldTrait.php`: 2623 righe
- `app/Models/Traits/Extras/MassExtra.php`: 1801 righe
- `app/Models/Traits/Extras/FunctionExtra.php`: 1033 righe
- `app/Models/Qua00f.php`: 990 righe
- `app/Models/Traits/Helpers/SchedaHelper.php`: 751 righe
- `app/Models/Traits/Mutators/SchedaMutator.php`: 731 righe
- `app/Models/Asz00k1.php`: 620 righe

### Nomi classe ripetuti
- `RouteServiceProvider`
- `EventServiceProvider`
- `extends`
- `BaseModel`
- `Dashboard`
- `AdminPanelProvider`
- `name`
- `FilamentMiddleware`
- `for`
- `Modules`
- `SchedaContract`
- `DownloadAction`

## Consigli

- Unificare codice uguale in classi base Xot, trait o action riusabili.
- Prima di estrarre astrazioni, verificare se la duplicazione rappresenta differenze di dominio reali.
- Spostare decisioni stabili nel wiki owner; lasciare nei docs solo puntatori DRY.

## Dubbi e perplessita

- Alcuni duplicati possono essere intenzionali per isolamento modulare.
- I file grandi non sono automaticamente sbagliati: sono priorita' di review, non condanne.
- Evitare refactor globali senza test o issue dedicata.

## Zen, politica, religione, filosofia

- Zen: togliere il superfluo prima di inventare architettura.
- Politica: ogni modulo deve custodire il proprio confine; la base comune non deve diventare dominio nascosto.
- Religione: DRY e KISS sono dogmi utili solo se servono lo scopo.
- Filosofia: il codice e' memoria operativa; la documentazione spiega perche' esiste.

## Second Brain 2026 — note operative

- Markdown locale + Git restano la base piu' portabile: gli agenti leggono/scrivono file senza database esterni.
- AGENTS.md/SKILL.md devono restare manifest leggeri, con YAML/front matter e routing on-demand.
- I descrittori architetturali navigabili riducono i passi di localizzazione: ogni owner dovrebbe avere mappa scopo -> file chiave.
- AI utile = recupero mirato, non pre-caricamento: report atomici, QMD, issue e log.

## Prossimo passo

Aprire issue mirata per i primi 3 file grandi o per il duplicato cross-owner piu' evidente, poi validare con PHPStan/PHPMD/PHPInsights se si modifica codice.
