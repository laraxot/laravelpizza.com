---
title: "Cms — scopo, confini e contratti chiave"
type: concept
module: Cms
status: active
created: 2026-10-20
updated: 2026-10-20
tags: [scopo, cms, folio, blocks, filament-builder, json, i18n]
qmd: "scopo cms pagine folio blocchi json filament builder resolve page safe helpers"
related:
  - ./00-index.md
  - ./README.md
  - ./actions/page-resolution-pipeline.md
  - ./content-blocks-architecture.md
  - ./safe.md
  - ./bmad/livewire-inventory.md
  - ./stories/12.1.cms-page-show-not-widget.story.md
  - ./stories/phpstan-test-wave-cms.story.md
  - ./stories/phpstan-wave2-constant-type-coverage.story.md
  - ../../Xot/docs/bmad/livewire-to-filament-widgets-inventory.md
---

# Cms — scopo, confini e contratti chiave

Ingresso: [00-INDEX.md](./00-index.md) · stato misurato: [README.md](./README.md).

## Perché esiste

> **Cms decide *cosa* è una pagina pubblica e *come* è composta (JSON + blocchi), non come è vestita.**
> Il tema (Folio/Volt/Blade) monta le rotte e rende; Cms risolve contenuto e schema.

Tre mestieri, un solo modulo:

| Mestiere | Contratto | Dove |
|---|---|---|
| Risolvere la pagina | `(container0, slug0)` → modello dinamico o `Page` JSON | [page-resolution-pipeline.md](./actions/page-resolution-pipeline.md) |
| Comporre i blocchi | Filament Builder → JSON tenant → `BlockData` → Blade tema | [content-blocks-architecture.md](./content-blocks-architecture.md), [header-nav-block-architecture.md](./wiki/concepts/header-nav-block-architecture.md) |
| Localizzare i link nei blocchi | URL "nudi" nel JSON → prefisso locale a runtime | `ResolveLocalizedBlockDataAction` (stesso pipeline) |

Non esistono (e non vanno reinventati nei test): `PageService`/`BlockService`, modello Eloquent `Block` con tabelle SQL, factory su `pages.status`. I modelli `Page`/`Section`/`Menu` leggono JSON per tenant (`SushiToJsons`).

## Perché Filament Builder sui blocchi

L'admin non edita HTML: edita **schema tipizzato** (repeater, toggle, select). Il Builder scrive JSON che il FO legge senza deploy di codice. Esempio vivo: [headernavblock-filament-builder.md](./wiki/concepts/headernavblock-filament-builder.md) (`header.json` → `<x-section slug="header" />`).

I test (`FilamentBuilderBlocksTest` e simili) devono verificare **scoperta classi blocco + chiavi schema**, non tabelle inventate: vedi [phpstan-test-wave-cms.story.md](./stories/phpstan-test-wave-cms.story.md).

## Perché Safe nei test / I/O JSON

Cms tocca filesystem e JSON di tenant. Le funzioni native che tornano `false` nascondono errori di path/decode: `thecodingmachine/safe` le trasforma in eccezioni tipizzate. Contratto operativo: [safe.md](./safe.md). Nei test serve tipizzare path/contenuto così PHPStan non tratta `string|false` come successo silenzioso.

## Confini

- **Si**: Actions `*Action` queueable, Filament Resource/Builder, `BlockData`, middleware slug, integrazione Folio del tema.
- **No**: logica di brand/CSS nel modulo; controller `web.php` per pagine pubbliche; duplicare lo switcher lingua (è di [Lang](../../Lang/docs/scopo.md)); convertire `Page\Show` in widget KPI (resta **KEEP FO**).

## Livewire `Page\Show` — perche' KEEP FO

`Http/Livewire/Page/Show` rende una pagina CMS intera (slug → title/body/blocks). Non e' chrome di panel: la fleet classifica **KEEP FO Folio** in [Xot inventory](../../Xot/docs/bmad/livewire-to-filament-widgets-inventory.md); il modulo conferma in [bmad/livewire-inventory.md](./bmad/livewire-inventory.md) + story [12.1](./stories/12.1.cms-page-show-not-widget.story.md). Planning campagna = ready-for-dev; i testi legali User (`TermsOfService`/`PrivacyPolicy`) sono **REUSE** widget, non KEEP generico.

## Collegamenti

- [00-INDEX.md](./00-index.md)
- [wiki/scopo.md](./wiki/scopo.md) — stub verso questo file
- [Lang — scopo](../../Lang/docs/scopo.md) — i18n e locale switcher
- [Themes/Zero — README](../../../Themes/Zero/docs/README.md) — presentazione FO
- Wave2 costanti: [stories/phpstan-wave2-constant-type-coverage.story.md](./stories/phpstan-wave2-constant-type-coverage.story.md) (`analyse Modules/Cms` → 0)
- Fleet Livewire→Widget: [Xot inventory](../../Xot/docs/bmad/livewire-to-filament-widgets-inventory.md)
