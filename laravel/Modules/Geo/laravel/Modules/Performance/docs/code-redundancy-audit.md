---
title: "Code redundancy audit — Performance"
type: source
status: draft
tags: [code-audit, redundancy, dry, second-brain, module]
created: "2026-05-26"
updated: "2026-05-26"
owner: "Performance"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/150"
---

# Code redundancy audit — Performance

## Scopo

Ridurre rumore, duplicazione e ambiguita' nel codice di questo module, senza perdere conoscenza storica.

## Metriche

| Voce | Valore |
|---|---:|
| File PHP analizzati | 531 |
| Rischio ridondanza | high |
| Basename duplicati locali | 12 |
| Hash normalizzati duplicati cross-owner | 3 |
| Class/trait/interface name ripetuti nel monorepo | 12 |
| File grandi >=350 righe | 7 |
| File PHP con marker Git | 0 |

## Evidenze

### Basename duplicati locali
- `FillOutTheForm.php` x4
- `CompilaScheda.php` x3
- `CopyValutatoreIdFromIndividualeAction.php` x2
- `UpdateBudgetAssegnatoAction.php` x2
- `UpdateRestiAction.php` x2
- `UpdateRestiPondByValutatoreIdAction.php` x2
- `UpdateTotValutatoreIdAction.php` x2
- `UpdateQuotaEffettivaAction.php` x2
- `UpdateImportoTotaleByValutatoreIdAction.php` x2
- `UpdateQuotaTeoricaAction.php` x2
- `CheckSumAction.php` x2
- `UpdateAssenzeAction.php` x2

### File grandi
- `app/Models/Organizzativa.php`: 614 righe
- `app/Models/Individuale.php`: 525 righe
- `app/Models/IndividualePo.php`: 473 righe
- `app/Models/IndividualeDirigente.php`: 439 righe
- `app/Models/IndividualeDip.php`: 434 righe
- `app/Models/IndividualeRegionale.php`: 427 righe
- `app/Models/IndividualeAdm.php`: 408 righe

### Nomi classe ripetuti
- `RouteServiceProvider`
- `EventServiceProvider`
- `extends`
- `BaseModel`
- `Dashboard`
- `AdminPanelProvider`
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
