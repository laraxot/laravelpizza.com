---
title: "Code redundancy audit — IndennitaCondizioniLavoro"
type: source
status: draft
tags: [code-audit, redundancy, dry, second-brain, module]
created: "2026-05-26"
updated: "2026-05-26"
owner: "IndennitaCondizioniLavoro"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/150"
---

# Code redundancy audit — IndennitaCondizioniLavoro

## Scopo

Ridurre rumore, duplicazione e ambiguita' nel codice di questo module, senza perdere conoscenza storica.

## Metriche

| Voce | Valore |
|---|---:|
| File PHP analizzati | 208 |
| Rischio ridondanza | high |
| Basename duplicati locali | 12 |
| Hash normalizzati duplicati cross-owner | 6 |
| Class/trait/interface name ripetuti nel monorepo | 12 |
| File grandi >=350 righe | 2 |
| File PHP con marker Git | 0 |

## Evidenze

### Basename duplicati locali
- `index.blade.php` x27
- `compila.blade.php` x4
- `scheda_pdf.blade.php` x4
- `trimestre_filter.blade.php` x2
- `dettaglio.blade.php` x20
- `edit.blade.php` x14
- `inner_page.blade.php` x4
- `pdf.blade.php` x26
- `edit4_trim.blade.php` x4
- `edit_trim.blade.php` x4
- `edit3_trim.blade.php` x4
- `edit2_trim.blade.php` x4

### File grandi
- `app/Models/CondizioniLavoro.php`: 851 righe
- `app/Models/ServizioEsterno.php`: 728 righe

### Nomi classe ripetuti
- `RouteServiceProvider`
- `EventServiceProvider`
- `BaseModel`
- `Dashboard`
- `AdminPanelProvider`
- `BasePivot`
- `CategoriaPropro`
- `StabiDirigente`
- `StabiDirigenteResource`
- `CreateStabiDirigente`
- `EditStabiDirigente`
- `ListStabiDirigentes`

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
