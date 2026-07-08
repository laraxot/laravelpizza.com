---
title: "Code redundancy audit — IndennitaResponsabilita"
type: source
status: draft
tags: [code-audit, redundancy, dry, second-brain, module]
created: "2026-05-26"
updated: "2026-05-26"
owner: "IndennitaResponsabilita"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/150"
---

# Code redundancy audit — IndennitaResponsabilita

## Scopo

Ridurre rumore, duplicazione e ambiguita' nel codice di questo module, senza perdere conoscenza storica.

## Metriche

| Voce | Valore |
|---|---:|
| File PHP analizzati | 200 |
| Rischio ridondanza | high |
| Basename duplicati locali | 11 |
| Hash normalizzati duplicati cross-owner | 7 |
| Class/trait/interface name ripetuti nel monorepo | 12 |
| File grandi >=350 righe | 4 |
| File PHP con marker Git | 0 |

## Evidenze

### Basename duplicati locali
- `pdf.blade.php` x32
- `compila.blade.php` x5
- `inner_page.blade.php` x4
- `mass_mail_lett_i.blade.php` x4
- `report.blade.php` x4
- `compila_lett_i.blade.php` x2
- `pdf_all.blade.php` x2
- `mass_mail_lett_f.blade.php` x4
- `firma.blade.php` x6
- `head.blade.php` x6
- `compila_lett_f.blade.php` x2

### File grandi
- `app/Models/LettI.php`: 749 righe
- `app/Models/LettF.php`: 655 righe
- `app/Models/IndennitaResponsabilita.php`: 437 righe
- `app/Filament/Resources/IndennitaResponsabilitaResource/Pages/CompilaIndennitaResponsabilita.php`: 420 righe

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
