---
title: "Correction: Geo — BaseGeoService / GoogleMapsService / GeographicalScopes (No-Services)"
type: correction
updated: 2026-10-20
tags: [geo, docs, no-services, bmad, phpstan]
qmd: "correzione 3 servizi rimossi geo 2026-10-20"
status: draft
---

## Cosa affermava la memoria precedente

Stato precedente (decisioni, merge-conflicts, story, docs storici):
- `BaseGeoService.php`, `GoogleMapsService.php` (`app/Services/`) e `GeographicalScopes.php` (`app/Models/Traits/`) erano considerati "file in conflitto da risolvere" o "classi da correggere" con PHPStan.
- `docs/phpstan.php` e `docs/merge-conflicts-resolution.md` li citavano come file esistenti.

## Cosa è vero ora (evidenza verificata 2026-10-20)

- **`app/Services/` assente** (`find app/Services` → 0 file).
- **`GeographicalScopes.php` assente** (`find app/Models/Traits/GeographicalScopes.php` → 0).
- **`GeoTrait.php` presente** (`ls app/Models/Traits/GeoTrait.php`) — sostituisce le scope.
- **`Actions/` presenti** (`Actions/GoogleMaps/*`, `Actions/GeoData/*`, `Actions/Distance/*`, etc.) — sostituiscono i servizi.
- **Zero riferimenti residui** (`grep -rn 'BaseGeoService\|GoogleMapsService\|GeographicalScopes' app/ tests/` → solo commenti nel codice; nessun `use` né estensione).
- **PHPStan su `Modules/Geo/app`**: 0 errori (verificato con `vendor/bin/phpstan analyse Modules/Geo/app --no-progress`).

## Decisione BMAD

- **Non ricreare i file**: la rimozione è deliberata (regola No-Services, decisione 2026-10-08/20 nel decision-log).
- **Aggiornare i documenti di riferimento** (`INDEX.md`, `merge-conflicts-resolution.md`, `phpstan.md`, `code-quality.md`) per indicare che i file sono eliminati e che le Actions ne sostituiscono il ruolo.
- **Eliminare duplicati `.old`/`.bak`**: già rimossi (0 residui con `find docs/ -name '*.old' -o -name '*.bak'`).
- **No modifica a `phpstan.neon`**: regola AGENTS — solo l'utente modifica la config.

## Link alla storia

[services-to-actions-geo.story.md](./stories/services-to-actions-geo.story.md) — mappa metodo per metodo, prova di equivalenza con 330 confronti uguali e 20 diversi (tutti spiegati).
