---
title: "Code redundancy audit — Ptv"
type: source
status: draft
tags: [code-audit, redundancy, dry, second-brain, module]
created: "2026-05-26"
updated: "2026-05-27"
owner: "Ptv"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/162"
related:
  - wiki/redundancy-audit.md
  - wiki/ptv-sigma-shared-surface-catalog.md
---

# Code redundancy audit — Ptv

## Scopo

Ridurre rumore, duplicazione e ambiguita' nel codice di questo module, senza perdere conoscenza storica.

## Ptv ↔ Sigma (superficie condivisa)

| Documento | Contenuto |
|-----------|-----------|
| [wiki/redundancy-audit.md](wiki/redundancy-audit.md) | Visione, dipendenze, piano |
| [wiki/ptv-sigma-shared-surface-catalog.md](wiki/ptv-sigma-shared-surface-catalog.md) | Catalogo contratti, trait, metodi |
| [Policy ownership (Xot)](../Xot/docs/wiki/concepts/ptv-sigma-redundancy-ownership.md) | Bucket core-hr / integration / domain / presentation |

Issue modulo: aprire/commentare su repo `origin` (`git remote -v` in `laravel/Modules/Ptv`) — **#4**.

## Metriche

| Voce | Valore |
|---|---:|
| File PHP analizzati | 273 |
| Rischio ridondanza | medium |
| Basename duplicati locali | 12 |
| Hash normalizzati duplicati cross-owner | 5 |
| Class/trait/interface name ripetuti nel monorepo | 12 |
| File grandi >=350 righe | 0 |
| File PHP con marker Git | 0 |

## Evidenze

### Basename duplicati locali
- `StabiDirigenteContract.php` x2
- `WorkerSection.php` x2
- `PeriodoColumn.php` x2
- `WorkerColumn.php` x2
- `RepColumn.php` x2
- `CreateStabiDirigente.php` x2
- `EditStabiDirigente.php` x2
- `ListStabiDirigentes.php` x2
- `pdf.blade.php` x2
- `intestazione.blade.php` x2
- `firma.blade.php` x2
- `stabi_repar_anno.blade.php` x3

### File grandi
- Nessuno sopra soglia.

### Nomi classe ripetuti
- `RouteServiceProvider`
- `EventServiceProvider`
- `extends`
- `BaseModel`
- `Dashboard`
- `AdminPanelProvider`
- `if`
- `Profile`
- `BaseMorphPivot`
- `ProfilePolicy`
- `ProfileFactory`
- `CategoriaPropro`

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
