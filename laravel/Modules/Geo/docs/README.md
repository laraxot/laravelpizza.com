---
title: Geo — documentazione del modulo
type: readme
status: active
module: Geo
updated: 2026-10-20
tags: [docs, geo, readme]
qmd: "geo modulo geocoding indirizzi comuni mappe actions no-services scopo"
related:
  - ./scopo.md
  - ./index.md
  - ./00-index.md
  - ./decision-log.md
  - ./architecture/actions-over-services.md
  - ./stories/services-zombie-delete-wave3.story.md
  - ../../Xot/docs/conventions/docs-organization.md
---

# Geo: documentazione

Ingresso attivo del modulo. Convenzione: [docs-organization](../../Xot/docs/conventions/docs-organization.md).

## Perche'

Geo possiede geolocalizzazione e dati geografici riusabili (geocoding multi-provider,
comuni JSON, componenti Filament indirizzo/mappa). I moduli foglia consumano
**Actions**, non provider grezzi ne' `app/Services/`.

Dettaglio: [scopo.md](./scopo.md).

## Navigazione

| Percorso | Ruolo |
|----------|--------|
| [scopo.md](./scopo.md) | perche' esiste |
| [documentation-index.md](./documentation-index.md) | catalogo esteso del modulo |
| [index.md](./index.md) | indice PTVX (stale, non del modulo) |
| [00-index.md](./00-index.md) | alias storico verso questo README |
| [decision-log.md](./decision-log.md) | decisioni |
| [architecture/actions-over-services.md](./architecture/actions-over-services.md) | Actions > Services |
| [stories/services-zombie-delete-wave3.story.md](./stories/services-zombie-delete-wave3.story.md) | delete-again Services |
| [stories/blade-i18n-no-hardcoded-text.story.md](./stories/blade-i18n-no-hardcoded-text.story.md) | niente testi fissi nelle Blade (it, en, de, es) |
| [best-practices.md](./best-practices.md) | pratiche (canon kebab; stub `BEST_PRACTICES.md`) |
| [json-database.md](./json-database.md) / [json-usage.md](./json-usage.md) | JSON comuni |
| [address-resource-improvements.md](./address-resource-improvements.md) | AddressResource (stub sugli alias underscore/camel) |

## Gate

- Nessuna cartella `app/Services/` (religione no-services).
- PHPStan: solo `laravel/phpstan.neon` (`analyse Modules`).
- Filament: componenti `XotBase*` / form Geo; logica in Actions.
