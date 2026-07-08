---
title: "Code redundancy audit — One"
type: source
status: draft
tags: [code-audit, redundancy, dry, second-brain, theme]
created: "2026-05-26"
updated: "2026-05-26"
owner: "One"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/150"
---

# Code redundancy audit — One

## Scopo

Ridurre rumore, duplicazione e ambiguita' nel codice di questo theme, senza perdere conoscenza storica.

## Metriche

| Voce | Valore |
|---|---:|
| File PHP analizzati | 19 |
| Rischio ridondanza | high |
| Basename duplicati locali | 3 |
| Hash normalizzati duplicati cross-owner | 19 |
| Class/trait/interface name ripetuti nel monorepo | 0 |
| File grandi >=350 righe | 0 |
| File PHP con marker Git | 0 |

## Evidenze

### Basename duplicati locali
- `app.blade.php` x2
- `login.blade.php` x2
- `main.blade.php` x2

### File grandi
- Nessuno sopra soglia.

### Nomi classe ripetuti
- Nessuno nel campione.

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

## Moduli Ptv / Sigma (puntatore DRY)

Il tema **non** duplica la logica HR. Decisioni e catalogo:

- [Ptv — audit ridondanza](../../../Modules/Ptv/docs/wiki/redundancy-audit.md)
- [Catalogo superficie Ptv↔Sigma](../../../Modules/Ptv/docs/wiki/ptv-sigma-shared-surface-catalog.md)
- [Policy ownership (Xot)](../../../Modules/Xot/docs/wiki/concepts/ptv-sigma-redundancy-ownership.md)

Issue tema: repo `origin` — **#5** (blade). Campagna mono: **#162**.

## Prossimo passo

Aprire issue mirata per i primi 3 file grandi o per il duplicato cross-owner piu' evidente, poi validare con PHPStan/PHPMD/PHPInsights se si modifica codice.
