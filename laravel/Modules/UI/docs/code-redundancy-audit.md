---
title: "Code redundancy audit — UI"
type: source
status: draft
tags: [code-audit, redundancy, dry, second-brain, module]
created: "2026-05-26"
updated: "2026-05-26"
owner: "UI"
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/150"
---

# Code redundancy audit — UI

## Scopo

Ridurre rumore, duplicazione e ambiguita' nel codice di questo module, senza perdere conoscenza storica.

## Metriche

| Voce | Valore |
|---|---:|
| File PHP analizzati | 410 |
| Rischio ridondanza | high |
| Basename duplicati locali | 12 |
| Hash normalizzati duplicati cross-owner | 20 |
| Class/trait/interface name ripetuti nel monorepo | 12 |
| File grandi >=350 righe | 7 |
| File PHP con marker Git | 0 |

## Evidenze

### Basename duplicati locali
- `UserData.php` x2
- `Category.php` x2
- `TableLayoutTrait.php` x2
- `DarkModeSwitcher.php` x2
- `empty.blade.php` x4
- `studio-selector.blade.php` x2
- `master.blade.php` x2
- `nav-link.blade.php` x2
- `dark-mode-switcher.blade.php` x2
- `icon.blade.php` x2
- `accordion.blade.php` x2
- `v1.blade.php` x13

### File grandi
- `resources/views/components/blocks/pricing/three_tiers_with_feature_comparison.blade.php`: 1175 righe
- `resources/views/components/blocks/pricing/archivied/three_tiers_on_brand_and_feature_comparison.blade.php`: 1168 righe
- `resources/views/components/blocks/pricing/with_comparison_table_on_dark.blade.php`: 604 righe
- `resources/views/components/blocks/pricing/with_comparison_table.blade.php`: 604 righe
- `resources/views/livewire/components/map/interactive-map.blade.php`: 454 righe
- `app/Filament/Forms/Components/LocationSelector.php`: 413 righe
- `app/Livewire/Components/Map/InteractiveMap.php`: 368 righe

### Nomi classe ripetuti
- `RouteServiceProvider`
- `EventServiceProvider`
- `BaseModel`
- `Dashboard`
- `AdminPanelProvider`
- `name`
- `and`
- `Post`
- `ThemeComposer`
- `Test`
- `not`
- `for`

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
